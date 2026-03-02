<?php
namespace Reamur\Admin\Controller\Common;

/**
 * Class Dashboard
 *
 * @package Reamur\Admin\Controller\Common
 */
class Dashboard extends \Reamur\System\Engine\Controller
{
    /**
     * Display the admin dashboard
     *
     * @return void
     */
    public function index(): void
    {
        try {
            $this->load->language('common/dashboard');
            $this->document->setTitle($this->language->get('heading_title'));

            $data = $this->buildDashboardData();
            
            $this->response->setOutput($this->load->view('common/dashboard', $data));
        } catch (\Exception $e) {
            $this->log->write('Dashboard Error: ' . $e->getMessage());
            $this->response->setOutput($this->load->view('error/error', [
                'error_message' => 'An error occurred while loading the dashboard.'
            ]));
        }
    }

    /**
     * Build all dashboard data
     *
     * @return array
     */
    private function buildDashboardData(): array
    {
        $data = [];
        
        $data['breadcrumbs'] = $this->buildBreadcrumbs();
        $data = array_merge($data, $this->getStatistics());
        $data['rows'] = $this->buildDashboardExtensions();
        $data['developer_status'] = $this->user->hasPermission('access', 'common/developer');
        $data['security'] = $this->load->controller('common/security');
        $data['user_token'] = $this->getUserToken();
        
        // Load common layout components
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        return $data;
    }

    /**
     * Build breadcrumb navigation
     *
     * @return array
     */
    private function buildBreadcrumbs(): array
    {
        $breadcrumbs = [];
        $userToken = $this->getUserToken();

        $breadcrumbs[] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $userToken)
        ];

        $breadcrumbs[] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $userToken)
        ];

        return $breadcrumbs;
    }

    /**
     * Get dashboard statistics
     *
     * @return array
     */
    private function getStatistics(): array
    {
        $statistics = [
            'total_products' => 0,
            'total_orders' => 0,
            'total_customers' => 0
        ];

        try {
            // Load models with error handling
            $this->load->model('catalog/product');
            $this->load->model('sale/order');
            $this->load->model('customer/customer');

            // Get statistics with null coalescing for safety
            $statistics['total_products'] = $this->model_catalog_product->getTotalProducts() ?? 0;
            $statistics['total_orders'] = $this->model_sale_order->getTotalOrders() ?? 0;
            $statistics['total_customers'] = $this->model_customer_customer->getTotalCustomers() ?? 0;
            
        } catch (\Exception $e) {
            $this->log->write('Dashboard Statistics Error: ' . $e->getMessage());
            // Statistics remain at default values (0) if there's an error
        }

        return $statistics;
    }

    /**
     * Build dashboard extensions and organize them in rows
     *
     * @return array
     */
    private function buildDashboardExtensions(): array
    {
        $dashboards = $this->loadDashboardExtensions();
        $dashboards = $this->sortDashboardsByOrder($dashboards);
        
        return $this->organizeDashboardsIntoRows($dashboards);
    }

    /**
     * Load all available dashboard extensions
     *
     * @return array
     */
    private function loadDashboardExtensions(): array
    {
        $dashboards = [];

        try {
            $this->load->model('setting/extension');
            $extensions = $this->model_setting_extension->getExtensionsByType('dashboard');

            foreach ($extensions as $extension) {
                $dashboard = $this->loadSingleExtension($extension);
                if ($dashboard !== null) {
                    $dashboards[] = $dashboard;
                }
            }
        } catch (\Exception $e) {
            $this->log->write('Dashboard Extensions Error: ' . $e->getMessage());
        }

        return $dashboards;
    }

    /**
     * Load a single dashboard extension
     *
     * @param array $extension
     * @return array|null
     */
    private function loadSingleExtension(array $extension): ?array
    {
        $extensionCode = $extension['code'] ?? '';
        $extensionName = $extension['extension'] ?? '';
        
        if (empty($extensionCode) || empty($extensionName)) {
            return null;
        }

        $configKey = 'dashboard_' . $extensionCode;
        $isEnabled = $this->config->get($configKey . '_status');
        $hasPermission = $this->user->hasPermission('access', 'extension/' . $extensionName . '/dashboard/' . $extensionCode);

        if (!$isEnabled || !$hasPermission) {
            return null;
        }

        try {
            $output = $this->load->controller('extension/' . $extensionName . '/dashboard/' . $extensionCode . '.dashboard');
            
            if (empty($output)) {
                return null;
            }

            return [
                'code'       => $extensionCode,
                'width'      => (int)($this->config->get($configKey . '_width') ?? 12),
                'sort_order' => (int)($this->config->get($configKey . '_sort_order') ?? 0),
                'output'     => $output
            ];
        } catch (\Exception $e) {
            $this->log->write('Extension Load Error (' . $extensionCode . '): ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Sort dashboards by their sort order
     *
     * @param array $dashboards
     * @return array
     */
    private function sortDashboardsByOrder(array $dashboards): array
    {
        if (empty($dashboards)) {
            return $dashboards;
        }

        usort($dashboards, function ($a, $b) {
            return $a['sort_order'] <=> $b['sort_order'];
        });

        return $dashboards;
    }

    /**
     * Organize dashboards into rows based on width (max 12 per row)
     *
     * @param array $dashboards
     * @return array
     */
    private function organizeDashboardsIntoRows(array $dashboards): array
    {
        $rows = [];
        $currentRow = [];
        $currentWidth = 0;
        $maxWidth = 12;

        foreach ($dashboards as $dashboard) {
            $dashboardWidth = max(1, min(12, $dashboard['width'])); // Ensure width is between 1-12
            
            // If adding this dashboard would exceed the row width, start a new row
            if ($currentWidth + $dashboardWidth > $maxWidth && !empty($currentRow)) {
                $rows[] = $currentRow;
                $currentRow = [];
                $currentWidth = 0;
            }

            $currentRow[] = $dashboard;
            $currentWidth += $dashboardWidth;
        }

        // Add the last row if it has content
        if (!empty($currentRow)) {
            $rows[] = $currentRow;
        }

        return $rows;
    }

    /**
     * Get user token with validation
     *
     * @return string
     */
    private function getUserToken(): string
    {
        $token = $this->session->data['user_token'] ?? '';
        
        if (empty($token)) {
            $this->log->write('Dashboard Warning: Missing user token');
        }
        
        return $token;
    }
}