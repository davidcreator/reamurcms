<?php
namespace Reamur\Admin\Controller\Common;
/**
 * Class File Manager
 *
 * @package Reamur\Admin\Controller\Common
 */
class FileManager extends \Reamur\System\Engine\Controller {
	/**
	 * Format file size in human readable format
	 *
	 * @param int $size File size in bytes
	 * @return string Formatted file size
	 */
	private function formatSize(int $size): string {
		$units = ['B', 'KB', 'MB', 'GB', 'TB'];
		$i = 0;
		while ($size >= 1024 && $i < count($units) - 1) {
			$size /= 1024;
			$i++;
		}
		return round($size, 2) . ' ' . $units[$i];
	}
	
	/**
	 * Parse size from PHP configuration (e.g., '2M' to bytes)
	 * 
	 * @param string $size
	 * @return int
	 */
	private function parseSize(string $size): int {
		$unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
		$size = preg_replace('/[^0-9\.]/', '', $size);
		
		if ($unit) {
			return (int)$size * pow(1024, stripos('bkmgtpezy', $unit[0]));
		}
		
		return (int)$size;
	}

	/**
	 * Validate image file using getimagesize for additional security
	 *
	 * @param string $file_path
	 * @return bool
	 */
	private function isValidImage(string $file_path): bool {
		$image_info = @getimagesize($file_path);
		if ($image_info === false) {
			return false;
		}
		
		// Check if it's a valid image type
		$allowed_image_types = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP, IMAGETYPE_ICO];
		return in_array($image_info[2], $allowed_image_types);
	}

	/**
	 * Sanitize filename for security
	 *
	 * @param string $filename
	 * @return string
	 */
	private function sanitizeFilename(string $filename): string {
		// Remove any path info and decode HTML entities
		$filename = basename(html_entity_decode($filename, ENT_QUOTES, 'UTF-8'));
		
		// Remove dangerous characters
		$filename = preg_replace('/[^\w\-_\.]/', '', $filename);
		
		// Prevent multiple dots (directory traversal)
		$filename = preg_replace('/\.+/', '.', $filename);
		
		// Remove leading/trailing dots and spaces
		$filename = trim($filename, '. ');
		
		return $filename;
	}

	/**
	 * @return void
	 */
	public function index(): void {
		$this->load->language('common/filemanager');

		$data['error_upload_size'] = sprintf($this->language->get('error_upload_size'), $this->config->get('config_file_max_size'));

		$data['config_file_max_size'] = ((int)$this->config->get('config_file_max_size') * 1024 * 1024);

		// Return the target ID for the file manager to set the value
		if (isset($this->request->get['target'])) {
			$data['target'] = $this->request->get['target'];
		} else {
			$data['target'] = '';
		}

		// Return the thumbnail for the file manager to show a thumbnail
		if (isset($this->request->get['thumb'])) {
			$data['thumb'] = $this->request->get['thumb'];
		} else {
			$data['thumb'] = '';
		}

		if (isset($this->request->get['ckeditor'])) {
			$data['ckeditor'] = $this->request->get['ckeditor'];
		} else {
			$data['ckeditor'] = '';
		}

		$data['user_token'] = $this->session->data['user_token'];

		$this->response->setOutput($this->load->view('common/filemanager', $data));
	}

	/**
	 * @return void
	 */
	public function list(): void {
		$this->load->language('common/filemanager');

		$base = DIR_IMAGE . 'catalog/';

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = $base . html_entity_decode($this->request->get['directory'], ENT_QUOTES, 'UTF-8') . '/';
		} else {
			$directory = $base;
		}

		if (isset($this->request->get['filter_name'])) {
			$filter_name = basename(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['page'])) {
			$page = (int)$this->request->get['page'];
		} else {
			$page = 1;
		}

		$allowed = [
			'.ico',
			'.jpg',
			'.jpeg',
			'.png',
			'.gif',
			'.webp',
			'.JPG',
			'.JPEG',
			'.PNG',
			'.GIF',
			'.WEBP'
		];

		$data['directories'] = [];
		$data['images'] = [];

		$this->load->model('tool/image');

		// Get directories and files
		$paths = array_merge(
			glob($directory . $filter_name . '*', GLOB_ONLYDIR),
			glob($directory . $filter_name . '*{' . implode(',', $allowed) . '}', GLOB_BRACE)
		);

		$total = count($paths);
		$limit = 16;
		$start = ($page - 1) * $limit;

		if ($paths) {
			// Split the array based on current page number and max number of items per page of 16
			foreach (array_slice($paths, $start, $limit) as $path) {
				$path = str_replace('\\', '/', realpath($path));

				if (substr($path, 0, strlen($base)) == $base) {
					$name = basename($path);

					$url = '';

					if (isset($this->request->get['target'])) {
						$url .= '&target=' . $this->request->get['target'];
					}

					if (isset($this->request->get['thumb'])) {
						$url .= '&thumb=' . $this->request->get['thumb'];
					}

					if (isset($this->request->get['ckeditor'])) {
						$url .= '&ckeditor=' . $this->request->get['ckeditor'];
					}

					if (is_dir($path)) {
						$data['directories'][] = [
							'name' => $name,
							'path' => rms_substr($path, rms_strlen($base)) . '/',
							'href' => $this->url->link('common/filemanager.list', 'user_token=' . $this->session->data['user_token'] . '&directory=' . urlencode(rms_substr($path, rms_strlen($base))) . $url)
						];
					}

					if (is_file($path) && in_array(substr($path, strrpos($path, '.')), $allowed)) {
						$data['images'][] = [
							'name'  => $name,
							'path'  => rms_substr($path, rms_strlen($base)),
							'href'  => HTTP_CATALOG . 'image/catalog/' . rms_substr($path, rms_strlen($base)),
							'thumb' => $this->model_tool_image->resize(rms_substr($path, rms_strlen(DIR_IMAGE)), 136, 136)
						];
					}
				}
			}
		}

		if (isset($this->request->get['directory'])) {
			$data['directory'] = urldecode($this->request->get['directory']);
		} else {
			$data['directory'] = '';
		}

		if (isset($this->request->get['filter_name'])) {
			$data['filter_name'] = $this->request->get['filter_name'];
		} else {
			$data['filter_name'] = '';
		}

		// Parent
		$url = '';

		if (isset($this->request->get['directory'])) {
			$pos = strrpos($this->request->get['directory'], '/');

			if ($pos) {
				$url .= '&directory=' . urlencode(substr($this->request->get['directory'], 0, $pos));
			}
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}

		if (isset($this->request->get['ckeditor'])) {
			$url .= '&ckeditor=' . $this->request->get['ckeditor'];
		}

		$data['parent'] = $this->url->link('common/filemanager.list', 'user_token=' . $this->session->data['user_token'] . $url);

		// Refresh
		$url = '';

		if (isset($this->request->get['directory'])) {
			$url .= '&directory=' . urlencode(html_entity_decode($this->request->get['directory'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}

		if (isset($this->request->get['ckeditor'])) {
			$url .= '&ckeditor=' . $this->request->get['ckeditor'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['refresh'] = $this->url->link('common/filemanager.list', 'user_token=' . $this->session->data['user_token'] . $url);

		$url = '';

		if (isset($this->request->get['directory'])) {
			$url .= '&directory=' . urlencode(html_entity_decode($this->request->get['directory'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['target'])) {
			$url .= '&target=' . $this->request->get['target'];
		}

		if (isset($this->request->get['thumb'])) {
			$url .= '&thumb=' . $this->request->get['thumb'];
		}

		if (isset($this->request->get['ckeditor'])) {
			$url .= '&ckeditor=' . $this->request->get['ckeditor'];
		}

		// Get total number of files and directories
		$data['pagination'] = $this->load->controller('common/pagination', [
			'total' => $total,
			'page'  => $page,
			'limit' => $limit,
			'url'   => $this->url->link('common/filemanager.list', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}')
		]);

		$this->response->setOutput($this->load->view('common/filemanager_list', $data));
	}

	/**
	 * @return void
	 */
	public function upload(): void {
		$this->load->language('common/filemanager');

		$json = [];
		
		// Log PHP upload configuration
		$this->log->write('Filemanager upload: PHP configuration - file_uploads: ' . ini_get('file_uploads'));
		$this->log->write('Filemanager upload: PHP configuration - upload_max_filesize: ' . ini_get('upload_max_filesize'));
		$this->log->write('Filemanager upload: PHP configuration - post_max_size: ' . ini_get('post_max_size'));
		$this->log->write('Filemanager upload: PHP configuration - max_file_uploads: ' . ini_get('max_file_uploads'));
		$this->log->write('Filemanager upload: PHP configuration - memory_limit: ' . ini_get('memory_limit'));

		$base = DIR_IMAGE . 'catalog/';

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = $base . html_entity_decode($this->request->get['directory'], ENT_QUOTES, 'UTF-8') . '/';
		} else {
			$directory = $base;
		}

		// Normalize directory path
		$directory = str_replace(['\\', '//'], '/', $directory);
		$directory = rtrim($directory, '/') . '/';

		// Check it's a directory and within allowed base path
		if (!is_dir($directory) || substr(str_replace('\\', '/', realpath($directory)) . '/', 0, strlen($base)) != $base) {
			$json['error'] = $this->language->get('error_directory');
		}

		// Create directory if not exists
		if (!$json && !is_dir($directory)) {
			if (!mkdir($directory, 0755, true)) {
				$json['error'] = $this->language->get('error_directory_create');
			} else {
				// Set proper permissions
				chmod($directory, 0755);
			}
		}
		
		// Check if directory is writable
		if (!$json && (!is_dir($directory) || !is_writable($directory))) {
			$json['error'] = $this->language->get('error_permission') . ' Directory not writable.';
		}
		
		// Add more detailed error logging
		if (isset($json['error'])) {
			$this->log->write('File Upload Error: ' . $json['error']);
		}

		if (!$json) {
			// Check if any files were uploaded
			if (empty($_FILES['file']['name']) || (is_array($_FILES['file']['name']) && empty(array_filter($_FILES['file']['name'])))) {
				$json['error'] = $this->language->get('error_upload') . ' No files selected.';
			} else {
				// Check if multiple files are uploaded or just one
				$files = [];

				if (is_array($this->request->files['file']['name'])) {
					foreach (array_keys($this->request->files['file']['name']) as $key) {
						if (!empty($this->request->files['file']['name'][$key])) {
							$files[] = [
								'name'     => $this->request->files['file']['name'][$key],
								'type'     => $this->request->files['file']['type'][$key],
								'tmp_name' => $this->request->files['file']['tmp_name'][$key],
								'error'    => $this->request->files['file']['error'][$key],
								'size'     => $this->request->files['file']['size'][$key]
							];
						}
					}
				} else {
					// Handle single file upload
					$files[] = [
						'name'     => $this->request->files['file']['name'],
						'type'     => $this->request->files['file']['type'],
						'tmp_name' => $this->request->files['file']['tmp_name'],
						'error'    => $this->request->files['file']['error'],
						'size'     => $this->request->files['file']['size']
					];
				}

				$uploaded_files = 0;
				$error_files = [];

				foreach ($files as $file) {
					// Check upload errors first
					if ($file['error'] != UPLOAD_ERR_OK) {
						$error_message = $this->getUploadErrorMessage($file['error']);
						$error_files[] = $file['name'] . ': ' . $error_message;
						$this->log->write('Filemanager upload error: ' . $error_message . ' for file ' . $file['name']);
						continue;
					}

					// Check if temporary file exists
					if (!is_file($file['tmp_name'])) {
						$error_files[] = $file['name'] . ': Temporary file not found';
						$this->log->write('Filemanager upload error: Temporary file not found for ' . $file['name']);
						continue;
					}

					// Sanitize the filename
					$filename = $this->sanitizeFilename($file['name']);

					// Validate the filename length
					if (strlen($filename) < 4 || strlen($filename) > 255) {
						$error_files[] = $file['name'] . ': Invalid filename length';
						continue;
					}

					// Check if filename is empty after sanitization
					if (empty($filename)) {
						$error_files[] = $file['name'] . ': Invalid filename';
						continue;
					}

					// Get file extension
					$file_extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

					// Allowed file extensions for images only
					$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico'];

					if (!in_array($file_extension, $allowed_extensions)) {
						$error_files[] = $filename . ': File type not allowed';
						continue;
					}

					// Validate MIME type
					$allowed_mime = [
						'image/jpeg',
						'image/pjpeg', 
						'image/png',
						'image/x-png',
						'image/gif',
						'image/webp',
						'image/x-icon',
						'image/vnd.microsoft.icon'
					];

					if (!in_array($file['type'], $allowed_mime)) {
						$error_files[] = $filename . ': Invalid MIME type (' . $file['type'] . ')';
						continue;
					}

					// Additional validation for images using getimagesize
					if (!$this->isValidImage($file['tmp_name'])) {
						$error_files[] = $filename . ': Not a valid image file';
						continue;
					}

					// File size validation
					$php_max_upload = $this->parseSize(ini_get('upload_max_filesize'));
					$php_max_post = $this->parseSize(ini_get('post_max_size'));
					$max_file_size = min($php_max_upload, $php_max_post, 10 * 1024 * 1024); // 10MB max

					if ($file['size'] > $max_file_size) {
						$error_files[] = $filename . ': File too large (max: ' . $this->formatSize($max_file_size) . ')';
						continue;
					}

					// Check if file already exists and generate unique name if needed
					$destination = $directory . $filename;
					$counter = 1;
					$file_info = pathinfo($filename);
					$base_name = $file_info['filename'];
					$extension = isset($file_info['extension']) ? '.' . $file_info['extension'] : '';

					while (file_exists($destination)) {
						$new_filename = $base_name . '_' . $counter . $extension;
						$destination = $directory . $new_filename;
						$counter++;
					}

					// Try to move the uploaded file
					if (move_uploaded_file($file['tmp_name'], $destination)) {
						// Set proper file permissions
						chmod($destination, 0644);
						$uploaded_files++;
						$this->log->write('Filemanager upload success: ' . basename($destination));
					} else {
						$error_files[] = $filename . ': Failed to move uploaded file';
						$this->log->write('Filemanager upload error: Failed to move ' . $filename . ' to ' . $destination);
					}
				}

				// Set response message
				if ($uploaded_files > 0) {
					if (count($error_files) > 0) {
						$json['success'] = $uploaded_files . ' file(s) uploaded successfully';
						$json['warning'] = 'Some files had errors: ' . implode('; ', $error_files);
					} else {
						$json['success'] = $this->language->get('text_uploaded');
					}
				} else {
					$json['error'] = 'Upload failed: ' . implode('; ', $error_files);
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	/**
	 * Get human readable upload error message
	 *
	 * @param int $error_code
	 * @return string
	 */
	private function getUploadErrorMessage(int $error_code): string {
		switch ($error_code) {
			case UPLOAD_ERR_INI_SIZE:
				return 'File exceeds upload_max_filesize directive';
			case UPLOAD_ERR_FORM_SIZE:
				return 'File exceeds MAX_FILE_SIZE directive';
			case UPLOAD_ERR_PARTIAL:
				return 'File was only partially uploaded';
			case UPLOAD_ERR_NO_FILE:
				return 'No file was uploaded';
			case UPLOAD_ERR_NO_TMP_DIR:
				return 'Missing temporary folder';
			case UPLOAD_ERR_CANT_WRITE:
				return 'Failed to write file to disk';
			case UPLOAD_ERR_EXTENSION:
				return 'PHP extension stopped the file upload';
			default:
				return 'Unknown upload error';
		}
	}

	/**
	 * @return void
	 */
	public function folder(): void {
		$this->load->language('common/filemanager');

		$json = [];

		$base = DIR_IMAGE . 'catalog/';

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		// Make sure we have the correct directory
		if (isset($this->request->get['directory'])) {
			$directory = $base . html_entity_decode($this->request->get['directory'], ENT_QUOTES, 'UTF-8') . '/';
		} else {
			$directory = $base;
		}

		// Check its a directory
		if (!is_dir($directory) || substr(str_replace('\\', '/', realpath($directory)) . '/', 0, strlen($base)) != $base) {
			$json['error'] = $this->language->get('error_directory');
		}

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			// Sanitize the folder name
			$folder = preg_replace('/[^\w\-_]/', '', basename(html_entity_decode($this->request->post['folder'], ENT_QUOTES, 'UTF-8')));

			// Validate the filename length
			if (strlen($folder) < 3 || strlen($folder) > 128) {
				$json['error'] = $this->language->get('error_folder');
			}

			// Check if directory already exists or not
			if (is_dir($directory . $folder)) {
				$json['error'] = $this->language->get('error_exists');
			}

			if (!$json) {
				if (mkdir($directory . $folder, 0755)) {
					chmod($directory . $folder, 0755);
					@touch($directory . $folder . '/index.html');
					$json['success'] = $this->language->get('text_directory');
				} else {
					$json['error'] = 'Failed to create directory';
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	/**
	 * @return void
	 */
	public function delete(): void {
		$this->load->language('common/filemanager');

		$json = [];

		$base = DIR_IMAGE . 'catalog/';

		// Check user has permission
		if (!$this->user->hasPermission('modify', 'common/filemanager')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (isset($this->request->post['path'])) {
			$paths = $this->request->post['path'];
		} else {
			$paths = [];
		}

		// Loop through each path to run validations
		foreach ($paths as $path) {
			// Convert any html encoded characters.
			$path = html_entity_decode($path, ENT_QUOTES, 'UTF-8');

			// Check path exists and is within base directory
			$full_path = $base . $path;
			$real_path = realpath($full_path);
			
			if ($path == '' || $real_path === false || substr(str_replace('\\', '/', $real_path) . '/', 0, strlen($base)) != $base) {
				$json['error'] = $this->language->get('error_delete');
				break;
			}
		}

		if (!$json) {
			// Loop through each path
			foreach ($paths as $path) {
				$path = rtrim($base . html_entity_decode($path, ENT_QUOTES, 'UTF-8'), '/');

				$files = [];

				// Make path into an array
				$directory = [$path];

				// While the path array is still populated keep looping through
				while (count($directory) != 0) {
					$next = array_shift($directory);

					if (is_dir($next)) {
						foreach (glob(trim($next, '/') . '/{*,.[!.]*,..?*}', GLOB_BRACE) as $file) {
							// If directory add to path array
							$directory[] = $file;
						}
					}

					// Add the file to the files to be deleted array
					$files[] = $next;
				}

				// Reverse sort the file array
				rsort($files);

				foreach ($files as $file) {
					// If file just delete
					if (is_file($file)) {
						unlink($file);
					}

					// If directory use the remove directory function
					if (is_dir($file)) {
						rmdir($file);
					}
				}
			}

			$json['success'] = $this->language->get('text_delete');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}