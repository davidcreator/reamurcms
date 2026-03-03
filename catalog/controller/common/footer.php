<?php
namespace Reamur\Catalog\Controller\Common;

/**
 * Class Footer
 *
 * @package Reamur\Catalog\Controller\Common
 */
class Footer extends \Reamur\System\Engine\Controller {
    /**
     * @return string
     */
    public function index(): string {
        $this->load->language('common/footer');

        // Initialize data array
        $data = [
            'blog' => $this->url->link('cms/blog', 'language=' . $this->config->get('config_language')),
            'informations' => [],
            'gdpr' => '',
            'affiliate' => ''
        ];

        // Load information model
        $this->load->model('catalog/information');

        // Process information links
        foreach ($this->model_catalog_information->getInformations() as $result) {
            if ($result['bottom']) {
                $data['informations'][] = [
                    'title' => htmlspecialchars($result['title'], ENT_QUOTES, 'UTF-8'),
                    'href' => $this->url->link('information/information', 
                        'language=' . $this->config->get('config_language') . 
                        '&information_id=' . (int)$result['information_id'])
                ];
            }
        }

        // Common links
        $data['contact'] = $this->url->link('information/contact', 'language=' . $this->config->get('config_language'));
        $data['return'] = $this->url->link('account/returns.add', 'language=' . $this->config->get('config_language'));
        $data['sitemap'] = $this->url->link('information/sitemap', 'language=' . $this->config->get('config_language'));
        $data['manufacturer'] = $this->url->link('product/manufacturer', 'language=' . $this->config->get('config_language'));
        $data['voucher'] = $this->url->link('checkout/voucher', 'language=' . $this->config->get('config_language'));

        // Conditional links
        if ($this->config->get('config_gdpr_id')) {
            $data['gdpr'] = $this->url->link('information/gdpr', 'language=' . $this->config->get('config_language'));
        }

        if ($this->config->get('config_affiliate_status')) {
            $token = isset($this->session->data['customer_token']) ? '&customer_token=' . $this->session->data['customer_token'] : '';
            $data['affiliate'] = $this->url->link('account/affiliate', 'language=' . $this->config->get('config_language') . $token);
        }

        // Account-related links with token handling
        $token = isset($this->session->data['customer_token']) ? '&customer_token=' . $this->session->data['customer_token'] : '';
        $data['special'] = $this->url->link('product/special', 'language=' . $this->config->get('config_language') . $token);
        $data['account'] = $this->url->link('account/account', 'language=' . $this->config->get('config_language') . $token);
        $data['order'] = $this->url->link('account/order', 'language=' . $this->config->get('config_language') . $token);
        $data['wishlist'] = $this->url->link('account/wishlist', 'language=' . $this->config->get('config_language') . $token);
        $data['newsletter'] = $this->url->link('account/newsletter', 'language=' . $this->config->get('config_language') . $token);

        // Powered by text
        $data['powered'] = sprintf(
            $this->language->get('text_powered'),
            htmlspecialchars($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'),
            date('Y', time())
        );

        // Who's Online tracking
        if ($this->config->get('config_customer_online')) {
            $this->trackOnlineUsers();
        }

        // Static assets
        $data['bootstrap'] = 'catalog/view/js/bootstrap/js/bootstrap.bundle.min.js';
        $data['scripts'] = $this->document->getScripts('footer');
        $data['cookie'] = $this->load->controller('common/cookie');

        return $this->load->view('common/footer', $data);
    }

    /**
     * Track online users
     */
    protected function trackOnlineUsers(): void {
        $this->load->model('tool/online');

        $ip = $this->getClientIp();
        $url = $this->getCurrentUrl();
        $referer = $this->request->server['HTTP_REFERER'] ?? '';

        $this->model_tool_online->addOnline(
            $ip,
            $this->customer->getId(),
            $url,
            $referer
        );
    }

    /**
     * Get client IP address
     */
    protected function getClientIp(): string {
        return $this->request->server['HTTP_X_REAL_IP'] ?? 
               $this->request->server['REMOTE_ADDR'] ?? '';
    }

    /**
     * Get current URL
     */
    protected function getCurrentUrl(): string {
        if (isset($this->request->server['HTTP_HOST']) && 
            isset($this->request->server['REQUEST_URI'])) {
            $protocol = $this->request->server['HTTPS'] ? 'https://' : 'http://';
            return $protocol . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
        }
        return '';
    }
}
