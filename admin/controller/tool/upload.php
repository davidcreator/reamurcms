<?php
namespace Reamur\Admin\Controller\Tool;

/**
 * Class Upload
 *
 * @package Reamur\Admin\Controller\Tool
 */
class Upload extends \Reamur\System\Engine\Controller {
	
	// Define constants for better maintainability
	private const MAX_FILENAME_LENGTH = 128;
	private const MIN_FILENAME_LENGTH = 3;
	private const TOKEN_LENGTH = 32;
	private const MAX_FILE_SIZE = 50 * 1024 * 1024; // 50MB default
	
	/**
	 * Ensure upload directory exists
	 * 
	 * @return void
	 */
	public function ensureDirectory(): void {
		$this->load->language('tool/upload');
		
		$json = [];
		
		// Check user has permission
		if (!$this->user->hasPermission('modify', 'tool/upload')) {
			$json['error'] = $this->language->get('error_permission');
			$this->log->write('Upload directory check: Permission denied');
		}
		
		if (!isset($json['error'])) {
			$upload_dir = DIR_STORAGE . 'upload/';
			$this->log->write('Upload directory check: Checking ' . $upload_dir);
			
			// Create directory if it doesn't exist
			if (!is_dir($upload_dir)) {
				$this->log->write('Upload directory check: Directory does not exist, attempting to create');
				if (!mkdir($upload_dir, 0777, true)) {
					$json['error'] = $this->language->get('error_directory');
					$this->log->write('Upload directory check: Failed to create directory ' . $upload_dir);
				} else {
					$json['success'] = $this->language->get('text_directory_created');
					$this->log->write('Upload directory check: Successfully created directory ' . $upload_dir);
					// Set permissions after creation
					@chmod($upload_dir, 0777);
				}
			} else {
				$this->log->write('Upload directory check: Directory exists');
				// Make sure the directory is writable
				if (!is_writable($upload_dir)) {
					$this->log->write('Upload directory check: Directory is not writable, attempting to set permissions');
					@chmod($upload_dir, 0777);
					
					if (!is_writable($upload_dir)) {
						$json['error'] = $this->language->get('error_directory_permission');
						$this->log->write('Upload directory check: Failed to make directory writable ' . $upload_dir);
					} else {
						$this->log->write('Upload directory check: Successfully set directory permissions ' . $upload_dir);
						$json['success'] = 'Directory is now writable';
					}
				} else {
					$this->log->write('Upload directory check: Directory is writable');
					$json['success'] = 'Directory exists and is writable';
				}
			}
		}
		
		// Add directory information to response
		$json['directory_info'] = [
			'path' => $upload_dir,
			'exists' => is_dir($upload_dir),
			'writable' => is_dir($upload_dir) && is_writable($upload_dir)
		];
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	/**
	 * @return void
	 */
	public function index(): void {
		$this->load->language('tool/upload');

		$this->document->setTitle($this->language->get('heading_title'));

		$url = $this->buildUrlParameters(['sort', 'order', 'page']);

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('tool/upload', 'user_token=' . $this->session->data['user_token'] . $url)
		];

		$data['add'] = $this->url->link('tool/upload.form', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('tool/upload.delete', 'user_token=' . $this->session->data['user_token']);

		$data['list'] = $this->getList();

		$data['user_token'] = $this->session->data['user_token'];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('tool/upload', $data));
	}

	/**
	 * @return void
	 */
	public function list(): void {
		$this->load->language('tool/upload');

		$this->response->setOutput($this->getList());
	}

	/**
	 * Build URL parameters from request
	 * 
	 * @param array $params
	 * @return string
	 */
	private function buildUrlParameters(array $params): string {
		$url = '';
		
		foreach ($params as $param) {
			if (isset($this->request->get[$param])) {
				$value = $param === 'filter_name' 
					? urlencode(html_entity_decode($this->request->get[$param], ENT_QUOTES, 'UTF-8'))
					: $this->request->get[$param];
				$url .= '&' . $param . '=' . $value;
			}
		}
		
		return $url;
	}

	/**
	 * @return string
	 */
	protected function getList(): string {
		// Sanitize and validate filter inputs
		$filter_name = $this->sanitizeString($this->request->get['filter_name'] ?? '');
		$filter_date_from = $this->validateDate($this->request->get['filter_date_from'] ?? '');
		$filter_date_to = $this->validateDate($this->request->get['filter_date_to'] ?? '');
		
		// Validate sort parameter against allowed values
		$allowed_sorts = ['name', 'code', 'date_added'];
		$sort = in_array($this->request->get['sort'] ?? '', $allowed_sorts) 
			? (string)$this->request->get['sort'] 
			: 'date_added';
		
		// Validate order parameter
		$order = strtoupper($this->request->get['order'] ?? '') === 'ASC' ? 'ASC' : 'DESC';
		
		// Validate page parameter
		$page = max(1, (int)($this->request->get['page'] ?? 1));

		$url = $this->buildUrlParameters(['filter_name', 'filter_date_from', 'filter_date_to', 'sort', 'order', 'page']);

		$data['action'] = $this->url->link('tool/upload.list', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['uploads'] = [];

		$filter_data = [
			'filter_name'      => $filter_name,
			'filter_date_from' => $filter_date_from,
			'filter_date_to'   => $filter_date_to,
			'sort'             => $sort,
			'order'            => $order,
			'start'            => ($page - 1) * $this->config->get('config_pagination_admin'),
			'limit'            => $this->config->get('config_pagination_admin')
		];

		$this->load->model('tool/upload');

		$upload_total = $this->model_tool_upload->getTotalUploads($filter_data);

		$results = $this->model_tool_upload->getUploads($filter_data);

		foreach ($results as $result) {
			$data['uploads'][] = [
				'upload_id'  => (int)$result['upload_id'],
				'name'       => htmlspecialchars($result['name'], ENT_QUOTES, 'UTF-8'),
				'code'       => htmlspecialchars($result['code'], ENT_QUOTES, 'UTF-8'),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'download'   => $this->url->link('tool/upload.download', 'user_token=' . $this->session->data['user_token'] . '&code=' . $result['code'] . $url)
			];
		}

		// Build sorting URLs
		$sort_url = $this->buildUrlParameters(['filter_name', 'filter_date_from', 'filter_date_to', 'page']);
		$sort_url .= '&order=' . ($order === 'ASC' ? 'DESC' : 'ASC');

		$data['sort_name'] = $this->url->link('tool/upload.list', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $sort_url);
		$data['sort_code'] = $this->url->link('tool/upload.list', 'user_token=' . $this->session->data['user_token'] . '&sort=code' . $sort_url);
		$data['sort_date_added'] = $this->url->link('tool/upload.list', 'user_token=' . $this->session->data['user_token'] . '&sort=date_added' . $sort_url);

		$pagination_url = $this->buildUrlParameters(['filter_name', 'filter_date_from', 'filter_date_to', 'sort', 'order']);

		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $upload_total,
			'page'  => $page,
			'limit' => $this->config->get('config_pagination_admin'),
			'url'   => $this->url->link('tool/upload.list', 'user_token=' . $this->session->data['user_token'] . $pagination_url . '&page={page}')
		]);

		$data['results'] = sprintf(
			$this->language->get('text_pagination'), 
			($upload_total) ? (($page - 1) * $this->config->get('config_pagination_admin')) + 1 : 0, 
			((($page - 1) * $this->config->get('config_pagination_admin')) > ($upload_total - $this->config->get('config_pagination_admin'))) 
				? $upload_total 
				: ((($page - 1) * $this->config->get('config_pagination_admin')) + $this->config->get('config_pagination_admin')), 
			$upload_total, 
			ceil($upload_total / $this->config->get('config_pagination_admin'))
		);

		$data['filter_name'] = $filter_name;
		$data['filter_date_from'] = $filter_date_from;
		$data['filter_date_to'] = $filter_date_to;

		$data['sort'] = $sort;
		$data['order'] = $order;

		return $this->load->view('tool/upload_list', $data);
	}

	/**
	 * Sanitize string input
	 * 
	 * @param string $input
	 * @return string
	 */
	private function sanitizeString(string $input): string {
		return trim(strip_tags($input));
	}

	/**
	 * Validate date format
	 * 
	 * @param string $date
	 * @return string
	 */
	private function validateDate(string $date): string {
		if (empty($date)) {
			return '';
		}
		
		// Validate date format (YYYY-MM-DD)
		if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) && strtotime($date) !== false) {
			return $date;
		}
		
		return '';
	}

	/**
	 * @return void
	 */
	public function delete(): void {
		$this->load->language('tool/upload');

		$json = [];

		$selected = $this->request->post['selected'] ?? [];

		// Validate selected array
		if (!is_array($selected)) {
			$selected = [];
		}

		// Sanitize selected upload IDs
		$selected = array_filter(array_map('intval', $selected));

		if (!$this->user->hasPermission('modify', 'tool/upload')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (empty($selected)) {
			$json['error'] = $this->language->get('error_selection');
		}

		if (empty($json['error'])) {
			$this->load->model('tool/upload');

			$deleted_count = 0;
			
			foreach ($selected as $upload_id) {
				try {
					// Remove file before deleting DB record.
					$upload_info = $this->model_tool_upload->getUpload($upload_id);

					if ($upload_info) {
						$file_path = DIR_UPLOAD . $upload_info['filename'];
						
						// Security check: ensure file is within upload directory
						if (realpath($file_path) && strpos(realpath($file_path), realpath(DIR_UPLOAD)) === 0) {
							if (is_file($file_path)) {
								if (unlink($file_path)) {
									$this->model_tool_upload->deleteUpload($upload_id);
									$deleted_count++;
								} else {
									$this->log->write('Failed to delete file: ' . $file_path);
								}
							} else {
								// File doesn't exist, just remove DB record
								$this->model_tool_upload->deleteUpload($upload_id);
								$deleted_count++;
							}
						} else {
							$this->log->write('Security: Attempted to delete file outside upload directory: ' . $file_path);
						}
					}
				} catch (\Exception $e) {
					$this->log->write('Error deleting upload ' . $upload_id . ': ' . $e->getMessage());
				}
			}

			if ($deleted_count > 0) {
				$json['success'] = sprintf($this->language->get('text_success_delete'), $deleted_count);
			} else {
				$json['error'] = $this->language->get('error_delete_failed');
			}
		}

		$this->sendJsonResponse($json);
	}

	/**
	 * @return void
	 */
	public function download(): void {
		$this->load->language('tool/upload');

		$code = $this->sanitizeString($this->request->get['code'] ?? '');

		if (empty($code)) {
			$this->showNotFoundPage();
			return;
		}

		$this->load->model('tool/upload');

		$upload_info = $this->model_tool_upload->getUploadByCode($code);

		if (!$upload_info) {
			$this->showNotFoundPage();
			return;
		}

		$file = DIR_UPLOAD . $upload_info['filename'];
		
		// Security check: ensure file is within upload directory
		$real_file_path = realpath($file);
		$real_upload_dir = realpath(DIR_UPLOAD);
		
		if (!$real_file_path || strpos($real_file_path, $real_upload_dir) !== 0) {
			$this->log->write('Security: Attempted to download file outside upload directory: ' . $file);
			$this->showNotFoundPage();
			return;
		}

		$mask = basename($upload_info['name']);

		if (headers_sent()) {
			exit($this->language->get('error_headers_sent'));
		}

		if (!is_file($file)) {
			exit(sprintf($this->language->get('error_not_found'), htmlspecialchars(basename($file))));
		}

		// Enhanced security headers
		header('Content-Type: application/octet-stream');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename="' . addslashes($mask ? $mask : basename($file)) . '"');
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		header('X-Content-Type-Options: nosniff');
		header('X-Frame-Options: DENY');

		// Use output buffering for better performance with large files
		if (ob_get_level()) {
			ob_end_clean();
		}

		$handle = fopen($file, 'rb');
		if ($handle === false) {
			exit('Error opening file');
		}

		while (!feof($handle)) {
			echo fread($handle, 8192);
			if (ob_get_level()) {
				ob_flush();
			}
			flush();
		}

		fclose($handle);
		exit;
	}

	/**
	 * Show 404 not found page
	 * 
	 * @return void
	 */
	private function showNotFoundPage(): void {
		$this->load->language('error/not_found');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('error/not_found', 'user_token=' . $this->session->data['user_token'])
		];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('error/not_found', $data));
	}

	/**
	 * @return void
	 */
	public function upload(): void {
		$this->load->language('tool/upload');

		$json = [];
		$log_errors = [];

		try {
			// Check user has permission
			if (!$this->user->hasPermission('modify', 'tool/upload')) {
				$json['error'] = $this->language->get('error_permission');
				$this->sendJsonResponse($json);
				return;
			}

			// Basic file upload validation
			if (empty($this->request->files['file']['name']) || !is_uploaded_file($this->request->files['file']['tmp_name'])) {
				$json['error'] = $this->language->get('error_upload');
				$this->sendJsonResponse($json);
				return;
			}

			$uploaded_file = $this->request->files['file'];

			// Check for upload errors first
			if ($uploaded_file['error'] !== UPLOAD_ERR_OK) {
				$error_message = $this->getUploadErrorMessage($uploaded_file['error']);
				$json['error'] = $this->language->get('error_upload') . ' ' . $error_message;
				$log_errors[] = 'Upload error code ' . $uploaded_file['error'] . ': ' . $error_message;
				$this->logErrors($log_errors);
				$this->sendJsonResponse($json);
				return;
			}

			// Validate file size
			$max_size = min(
				$this->parseBytes(ini_get('upload_max_filesize')),
				$this->parseBytes(ini_get('post_max_size')),
				self::MAX_FILE_SIZE
			);

			if ($uploaded_file['size'] > $max_size) {
				$json['error'] = sprintf($this->language->get('error_file_size'), $this->formatBytes($max_size));
				$this->sendJsonResponse($json);
				return;
			}

			// Sanitize and validate filename
			$filename = $this->sanitizeFilename($uploaded_file['name']);

			if (strlen($filename) < self::MIN_FILENAME_LENGTH || strlen($filename) > self::MAX_FILENAME_LENGTH) {
				$json['error'] = $this->language->get('error_filename');
				$this->sendJsonResponse($json);
				return;
			}

			// Validate file extension
			$file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			if (!$this->isAllowedExtension($file_ext)) {
				$json['error'] = $this->language->get('error_file_type');
				$this->sendJsonResponse($json);
				return;
			}

			// Validate MIME type
			$file_mime = $this->getFileMimeType($uploaded_file['tmp_name']);
			if (!$this->isAllowedMimeType($file_mime)) {
				$json['error'] = $this->language->get('error_file_type');
				$log_errors[] = 'File MIME type not allowed: ' . $file_mime;
				$this->logErrors($log_errors);
				$this->sendJsonResponse($json);
				return;
			}

			// Additional security checks
			if (!$this->performSecurityChecks($uploaded_file['tmp_name'], $filename)) {
				$json['error'] = $this->language->get('error_security_check');
				$this->sendJsonResponse($json);
				return;
			}

			// Process the file upload
			$result = $this->processFileUpload($uploaded_file, $filename, $file_ext);
			
			if ($result['success']) {
				$json = array_merge($json, $result);
			} else {
				$json['error'] = $result['error'];
			}

		} catch (\Exception $e) {
			$json['error'] = 'An unexpected error occurred during file upload.';
			$this->log->write('Upload exception: ' . $e->getMessage());
		}

		$this->sendJsonResponse($json);
	}

	/**
	 * Get upload error message
	 * 
	 * @param int $error_code
	 * @return string
	 */
	private function getUploadErrorMessage(int $error_code): string {
		$error_messages = [
			UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
			UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form',
			UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded',
			UPLOAD_ERR_NO_FILE    => 'No file was uploaded',
			UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
			UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
			UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload'
		];

		return $error_messages[$error_code] ?? 'Unknown upload error';
	}

	/**
	 * Parse bytes from PHP ini format
	 * 
	 * @param string $val
	 * @return int
	 */
	private function parseBytes(string $val): int {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		$val = (int)$val;
		
		switch($last) {
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}

	/**
	 * Format bytes to human readable format
	 * 
	 * @param int $bytes
	 * @return string
	 */
	private function formatBytes(int $bytes): string {
		$units = ['B', 'KB', 'MB', 'GB'];
		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		$bytes /= pow(1024, $pow);

		return round($bytes, 2) . ' ' . $units[$pow];
	}

	/**
	 * Sanitize filename
	 * 
	 * @param string $filename
	 * @return string
	 */
	private function sanitizeFilename(string $filename): string {
		// Decode HTML entities and remove dangerous characters
		$filename = html_entity_decode($filename, ENT_QUOTES, 'UTF-8');
		
		// Remove path separators and null bytes
		$filename = str_replace(['/', '\\', "\0"], '', $filename);
		
		// Remove control characters
		$filename = preg_replace('/[\x00-\x1F\x7F]/', '', $filename);
		
		return trim($filename);
	}

	/**
	 * Check if file extension is allowed
	 * 
	 * @param string $extension
	 * @return bool
	 */
	private function isAllowedExtension(string $extension): bool {
		$allowed_ext = array_filter(
			array_map('trim', 
				explode("\n", 
					preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'))
				)
			)
		);
		
		return in_array(strtolower($extension), array_map('strtolower', $allowed_ext));
	}

	/**
	 * Get file MIME type using multiple methods
	 * 
	 * @param string $file_path
	 * @return string
	 */
	private function getFileMimeType(string $file_path): string {
		// Use finfo if available (most reliable)
		if (function_exists('finfo_open')) {
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($finfo, $file_path);
			finfo_close($finfo);
			if ($mime) {
				return $mime;
			}
		}

		// Fallback to mime_content_type
		if (function_exists('mime_content_type')) {
			$mime = mime_content_type($file_path);
			if ($mime) {
				return $mime;
			}
		}

		// Last resort: use the browser-provided MIME type
		return $this->request->files['file']['type'] ?? 'application/octet-stream';
	}

	/**
	 * Check if MIME type is allowed
	 * 
	 * @param string $mime_type
	 * @return bool
	 */
	private function isAllowedMimeType(string $mime_type): bool {
		$allowed_mime = array_filter(
			array_map('trim', 
				explode("\n", 
					preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'))
				)
			)
		);
		
		return in_array(strtolower($mime_type), array_map('strtolower', $allowed_mime));
	}

	/**
	 * Perform additional security checks on uploaded file
	 * 
	 * @param string $temp_file
	 * @param string $filename
	 * @return bool
	 */
	private function performSecurityChecks(string $temp_file, string $filename): bool {
		// Check for executable file extensions in filename
		$dangerous_extensions = ['php', 'php3', 'php4', 'php5', 'phtml', 'exe', 'bat', 'cmd', 'com', 'scr', 'js', 'jar', 'vbs'];
		$file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		
		if (in_array($file_ext, $dangerous_extensions)) {
			$this->log->write('Security: Dangerous file extension detected: ' . $file_ext);
			return false;
		}

		// Check file content for suspicious patterns
		$file_content = file_get_contents($temp_file, false, null, 0, 1024); // Read first 1KB
		
		$suspicious_patterns = [
			'/\<\?php/i',
			'/\<script/i',
			'/eval\s*\(/i',
			'/exec\s*\(/i',
			'/system\s*\(/i',
			'/shell_exec\s*\(/i',
			'/passthru\s*\(/i'
		];

		foreach ($suspicious_patterns as $pattern) {
			if (preg_match($pattern, $file_content)) {
				$this->log->write('Security: Suspicious content detected in uploaded file');
				return false;
			}
		}

		return true;
	}

	/**
	 * Process the file upload
	 * 
	 * @param array $uploaded_file
	 * @param string $filename
	 * @param string $file_ext
	 * @return array
	 */
	private function processFileUpload(array $uploaded_file, string $filename, string $file_ext): array {
		// Ensure upload directory exists and is writable
		if (!$this->ensureUploadDirectory()) {
			return [
				'success' => false,
				'error' => $this->language->get('error_upload') . ' Upload directory is not writable.'
			];
		}

		try {
			// Generate a secure random filename
			$unique_token = $this->generateSecureToken();
			$file = $filename . '.' . $unique_token;
			$destination = DIR_UPLOAD . $file;

			if (!move_uploaded_file($uploaded_file['tmp_name'], $destination)) {
				$this->log->write('Upload error: Failed to move uploaded file to ' . $destination);
				return [
					'success' => false,
					'error' => $this->language->get('error_upload') . ' Failed to move uploaded file.'
				];
			}

			// Set secure file permissions
			chmod($destination, 0644);

			// Save to database and get the code
			$this->load->model('tool/upload');
			$code = $this->model_tool_upload->addUpload($filename, $file);

			$result = [
				'success' => true,
				'code' => $code,
				'message' => $this->language->get('text_success')
			];

			// Add thumbnail URL if it's an image
			if ($this->isImageFile($file_ext)) {
				$result['thumb'] = html_entity_decode(
					$this->url->link('tool/upload.download', 'user_token=' . $this->session->data['user_token'] . '&code=' . $code)
				);
			}

			return $result;

		} catch (\Exception $e) {
			$this->log->write('Upload exception: ' . $e->getMessage());
			return [
				'success' => false,
				'error' => 'Exception during file processing: ' . $e->getMessage()
			];
		}
	}

	/**
	 * Ensure upload directory exists and is writable
	 * 
	 * @return bool
	 */
	private function ensureUploadDirectory(): bool {
		if (!is_dir(DIR_UPLOAD)) {
			if (!mkdir(DIR_UPLOAD, 0755, true)) {
				$this->log->write('Upload error: Failed to create upload directory: ' . DIR_UPLOAD);
				return false;
			}
		}

		if (!is_writable(DIR_UPLOAD)) {
			$this->log->write('Upload error: Upload directory is not writable: ' . DIR_UPLOAD);
			return false;
		}

		return true;
	}

	/**
	 * Generate secure token
	 * 
	 * @return string
	 */
	private function generateSecureToken(): string {
		if (function_exists('rms_token')) {
			return rms_token(self::TOKEN_LENGTH);
		}
		
		// Fallback token generation
		if (function_exists('random_bytes')) {
			return bin2hex(random_bytes(self::TOKEN_LENGTH / 2));
		}
		
		// Last resort (less secure)
		return md5(uniqid(mt_rand(), true));
	}

	/**
	 * Check if file is an image
	 * 
	 * @param string $extension
	 * @return bool
	 */
	private function isImageFile(string $extension): bool {
		$image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
		return in_array(strtolower($extension), $image_extensions);
	}

	/**
	 * Log errors
	 * 
	 * @param array $errors
	 * @return void
	 */
	private function logErrors(array $errors): void {
		if (!empty($errors)) {
			$this->log->write('Upload errors: ' . implode(', ', $errors));
		}
	}

	/**
	 * Send JSON response
	 * 
	 * @param array $json
	 * @return void
	 */
	private function sendJsonResponse(array $json): void {
		// Clean any output buffer
		while (ob_get_level()) {
			$buffer = ob_get_contents();
			if (!empty($buffer)) {
				$this->log->write('Warning: Output buffer not empty before JSON response. Content: ' . $buffer);
			}
			ob_end_clean();
		}

		// Set proper headers
		$this->response->addHeader('Content-Type: application/json; charset=utf-8');
		$this->response->addHeader('X-Content-Type-Options: nosniff');

		try {
			// Encode JSON with proper options
			$output = json_encode($json, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
			$this->response->setOutput($output);
		} catch (\JsonException $e) {
			// If JSON encoding fails, create a fallback response
			$this->log->write('JSON encoding error: ' . $e->getMessage() . ' - Original data: ' . print_r($json, true));
			$fallback = json_encode(['error' => 'Server error occurred during response generation']);
			$this->response->setOutput($fallback);
		}
	}
}