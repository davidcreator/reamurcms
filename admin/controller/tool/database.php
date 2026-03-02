<?php
namespace Reamur\Admin\Controller\Tool;
/**
 * Class Database
 *
 * @package Reamur\Admin\Controller\Tool
 */
class Database extends \Reamur\System\Engine\Controller {
    /**
     * Main index page for database management
     *
     * @return void
     */
    public function index(): void {
        $this->load->language('tool/database');

        $this->document->setTitle($this->language->get('heading_title'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('tool/database', 'user_token=' . $this->session->data['user_token'])
        ];

        // Load helpers
        $this->load->helper('db_schema');
        $this->load->helper('db_migration');
        $this->load->helper('db_validation');

        // Check if migration is needed
        $data['migration_needed'] = rms_check_migration_needed($this->db);
        $data['schema_version'] = rms_db_schema_version();

        // Get migration history
        $data['migration_history'] = rms_get_migration_history($this->db);

        // Validate schema definition
        $data['schema_errors'] = rms_validate_schema_definition();

        // Check database integrity
        $data['integrity_issues'] = rms_check_database_integrity($this->db);

        // Action URLs
        $data['apply_migration'] = $this->url->link('tool/database.applyMigration', 'user_token=' . $this->session->data['user_token']);
        $data['validate_schema'] = $this->url->link('tool/database.validateSchema', 'user_token=' . $this->session->data['user_token']);
        $data['check_integrity'] = $this->url->link('tool/database.checkIntegrity', 'user_token=' . $this->session->data['user_token']);
        $data['fix_issues'] = $this->url->link('tool/database.fixIssues', 'user_token=' . $this->session->data['user_token']);
        $data['view_documentation'] = $this->url->link('tool/database.viewDocumentation', 'user_token=' . $this->session->data['user_token']);

        $data['user_token'] = $this->session->data['user_token'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('tool/database', $data));
    }

    /**
     * Apply database migration
     *
     * @return void
     */
    public function applyMigration(): void {
        $this->load->language('tool/database');

        $json = [];

        if (!$this->user->hasPermission('modify', 'tool/database')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            $this->load->helper('db_schema');
            $this->load->helper('db_migration');

            $description = $this->request->post['description'] ?? 'Manual migration applied by admin';

            // Log migration attempt
            $this->log->write('Database migration initiated by user ID: ' . $this->user->getId());
            
            $result = rms_apply_migration($this->db, $description);

            if ($result['success']) {
                $json['success'] = $this->language->get('text_migration_success');
                $this->log->write('Database migration completed successfully: ' . $result['message']);
            } else {
                $json['error'] = $this->language->get('error_migration') . ': ' . $result['message'];
                $this->log->write('Database migration failed: ' . $result['message']);
            }

            // Include details in the response
            $json['details'] = $result['details'];
            
            // Get updated migration history
            $json['migration_history'] = rms_get_migration_history($this->db);
            $json['schema_version'] = rms_db_schema_version();
            $json['migration_needed'] = rms_check_migration_needed($this->db);
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    /**
     * Validate database schema definition
     *
     * @return void
     */
    public function validateSchema(): void {
        $this->load->language('tool/database');

        $json = [];

        if (!$this->user->hasPermission('modify', 'tool/database')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            $this->load->helper('db_validation');

            $errors = rms_validate_schema_definition();

            if (empty($errors)) {
                $json['success'] = $this->language->get('text_validation_success');
            } else {
                $json['error'] = $this->language->get('error_validation');
            }

            $json['schema_errors'] = $errors;
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    /**
     * Check database integrity
     *
     * @return void
     */
    public function checkIntegrity(): void {
        $this->load->language('tool/database');

        $json = [];

        if (!$this->user->hasPermission('modify', 'tool/database')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            $this->load->helper('db_validation');

            $issues = rms_check_database_integrity($this->db);

            if (empty($issues)) {
                $json['success'] = $this->language->get('text_integrity_success');
            } else {
                $json['error'] = $this->language->get('error_integrity');
            }

            $json['integrity_issues'] = $issues;

            // Generate SQL to fix issues
            if (!empty($issues)) {
                $json['fix_sql'] = rms_generate_fix_sql($this->db, $issues);
            }
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    /**
     * Fix database integrity issues
     *
     * @return void
     */
    public function fixIssues(): void {
        $this->load->language('tool/database');
        
        $json = [];
        
        if (!$this->user->hasPermission('modify', 'tool/database')) {
            $json['error'] = $this->language->get('error_permission');
        } else {
            // Load helpers
            require_once(DIR_SYSTEM . 'helper/db_schema.php');
            require_once(DIR_SYSTEM . 'helper/db_validation.php');
            
            // Check integrity
            $issues = rms_check_database_integrity($this->db);
            
            if (!empty($issues)) {
                // Generate SQL to fix issues
                $sql_statements = rms_generate_fix_sql($this->db, $issues);
                
                $success_count = 0;
                $error_count = 0;
                $errors = [];
                $applied_fixes = [];
                $skipped_dangerous = [];
                
                // Log the fix attempt
                $this->log->write('Database fix issues attempt started');
                
                // Execute SQL statements
                foreach ($sql_statements as $statement) {
                    // Skip dangerous operations by default (dropping tables/columns)
                    if (!empty($statement['dangerous'])) {
                        $skipped_dangerous[] = [
                            'sql' => $statement['sql'],
                            'type' => $statement['type'],
                            'issue' => $statement['issue']
                        ];
                        continue;
                    }
                    
                    try {
                        $this->db->query($statement['sql']);
                        $success_count++;
                        $applied_fixes[] = [
                            'type' => $statement['type'],
                            'sql' => $statement['sql'],
                            'table' => $statement['table'],
                            'column' => $statement['column'] ?? null,
                            'index' => $statement['index'] ?? null
                        ];
                        $this->log->write("Database fix applied: {$statement['sql']}");
                    } catch (\Exception $e) {
                        $error_count++;
                        $errors[] = [
                            'message' => $e->getMessage(),
                            'sql' => $statement['sql'],
                            'type' => $statement['type'],
                            'table' => $statement['table']
                        ];
                        $this->log->write("Database fix error: {$e->getMessage()} for SQL: {$statement['sql']}");
                    }
                }
                
                // Check integrity again after fixes
                $remaining_issues = rms_check_database_integrity($this->db);
                
                $json['success'] = sprintf($this->language->get('text_fix_success'), $success_count);
                $json['issues_fixed'] = count($issues) - count($remaining_issues);
                $json['issues_remaining'] = count($remaining_issues);
                $json['applied_fixes'] = $applied_fixes;
                
                if (!empty($skipped_dangerous)) {
                    $json['skipped_dangerous'] = $skipped_dangerous;
                    $json['skipped_dangerous_count'] = count($skipped_dangerous);
                    $json['skipped_dangerous_message'] = $this->language->get('text_skipped_dangerous');
                }
                
                if ($error_count > 0) {
                    $json['error_count'] = $error_count;
                    $json['errors'] = $errors;
                }
                
                // Return remaining issues
                $json['remaining_issues'] = $remaining_issues;
                
                // Log the fix completion
                $this->log->write("Database fix issues completed: {$success_count} successful, {$error_count} errors, " . 
                                 count($skipped_dangerous) . " dangerous operations skipped");
            } else {
                $json['success'] = $this->language->get('text_no_issues');
            }
        }
        
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    /**
     * View database schema documentation
     *
     * @return void
     */
    public function viewDocumentation(): void {
        $this->load->language('tool/database');

        $this->document->setTitle($this->language->get('heading_documentation'));

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('tool/database', 'user_token=' . $this->session->data['user_token'])
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_documentation'),
            'href' => $this->url->link('tool/database.viewDocumentation', 'user_token=' . $this->session->data['user_token'])
        ];

        $this->load->helper('db_documentation');

        $data['documentation'] = rms_generate_schema_documentation();
        $data['back'] = $this->url->link('tool/database', 'user_token=' . $this->session->data['user_token']);

        $data['user_token'] = $this->session->data['user_token'];

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('tool/database_documentation', $data));
    }

    /**
     * Export database schema documentation as markdown
     *
     * @return void
     */
    public function exportDocumentation(): void {
        $this->load->language('tool/database');

        if (!$this->user->hasPermission('modify', 'tool/database')) {
            $this->response->addHeader('Content-Type: text/plain');
            $this->response->setOutput($this->language->get('error_permission'));
            return;
        }

        $this->load->helper('db_documentation');

        $markdown = rms_generate_schema_markdown();

        $this->response->addHeader('Content-Type: text/markdown');
        $this->response->addHeader('Content-Disposition: attachment; filename="database_schema.md"');
        $this->response->setOutput($markdown);
    }
}