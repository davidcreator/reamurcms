<?php
/**
 * Database Documentation Helper
 * @package ReamurCMS
 * @version 1.0.0
 * 
 * This file provides functionality for generating documentation for the database schema.
 * It extracts information from the db_schema.php file to create human-readable documentation.
 */

/**
 * Generate HTML documentation for the database schema
 * 
 * @return string HTML documentation of the database schema
 */
function rms_generate_schema_documentation() {
    // Load the schema
    if (!function_exists('rms_db_schema')) {
        require_once(DIR_SYSTEM . 'helper/db_schema.php');
    }
    
    $tables = rms_db_schema();
    $version = rms_db_schema_version();
    
    $html = '<div class="schema-documentation">';
    $html .= '<h1>Database Schema Documentation</h1>';
    $html .= '<p>Schema Version: ' . htmlspecialchars($version) . '</p>';
    
    // Table of contents
    $html .= '<h2>Tables</h2>';
    $html .= '<ul>';
    foreach ($tables as $table_name => $table) {
        $display_name = str_replace('rms_', '', $table_name);
        $html .= '<li><a href="#' . htmlspecialchars($table_name) . '">' . htmlspecialchars($display_name) . '</a></li>';
    }
    $html .= '</ul>';
    
    // Detailed table documentation
    foreach ($tables as $table_name => $table) {
        $display_name = str_replace('rms_', '', $table_name);
        $html .= '<div class="table-documentation" id="' . htmlspecialchars($table_name) . '">';
        $html .= '<h3>' . htmlspecialchars($display_name) . '</h3>';
        
        // Table description if available
        if (isset($table['description'])) {
            $html .= '<p>' . htmlspecialchars($table['description']) . '</p>';
        }
        
        // Fields
        if (isset($table['fields']) && is_array($table['fields'])) {
            $html .= '<h4>Fields</h4>';
            $html .= '<table class="table table-bordered table-striped">';
            $html .= '<thead><tr><th>Name</th><th>Type</th><th>Required</th><th>Default</th><th>Auto Increment</th><th>Description</th></tr></thead>';
            $html .= '<tbody>';
            
            foreach ($table['fields'] as $field) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($field['name']) . '</td>';
                $html .= '<td>' . htmlspecialchars($field['type']) . '</td>';
                $html .= '<td>' . (!empty($field['not_null']) ? 'Yes' : 'No') . '</td>';
                $html .= '<td>' . (isset($field['default']) ? htmlspecialchars($field['default']) : '') . '</td>';
                $html .= '<td>' . (!empty($field['auto_increment']) ? 'Yes' : 'No') . '</td>';
                $html .= '<td>' . (isset($field['description']) ? htmlspecialchars($field['description']) : '') . '</td>';
                $html .= '</tr>';
            }
            
            $html .= '</tbody></table>';
        }
        
        // Primary Key
        if (isset($table['primary'])) {
            $html .= '<h4>Primary Key</h4>';
            $html .= '<ul>';
            foreach ($table['primary'] as $primary) {
                $html .= '<li>' . htmlspecialchars($primary) . '</li>';
            }
            $html .= '</ul>';
        }
        
        // Indexes
        if (isset($table['index']) && is_array($table['index'])) {
            $html .= '<h4>Indexes</h4>';
            $html .= '<ul>';
            
            foreach ($table['index'] as $index) {
                if (is_array($index) && isset($index['name']) && isset($index['key'])) {
                    $html .= '<li><strong>' . htmlspecialchars($index['name']) . '</strong>: ' . 
                            htmlspecialchars(implode(', ', $index['key'])) . '</li>';
                } else if (!is_array($index)) {
                    $html .= '<li>' . htmlspecialchars($index) . '</li>';
                }
            }
            
            $html .= '</ul>';
        }
        
        // Foreign Keys
        if (isset($table['foreign']) && is_array($table['foreign'])) {
            $html .= '<h4>Foreign Keys</h4>';
            $html .= '<ul>';
            
            foreach ($table['foreign'] as $foreign) {
                $html .= '<li><strong>' . htmlspecialchars($foreign['key']) . '</strong> references ' . 
                        htmlspecialchars($foreign['table']) . '.' . htmlspecialchars($foreign['field']) . '</li>';
            }
            
            $html .= '</ul>';
        }
        
        // Engine, Charset, Collation
        $html .= '<h4>Table Properties</h4>';
        $html .= '<ul>';
        $html .= '<li><strong>Engine</strong>: ' . htmlspecialchars($table['engine'] ?? 'InnoDB') . '</li>';
        $html .= '<li><strong>Character Set</strong>: ' . htmlspecialchars($table['charset'] ?? 'utf8mb4') . '</li>';
        $html .= '<li><strong>Collation</strong>: ' . htmlspecialchars($table['collate'] ?? 'utf8mb4_general_ci') . '</li>';
        $html .= '</ul>';
        
        $html .= '</div>';
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Generate a markdown documentation for the database schema
 * 
 * @return string Markdown documentation of the database schema
 */
function rms_generate_schema_markdown() {
    // Load the schema
    if (!function_exists('rms_db_schema')) {
        require_once(DIR_SYSTEM . 'helper/db_schema.php');
    }
    
    $tables = rms_db_schema();
    $version = rms_db_schema_version();
    
    $md = "# Database Schema Documentation\n\n";
    $md .= "Schema Version: {$version}\n\n";
    
    // Table of contents
    $md .= "## Tables\n\n";
    foreach ($tables as $table_name => $table) {
        $display_name = str_replace('rms_', '', $table_name);
        $md .= "- [{$display_name}](#{$table_name})\n";
    }
    $md .= "\n";
    
    // Detailed table documentation
    foreach ($tables as $table_name => $table) {
        $display_name = str_replace('rms_', '', $table_name);
        $md .= "## {$display_name} <a name=\"{$table_name}\"></a>\n\n";
        
        // Table description if available
        if (isset($table['description'])) {
            $md .= "{$table['description']}\n\n";
        }
        
        // Fields
        if (isset($table['fields']) && is_array($table['fields'])) {
            $md .= "### Fields\n\n";
            $md .= "| Name | Type | Required | Default | Auto Increment | Description |\n";
            $md .= "|------|------|----------|---------|----------------|-------------|\n";
            
            foreach ($table['fields'] as $field) {
                $required = !empty($field['not_null']) ? 'Yes' : 'No';
                $default = isset($field['default']) ? $field['default'] : '';
                $auto_increment = !empty($field['auto_increment']) ? 'Yes' : 'No';
                $description = isset($field['description']) ? $field['description'] : '';
                
                $md .= "| {$field['name']} | {$field['type']} | {$required} | {$default} | {$auto_increment} | {$description} |\n";
            }
            
            $md .= "\n";
        }
        
        // Primary Key
        if (isset($table['primary'])) {
            $md .= "### Primary Key\n\n";
            foreach ($table['primary'] as $primary) {
                $md .= "- {$primary}\n";
            }
            $md .= "\n";
        }
        
        // Indexes
        if (isset($table['index']) && is_array($table['index'])) {
            $md .= "### Indexes\n\n";
            
            foreach ($table['index'] as $index) {
                if (is_array($index) && isset($index['name']) && isset($index['key'])) {
                    $keys = implode(', ', $index['key']);
                    $md .= "- **{$index['name']}**: {$keys}\n";
                } else if (!is_array($index)) {
                    $md .= "- {$index}\n";
                }
            }
            
            $md .= "\n";
        }
        
        // Foreign Keys
        if (isset($table['foreign']) && is_array($table['foreign'])) {
            $md .= "### Foreign Keys\n\n";
            
            foreach ($table['foreign'] as $foreign) {
                $md .= "- **{$foreign['key']}** references {$foreign['table']}.{$foreign['field']}\n";
            }
            
            $md .= "\n";
        }
        
        // Engine, Charset, Collation
        $md .= "### Table Properties\n\n";
        $engine = $table['engine'] ?? 'InnoDB';
        $charset = $table['charset'] ?? 'utf8mb4';
        $collate = $table['collate'] ?? 'utf8mb4_general_ci';
        
        $md .= "- **Engine**: {$engine}\n";
        $md .= "- **Character Set**: {$charset}\n";
        $md .= "- **Collation**: {$collate}\n\n";
    }
    
    return $md;
}