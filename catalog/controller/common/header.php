<?php
namespace Reamur\Catalog\Controller\Common;

/**
 * Class Header
 *
 * @package Reamur\Catalog\Controller\Common
 */
class Header extends \Reamur\System\Engine\Controller {
    /**
     * @return string
     */
    public function index(): string {
        // Initialize data array
        $data = [];

        // Analytics - only load if cookie policy accepted
        $data['analytics'] = [];
        if (!$this->config->get('config_cookie_id') || 
            (isset($this->request->cookie['policy']) && $this->request->cookie['policy'])) {
            $this->load->model('setting/extension');
            $analytics = $this->model_setting_extension->getExtensionsByType('analytics');

            foreach ($analytics as $analytic) {
                if ($this->config->get('analytics_' . $analytic['code'] . '_status')) {
                    $data['analytics'][] = $this->load->controller(
                        'extension/' . $analytic['extension'] . '/analytics/' . $analytic['code'], 
                        $this->config->get('analytics_' . $analytic['code'] . '_status')
                    );
                }
            }
        }

        // Language and document data
        $data['lang'] = $this->language->get('code');
        $data['direction'] = $this->language->get('direction');
        $data['title'] = $this->document->getTitle();
        $data['base'] = $this->config->get('config_url');
        $data['description'] = $this->document->getDescription();
        $data['keywords'] = $this->document->getKeywords();

        // Static assets with versioning for cache busting
        // Corrected static asset paths with file_exists checks
        $bootstrapPath = DIR_APPLICATION . '../view/css/bootstrap.css';
        $data['bootstrap'] = file_exists($bootstrapPath) 
            ? 'catalog/view/css/bootstrap.css?v=' . filemtime($bootstrapPath) 
            : 'catalog/view/css/bootstrap.css';
        
        $iconsPath = DIR_APPLICATION . '../view/css/fonts/fontawesome/css/all.min.css';
        $data['icons'] = file_exists($iconsPath) 
            ? 'catalog/view/css/fonts/fontawesome/css/all.min.css?v=' . filemtime($iconsPath) 
            : 'catalog/view/css/fonts/fontawesome/css/all.min.css';
        
        $reamurPath = DIR_APPLICATION . '../view/css/reamur.css';
        $data['reamur'] = file_exists($reamurPath) 
            ? 'catalog/view/css/reamur.css?v=' . filemtime($reamurPath) 
            : 'catalog/view/css/reamur.css';
        
        $jqueryPath = DIR_APPLICATION . '../view/js/jquery/jquery-3.7.1.min.js';
        $data['jquery'] = file_exists($jqueryPath) 
            ? 'catalog/view/js/jquery/jquery-3.7.1.min.js?v=' . filemtime($jqueryPath) 
            : 'catalog/view/js/jquery/jquery-3.7.1.min.js';

        // Dynamic assets
        $data['links'] = $this->document->getLinks();
        $data['styles'] = $this->document->getStyles();
        $data['scripts'] = $this->document->getScripts('header');

        // Site branding
        $data['name'] = $this->config->get('config_name');
        $data['logo'] = is_file(DIR_IMAGE . $this->config->get('config_logo')) 
            ? $this->config->get('config_url') . 'image/' . $this->config->get('config_logo') 
            : '';

        // Load language file
        $this->load->language('common/header');

        // Wishlist handling with proper model loading
        $wishlistCount = 0;
        if ($this->customer->isLogged()) {
            $this->load->model('account/wishlist');
            $wishlistCount = $this->model_account_wishlist->getTotalWishlist();
        } else {
            $wishlistCount = isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0;
        }
        $data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $wishlistCount);

        // Navigation URLs
        $data['home'] = $this->url->link('common/home', 'language=' . $this->config->get('config_language'));
        $data['wishlist'] = $this->url->link(
            'account/wishlist', 
            'language=' . $this->config->get('config_language') . 
            (isset($this->session->data['customer_token']) ? '&customer_token=' . $this->session->data['customer_token'] : '')
        );
        $data['logged'] = $this->customer->isLogged();

        // Account related URLs
        if (!$this->customer->isLogged()) {
            $data['register'] = $this->url->link('account/register', 'language=' . $this->config->get('config_language'));
            $data['login'] = $this->url->link('account/login', 'language=' . $this->config->get('config_language'));
        } else {
            $customerToken = '&customer_token=' . $this->session->data['customer_token'];
            $data['account'] = $this->url->link('account/account', 'language=' . $this->config->get('config_language') . $customerToken);
            $data['order'] = $this->url->link('account/order', 'language=' . $this->config->get('config_language') . $customerToken);
            $data['transaction'] = $this->url->link('account/transaction', 'language=' . $this->config->get('config_language') . $customerToken);
            $data['download'] = $this->url->link('account/download', 'language=' . $this->config->get('config_language') . $customerToken);
            $data['logout'] = $this->url->link('account/logout', 'language=' . $this->config->get('config_language'));
        }

        // Other URLs
        $data['shopping_cart'] = $this->url->link('checkout/cart', 'language=' . $this->config->get('config_language'));
        $data['checkout'] = $this->url->link('checkout/checkout', 'language=' . $this->config->get('config_language'));
        $data['contact'] = $this->url->link('information/contact', 'language=' . $this->config->get('config_language'));
        $data['telephone'] = $this->config->get('config_telephone');

        // Load common components
        $data['language'] = $this->load->controller('common/language');
        $data['currency'] = $this->load->controller('common/currency');
        $data['search'] = $this->load->controller('common/search');
        $data['cart'] = $this->load->controller('common/cart');
        $data['menu'] = $this->load->controller('common/menu');

        return $this->load->view('common/header', $data);
    }
}
