<?php
namespace Reamur\Admin\Controller\Extension\Dashboard;

class BlogStats extends \Reamur\System\Engine\Controller {
    public function index() {
        $this->load->language('extension/blog_stats');

        $data['user_token'] = $this->session->data['user_token'];

        // Get blog statistics
        $this->load->model('cms/blog_post');
        $this->load->model('cms/blog_comment');
        if (method_exists($this->model_cms_blog_post, 'ensureTables')) {
            $this->model_cms_blog_post->ensureTables();
        }
        
        // Total posts
        $data['total_posts'] = $this->model_cms_blog_post->getTotalPosts();
        
        // Published posts
        $data['published_posts'] = $this->model_cms_blog_post->getTotalPosts(['filter_status' => 'published']);
        
        // Draft posts
        $data['draft_posts'] = $this->model_cms_blog_post->getTotalPosts(['filter_status' => 'draft']);
        
        // Total comments
        $data['total_comments'] = $this->model_cms_blog_comment->getTotalComments();
        
        // Pending comments
        $data['pending_comments'] = $this->model_cms_blog_comment->getTotalComments(['filter_status' => 0]);
        
        // Recent posts
        $data['recent_posts'] = $this->model_cms_blog_post->getPosts([
            'sort' => 'bp.created_at',
            'order' => 'DESC',
            'start' => 0,
            'limit' => 5
        ]);
        
        // Recent comments
        $data['recent_comments'] = $this->model_cms_blog_comment->getComments([
            'sort' => 'bc.created_at',
            'order' => 'DESC',
            'start' => 0,
            'limit' => 5
        ]);
        
        // Check if blog_analytics table exists and create it if not
        $this->createAnalyticsTableIfNotExists();
        
        // Get view statistics if available
        $data['post_views'] = $this->getPostViews();
        $data['user_locations'] = $this->getUserLocations();
        $data['user_types'] = $this->getUserTypes();
        
        return $this->load->view('extension/dashboard/blog_stats', $data);
    }
    
    public function dashboard() {
        $this->load->language('extension/dashboard/blog_stats');

        // User permissions
        $data['user_token'] = $this->session->data['user_token'];

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_view'] = $this->language->get('text_view');

        $data['blog_overview_url'] = $this->url->link('cms/blog_post', 'user_token=' . $this->session->data['user_token']);
        $data['blog_comments_url'] = $this->url->link('cms/blog_comment', 'user_token=' . $this->session->data['user_token']);

        return $this->load->view('extension/dashboard/blog_stats_info', $data);
    }
    
    protected function createAnalyticsTableIfNotExists() {
        $this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "blog_analytics (
            `analytics_id` INT(11) NOT NULL AUTO_INCREMENT,
            `blog_post_id` INT(11) NOT NULL,
            `ip_address` VARCHAR(40) NOT NULL,
            `user_agent` VARCHAR(255) NOT NULL,
            `referrer` VARCHAR(255) DEFAULT NULL,
            `is_logged` TINYINT(1) NOT NULL DEFAULT '0',
            `user_id` INT(11) DEFAULT NULL,
            `country` VARCHAR(2) DEFAULT NULL,
            `date_added` DATETIME NOT NULL,
            PRIMARY KEY (`analytics_id`),
            KEY `blog_post_id` (`blog_post_id`),
            KEY `date_added` (`date_added`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");
    }
    
    protected function getPostViews() {
        $views = [];
        
        // Check if table exists
        $query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "blog_analytics'");
        
        if ($query->num_rows) {
            // Get top 5 posts by views
            $query = $this->db->query("SELECT bp.title, COUNT(ba.analytics_id) as views 
                FROM " . DB_PREFIX . "blog_analytics ba 
                LEFT JOIN " . DB_PREFIX . "blog_post bp ON ba.blog_post_id = bp.post_id 
                GROUP BY ba.blog_post_id 
                ORDER BY views DESC 
                LIMIT 5");
            
            $views = $query->rows;
        }
        
        return $views;
    }
    
    protected function getUserLocations() {
        $locations = [];
        
        // Check if table exists
        $query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "blog_analytics'");
        
        if ($query->num_rows) {
            // Get top countries
            $query = $this->db->query("SELECT country, COUNT(analytics_id) as total 
                FROM " . DB_PREFIX . "blog_analytics 
                WHERE country IS NOT NULL 
                GROUP BY country 
                ORDER BY total DESC 
                LIMIT 5");
            
            $locations = $query->rows;
        }
        
        return $locations;
    }
    
    protected function getUserTypes() {
        $types = [
            'logged' => 0,
            'anonymous' => 0
        ];
        
        // Check if table exists
        $query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "blog_analytics'");
        
        if ($query->num_rows) {
            // Get logged vs anonymous users
            $query = $this->db->query("SELECT is_logged, COUNT(analytics_id) as total 
                FROM " . DB_PREFIX . "blog_analytics 
                GROUP BY is_logged");
            
            foreach ($query->rows as $row) {
                if ($row['is_logged']) {
                    $types['logged'] = $row['total'];
                } else {
                    $types['anonymous'] = $row['total'];
                }
            }
        }
        
        return $types;
    }
}
