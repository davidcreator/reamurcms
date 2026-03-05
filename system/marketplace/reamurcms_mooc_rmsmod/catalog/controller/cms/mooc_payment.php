<?php
namespace Reamur\Catalog\Controller\Cms;

class MoocPayment extends \Reamur\System\Engine\Controller {
    public function checkout(): void {
        $this->load->language('cms/mooc');
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('cms/mooc_payment.checkout', 'course_id=' . ($this->request->get['course_id'] ?? 0));
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $course_id = (int)($this->request->get['course_id'] ?? 0);
        $this->load->model('cms/mooc');
        $course = $this->model_cms_mooc->getCourse($course_id);
        if (!$course) {
            $this->response->redirect($this->url->link('cms/mooc'));
            return;
        }
        if ($course['is_free']) {
            $this->response->redirect($this->url->link('cms/mooc.enroll', 'course_id=' . $course_id));
            return;
        }
        $data['course'] = $course;
        $data['text_payment_methods'] = $this->language->get('text_payment_methods');
        $data['text_pay_now'] = $this->language->get('text_pay_now');
        $data['text_price'] = $this->language->get('text_price');
        $data['text_free'] = $this->language->get('text_free');
        $data['text_buy_course'] = $this->language->get('text_buy_course');
        $data['action'] = $this->url->link('cms/mooc_payment.pay', 'course_id=' . $course_id);
        $data['methods'] = [
            ['code' => 'stripe', 'title' => 'Stripe (cartão / wallets)'],
            ['code' => 'mercadopago', 'title' => 'Mercado Pago (Pix/Boleto/Cartão)']
        ];
        $this->response->setOutput($this->load->view('cms/mooc_checkout', $data));
    }

    public function pay(): void {
        $this->load->language('cms/mooc');
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('cms/mooc_payment.checkout', 'course_id=' . ($this->request->get['course_id'] ?? 0));
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $course_id = (int)($this->request->get['course_id'] ?? 0);
        $method = $this->request->post['method'] ?? 'stripe';
        $this->load->model('cms/mooc');
        $this->load->model('cms/mooc_payment');
        $this->load->model('cms/mooc_enrollment');
        $this->load->model('checkout/gateway');

        $course = $this->model_cms_mooc->getCourse($course_id);
        if (!$course || $course['is_free']) {
            $this->response->redirect($this->url->link('cms/mooc'));
            return;
        }
        $split = $this->db->query("SELECT instr.stripe_account_id, instr.mp_user_id, instr.payout_share FROM `" . DB_PREFIX . "mooc_course_instructor` ci
            JOIN `" . DB_PREFIX . "mooc_instructor` instr ON instr.instructor_id = ci.instructor_id
            WHERE ci.course_id = '" . (int)$course_id . "' AND (instr.stripe_account_id <> '' OR instr.mp_user_id <> '') LIMIT 1")->row;
        $payout_share = (float)($split['payout_share'] ?? 80);
        $platform_fee = max(0, min(100, 100 - $payout_share));
        $paid = $this->model_cms_mooc_payment->getPaidForCourse($course_id, $this->customer->getId());
        if (!$paid) {
            $payment_id = $this->model_cms_mooc_payment->create($course_id, $this->customer->getId(), $method, (float)$course['price']);
            $success = $this->url->link('cms/mooc_payment.success', 'payment_id=' . $payment_id . '&method=' . $method, true);
            $cancel = $this->url->link('cms/mooc_payment.checkout', 'course_id=' . $course_id, true);
            if ($method === 'stripe') {
                $checkout = $this->model_checkout_gateway->createStripeCheckout((float)$course['price'], 'BRL', $course['title'], $success . '&session_id={CHECKOUT_SESSION_ID}', $cancel, $split['stripe_account_id'] ?? '', $platform_fee);
                if (!empty($checkout['id'])) {
                    $this->db->query("UPDATE `" . DB_PREFIX . "mooc_payment` SET transaction_ref='" . $this->db->escape($checkout['id']) . "' WHERE payment_id='" . (int)$payment_id . "'");
                    $this->response->redirect($checkout['url'] ?? $cancel);
                    return;
                }
            } elseif ($method === 'mercadopago') {
                $pref = $this->model_checkout_gateway->createMpPreference((float)$course['price'], 'BRL', $course['title'], $success . '&preference_id={PREF_ID}', $cancel, $split['mp_user_id'] ?? '', $platform_fee);
                if (!empty($pref['id'])) {
                    $this->db->query("UPDATE `" . DB_PREFIX . "mooc_payment` SET transaction_ref='" . $this->db->escape($pref['id']) . "' WHERE payment_id='" . (int)$payment_id . "'");
                    $this->response->redirect($pref['init_point'] ?? $cancel);
                    return;
                }
            }
            // fallback para não travar fluxo
            $this->model_cms_mooc_payment->markPaid($payment_id, strtoupper($method) . '-' . $payment_id);
        }
        $this->model_cms_mooc_enrollment->enroll($course_id, $this->customer->getId());
        $this->session->data['success'] = $this->language->get('text_payment_success');
        $this->response->redirect($this->url->link('cms/mooc.info', 'course_id=' . $course_id));
    }

    public function success(): void {
        $this->load->model('cms/mooc_payment');
        $this->load->model('checkout/gateway');
        $this->load->model('cms/mooc_enrollment');
        $this->load->language('cms/mooc');

        $payment_id = (int)($this->request->get['payment_id'] ?? 0);
        $method = $this->request->get['method'] ?? '';
        $payment = $payment_id ? $this->model_cms_mooc_payment->getPayment($payment_id) : [];
        if (!$payment) {
            $this->response->redirect($this->url->link('cms/mooc'));
            return;
        }
        $course_id = (int)$payment['course_id'];
        $customer_id = (int)$payment['customer_id'];

        $ok = false;
        if ($method === 'stripe') {
            $session_id = $this->request->get['session_id'] ?? ($payment['transaction_ref'] ?? '');
            if ($session_id) {
                $ok = $this->model_checkout_gateway->verifyStripeSession($session_id);
            }
        } elseif ($method === 'mercadopago') {
            $pref_id = $this->request->get['preference_id'] ?? ($payment['transaction_ref'] ?? '');
            if ($pref_id) {
                $ok = $this->model_checkout_gateway->verifyMpPayment($pref_id);
            }
        }

        if ($ok) {
            $this->model_cms_mooc_payment->markPaid($payment_id, $payment['transaction_ref'] ?? '');
            $this->model_cms_mooc_enrollment->enroll($course_id, $customer_id);
            $this->session->data['success'] = $this->language->get('text_payment_success');
        } else {
            $this->session->data['success'] = 'Pagamento pendente. Se já pagou, aguarde a confirmação.';
        }
        $this->response->redirect($this->url->link('cms/mooc.info', 'course_id=' . $course_id));
    }
}
