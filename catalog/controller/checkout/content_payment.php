<?php
namespace Reamur\Catalog\Controller\Checkout;

class ContentPayment extends \Reamur\System\Engine\Controller {
    public function checkout(): void {
        $context = $this->request->get['context'] ?? '';
        $ref = (int)($this->request->get['ref'] ?? 0);
        $this->load->language('cms/mooc');
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('checkout/content_payment.checkout', 'context=' . $context . '&ref=' . $ref);
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $item = $this->loadItem($context, $ref);
        if (!$item || $item['price'] <= 0) {
            $this->response->redirect($this->url->link('common/home'));
            return;
        }
        $data['item'] = $item;
        $data['context'] = $context;
        $data['action'] = $this->url->link('checkout/content_payment.pay', 'context=' . $context . '&ref=' . $ref);
        $data['text_payment_methods'] = $this->language->get('text_payment_methods');
        $data['text_pay_now'] = $this->language->get('text_pay_now');
        $data['text_price'] = $this->language->get('text_price');
        $data['text_buy_course'] = $this->language->get('text_buy_course');
        $data['methods'] = [
            ['code' => 'stripe', 'title' => 'Stripe (cartão / wallets)'],
            ['code' => 'mercadopago', 'title' => 'Mercado Pago (Pix/Boleto/Cartão)']
        ];
        $this->response->setOutput($this->load->view('cms/mooc_checkout', $data));
    }

    public function pay(): void {
        $this->load->language('cms/mooc');
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('checkout/content_payment.checkout', $this->request->server['QUERY_STRING'] ?? '');
            $this->response->redirect($this->url->link('account/login'));
            return;
        }
        $context = $this->request->get['context'] ?? '';
        $ref = (int)($this->request->get['ref'] ?? 0);
        $method = $this->request->post['method'] ?? 'stripe';
        $item = $this->loadItem($context, $ref);
        if (!$item || $item['price'] <= 0) {
            $this->response->redirect($this->url->link('common/home'));
            return;
        }
        $this->load->model('checkout/payment');
        $this->load->model('checkout/gateway');

        $payment_id = $this->model_checkout_payment->create($this->customer->getId(), $context, $ref, $method, (float)$item['price'], 'BRL');
        $success = $this->url->link('checkout/content_payment.success', 'payment_id=' . $payment_id . '&method=' . $method, true);
        $cancel = $this->url->link('checkout/content_payment.checkout', 'context=' . $context . '&ref=' . $ref, true);
        $dest = $item['dest'] ?? [];
        $platform_fee = 100 - ($dest['share'] ?? 80);

        if ($method === 'stripe') {
            $checkout = $this->model_checkout_gateway->createStripeCheckout((float)$item['price'], 'BRL', $item['title'], $success . '&session_id={CHECKOUT_SESSION_ID}', $cancel, $dest['stripe'] ?? '', $platform_fee);
            if (!empty($checkout['id'])) {
                $this->db->query("UPDATE `" . DB_PREFIX . "payment` SET transaction_ref='" . $this->db->escape($checkout['id']) . "' WHERE payment_id='" . (int)$payment_id . "'");
                $this->response->redirect($checkout['url'] ?? $cancel);
                return;
            }
        } elseif ($method === 'mercadopago') {
            $pref = $this->model_checkout_gateway->createMpPreference((float)$item['price'], 'BRL', $item['title'], $success . '&preference_id={PREF_ID}', $cancel, $dest['mp'] ?? '', $platform_fee);
            if (!empty($pref['id'])) {
                $this->db->query("UPDATE `" . DB_PREFIX . "payment` SET transaction_ref='" . $this->db->escape($pref['id']) . "' WHERE payment_id='" . (int)$payment_id . "'");
                $this->response->redirect($pref['init_point'] ?? $cancel);
                return;
            }
        }
        $this->model_checkout_payment->markPaid($payment_id, strtoupper($method) . '-' . $payment_id);
        $this->session->data['success'] = $this->language->get('text_payment_success');
        $this->response->redirect($this->url->link('common/home'));
    }

    public function success(): void {
        $this->load->model('checkout/payment');
        $this->load->model('checkout/gateway');
        $this->load->language('cms/mooc');

        $payment_id = (int)($this->request->get['payment_id'] ?? 0);
        $method = $this->request->get['method'] ?? '';
        $payment = $this->model_checkout_payment->getPayment($payment_id);
        if (!$payment) {
            $this->response->redirect($this->url->link('common/home'));
            return;
        }
        $ok = false;
        if ($method === 'stripe') {
            $sid = $this->request->get['session_id'] ?? ($payment['transaction_ref'] ?? '');
            if ($sid) $ok = $this->model_checkout_gateway->verifyStripeSession($sid);
        } elseif ($method === 'mercadopago') {
            $pref = $this->request->get['preference_id'] ?? ($payment['transaction_ref'] ?? '');
            if ($pref) $ok = $this->model_checkout_gateway->verifyMpPayment($pref);
        }
        if ($ok) {
            $this->model_checkout_payment->markPaid($payment_id, $payment['transaction_ref'] ?? '');
            $this->session->data['success'] = $this->language->get('text_payment_success');
        }
        $context = $payment['context'];
        $ref = (int)$payment['reference_id'];
        if ($context === 'blog') {
            $this->response->redirect($this->url->link('cms/blog.info', 'blog_id=' . $ref));
        } elseif ($context === 'landpage') {
            $slug = $this->db->query("SELECT slug FROM `" . DB_PREFIX . "landpage_page` WHERE page_id='" . (int)$ref . "'")->row['slug'] ?? '';
            $this->response->redirect($this->url->link('cms/landpage.info', 'slug=' . $slug));
        } else {
            $this->response->redirect($this->url->link('common/home'));
        }
    }

    private function loadItem(string $context, int $ref): array {
        $dest = ['stripe' => '', 'mp' => '', 'share' => 80];
        if ($context === 'blog') {
            $this->load->model('cms/blog');
            $post = $this->model_cms_blog->getPost($ref);
            if (!$post) return [];
            if (empty($post['price'])) return [];
            if (!empty($post['owner_id'])) {
                $instr = $this->db->query("SELECT stripe_account_id, mp_user_id, payout_share FROM `" . DB_PREFIX . "mooc_instructor` WHERE instructor_id='" . (int)$post['owner_id'] . "'")->row;
                if ($instr) {
                    $dest['stripe'] = $instr['stripe_account_id'] ?? '';
                    $dest['mp'] = $instr['mp_user_id'] ?? '';
                    $dest['share'] = (float)($post['payout_share'] ?? $instr['payout_share'] ?? 80);
                }
            }
            return ['title' => $post['title'], 'price' => (float)$post['price'], 'dest' => $dest];
        }
        if ($context === 'landpage') {
            $this->load->model('cms/landpage');
            $page = $this->model_cms_landpage->getPageBySlug($this->db->query("SELECT slug FROM `" . DB_PREFIX . "landpage_page` WHERE page_id='" . (int)$ref . "'")->row['slug'] ?? '');
            if (!$page || empty($page['price'])) return [];
            if (!empty($page['owner_id'])) {
                $instr = $this->db->query("SELECT stripe_account_id, mp_user_id, payout_share FROM `" . DB_PREFIX . "mooc_instructor` WHERE instructor_id='" . (int)$page['owner_id'] . "'")->row;
                if ($instr) {
                    $dest['stripe'] = $instr['stripe_account_id'] ?? '';
                    $dest['mp'] = $instr['mp_user_id'] ?? '';
                    $dest['share'] = (float)($page['payout_share'] ?? $instr['payout_share'] ?? 80);
                }
            }
            return ['title' => $page['title'], 'price' => (float)$page['price'], 'dest' => $dest];
        }
        return [];
    }
}
