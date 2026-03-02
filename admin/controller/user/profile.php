<?php
namespace Reamur\Admin\Controller\User;

/**
 * Class Profile
 * Handles user profile management operations
 *
 * @package Reamur\Admin\Controller\User
 */
class Profile extends \Reamur\System\Engine\Controller
{
    /**
     * Display user profile form
     *
     * @return void
     */
    public function index(): void
    {
        $this->load->language('user/profile');
        $this->document->setTitle($this->language->get('heading_title'));

        // Build breadcrumbs
        $data['breadcrumbs'] = $this->buildBreadcrumbs();
        
        // Set action URLs
        $data['save'] = $this->url->link('user/profile.save', 'user_token=' . $this->session->data['user_token']);
        $data['back'] = $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token']);

        // Load user data
        $data = array_merge($data, $this->getUserData());
        
        // Load common UI components
        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('user/profile', $data));
    }

    /**
     * Save user profile data
     *
     * @return void
     */
    public function save(): void
    {
        $this->load->language('user/profile');
        
        $json = [];

        // Validate permissions
        if (!$this->user->hasPermission('modify', 'user/profile')) {
            $json['error']['warning'] = $this->language->get('error_permission');
            $this->sendJsonResponse($json);
            return;
        }

        // Validate input data
        $validation_errors = $this->validateProfileData();
        if (!empty($validation_errors)) {
            $json['error'] = $validation_errors;
            $this->sendJsonResponse($json);
            return;
        }

        // Process image upload if provided
        $image_path = $this->processImageUpload();
        if ($image_path === false) {
            $json['error']['image'] = $this->language->get('error_image_upload');
            $this->sendJsonResponse($json);
            return;
        }

        // Save user data
        try {
            $this->saveUserProfile($image_path);
            $json['success'] = $this->language->get('text_success');
        } catch (Exception $e) {
            $json['error']['warning'] = $this->language->get('error_save');
        }

        $this->sendJsonResponse($json);
    }

    /**
     * Build breadcrumbs array
     *
     * @return array
     */
    private function buildBreadcrumbs(): array
    {
        $user_token = $this->session->data['user_token'] ?? '';
        
        return [
            [
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/dashboard', 'user_token=' . $user_token)
            ],
            [
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('user/profile', 'user_token=' . $user_token)
            ]
        ];
    }

    /**
     * Get user data for the form
     *
     * @return array
     */
    private function getUserData(): array
    {
        $this->load->model('user/user');
        $this->load->model('tool/image');

        $user_info = $this->model_user_user->getUser($this->user->getId());
        
        $data = [
            'username' => $user_info['username'] ?? '',
            'firstname' => $user_info['firstname'] ?? '',
            'lastname' => $user_info['lastname'] ?? '',
            'email' => $user_info['email'] ?? '',
            'image' => $user_info['image'] ?? ''
        ];

        // Handle image thumbnail
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
        
        if (!empty($data['image']) && is_file(DIR_IMAGE . html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8'))) {
            $data['thumb'] = $this->model_tool_image->resize(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8'), 100, 100);
        } else {
            $data['thumb'] = $data['placeholder'];
        }

        return $data;
    }

    /**
     * Validate profile form data
     *
     * @return array Array of validation errors
     */
    private function validateProfileData(): array
    {
        $errors = [];
        $post = $this->request->post;

        // Validate username
        if (empty($post['username']) || strlen($post['username']) < 3 || strlen($post['username']) > 20) {
            $errors['username'] = $this->language->get('error_username');
        } else {
            // Check if username already exists for another user
            $this->load->model('user/user');
            $user_info = $this->model_user_user->getUserByUsername($post['username']);
            if ($user_info && $this->user->getId() != $user_info['user_id']) {
                $errors['warning'] = $this->language->get('error_username_exists');
            }
        }

        // Validate firstname
        if (empty($post['firstname']) || strlen($post['firstname']) < 1 || strlen($post['firstname']) > 32) {
            $errors['firstname'] = $this->language->get('error_firstname');
        }

        // Validate lastname
        if (empty($post['lastname']) || strlen($post['lastname']) < 1 || strlen($post['lastname']) > 32) {
            $errors['lastname'] = $this->language->get('error_lastname');
        }

        // Validate email
        if (empty($post['email']) || strlen($post['email']) > 96 || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = $this->language->get('error_email');
        } else {
            // Check if email already exists for another user
            $user_info = $this->model_user_user->getUserByEmail($post['email']);
            if ($user_info && $this->user->getId() != $user_info['user_id']) {
                $errors['warning'] = $this->language->get('error_email_exists');
            }
        }

        // Validate password (if provided)
        if (!empty($post['password'])) {
            $password_length = strlen(html_entity_decode($post['password'], ENT_QUOTES, 'UTF-8'));
            if ($password_length < 4 || $password_length > 40) {
                $errors['password'] = $this->language->get('error_password');
            }

            if ($post['password'] !== ($post['confirm'] ?? '')) {
                $errors['confirm'] = $this->language->get('error_confirm');
            }
        }

        return $errors;
    }

    /**
     * Process image upload
     *
     * @return string|false|null Returns image path on success, false on error, null if no upload
     */
    private function processImageUpload()
    {
        // Check if there's an image upload
        if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            // No upload attempted, keep existing image
            return $this->request->post['image'] ?? null;
        }

        // Check for upload errors
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $file = $_FILES['image'];
        
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime_type, $allowed_types)) {
            return false;
        }

        // Validate file size (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            return false;
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'user_' . $this->user->getId() . '_' . time() . '.' . $extension;
        
        // Create upload directory if it doesn't exist
        $upload_dir = DIR_IMAGE . 'catalog/users/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $upload_path = $upload_dir . $filename;
        $relative_path = 'catalog/users/' . $filename;

        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $upload_path)) {
            // Delete old image if exists
            $this->deleteOldUserImage();
            return $relative_path;
        }

        return false;
    }

    /**
     * Delete old user image
     *
     * @return void
     */
    private function deleteOldUserImage(): void
    {
        $this->load->model('user/user');
        $user_info = $this->model_user_user->getUser($this->user->getId());
        
        if (!empty($user_info['image'])) {
            $old_image_path = DIR_IMAGE . html_entity_decode($user_info['image'], ENT_QUOTES, 'UTF-8');
            if (is_file($old_image_path)) {
                unlink($old_image_path);
            }
        }
    }

    /**
     * Save user profile to database
     *
     * @param string|null $image_path
     * @throws Exception
     * @return void
     */
    private function saveUserProfile($image_path = null): void
    {
        $this->load->model('user/user');
        
        $user_data = array_merge($this->request->post, [
            'user_group_id' => $this->user->getGroupId(),
            'status' => 1,
        ]);

        // Set image path if provided
        if ($image_path !== null) {
            $user_data['image'] = $image_path;
        }

        // Remove confirm password field as it's not needed for storage
        unset($user_data['confirm']);

        $this->model_user_user->editUser($this->user->getId(), $user_data);
    }

    /**
     * Send JSON response
     *
     * @param array $data
     * @return void
     */
    private function sendJsonResponse(array $data): void
    {
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($data));
    }
}