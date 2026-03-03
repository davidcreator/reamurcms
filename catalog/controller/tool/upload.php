<?php
namespace Reamur\Catalog\Controller\Tool;

use Reamur\System\Library\Security\UploadSecurity;

/**
 * Class Upload
 *
 * @package Reamur\Catalog\Controller\Tool
 */
class Upload extends \Reamur\System\Engine\Controller {
	/**
	 * @return void
	 */
	public function index(): void {
		$this->load->language('tool/upload');

		$json = [];
		$log_errors = [];

		// Check if file was uploaded
		if (empty($this->request->files['file']['name'])) {
			$json['error'] = $this->language->get('error_upload');
			$log_errors[] = 'No file uploaded';
		} elseif (!is_file($this->request->files['file']['tmp_name'])) {
			$json['error'] = $this->language->get('error_upload');
			$log_errors[] = 'Uploaded file is not a valid file';
		} else {
			// Initialize the upload security class
			$uploadSecurity = $this->getUploadSecurity();
			
			// Validate the upload with enhanced security
			$securityResult = $uploadSecurity->validateUpload($this->request->files['file']);
			
			// If security validation failed, return error
			if (!$securityResult['valid']) {
				$json['error'] = $this->language->get('error_security') ?: 'File failed security validation';
				$json['validation_details'] = $securityResult['messages'];
				$log_errors[] = 'Security validation failed: ' . implode(', ', $securityResult['messages']);
			} else {
				// Generate a secure filename
				$filename = $uploadSecurity->secureFilename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));

				// Validate the filename length
				if ((rms_strlen($filename) < 3) || (rms_strlen($filename) > 64)) {
					$json['error'] = $this->language->get('error_filename');
					$log_errors[] = 'Filename length invalid: ' . rms_strlen($filename) . ' characters';
				}

				// Allowed file extension types
				$allowed = [];

				$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));

				$filetypes = explode("\n", $extension_allowed);

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				$file_ext = strtolower(substr(strrchr($filename, '.'), 1));
				if (!in_array($file_ext, $allowed)) {
					$json['error'] = $this->language->get('error_file_type');
					$json['validation_details'] = ['File extension not allowed: ' . $file_ext];
					$json['allowed_extensions'] = $allowed;
					$log_errors[] = 'File extension not allowed: ' . $file_ext;
				}

				// Allowed file mime types
				$allowed = [];

				$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));

				$filetypes = explode("\n", $mime_allowed);

				foreach ($filetypes as $filetype) {
					$allowed[] = trim($filetype);
				}

				if (!in_array($this->request->files['file']['type'], $allowed)) {
					$json['error'] = $this->language->get('error_file_type');
					$json['validation_details'] = ['File MIME type not allowed: ' . $this->request->files['file']['type']];
					$json['allowed_mimes'] = $allowed;
					$log_errors[] = 'File MIME type not allowed: ' . $this->request->files['file']['type'];
				}

				// Return any upload error
				if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
					$error_code = $this->request->files['file']['error'];
					$error_message = '';
					
					// Provide detailed error messages
					switch ($error_code) {
						case UPLOAD_ERR_INI_SIZE:
							$error_message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
							break;
						case UPLOAD_ERR_FORM_SIZE:
							$error_message = 'The uploaded file exceeds the MAX_FILE_SIZE directive in the HTML form';
							break;
						case UPLOAD_ERR_PARTIAL:
							$error_message = 'The uploaded file was only partially uploaded';
							break;
						case UPLOAD_ERR_NO_FILE:
							$error_message = 'No file was uploaded';
							break;
						case UPLOAD_ERR_NO_TMP_DIR:
							$error_message = 'Missing a temporary folder';
							break;
						case UPLOAD_ERR_CANT_WRITE:
							$error_message = 'Failed to write file to disk';
							break;
						case UPLOAD_ERR_EXTENSION:
							$error_message = 'A PHP extension stopped the file upload';
							break;
						default:
							$error_message = 'Unknown upload error';
					}
					
					$json['error'] = $this->language->get('error_upload') . ' ' . $error_message;
					$json['validation_details'] = [$error_message];
					$log_errors[] = 'Upload error code ' . $error_code . ': ' . $error_message;
				}
			}
		}

		// Log errors if any occurred
		if (!empty($log_errors) && method_exists($this, 'log')) {
			$this->log->write('Upload error: ' . implode(', ', $log_errors));
		}

		if (!isset($json['error'])) {
			// Ensure upload directory exists and is writable
			if (!is_dir(DIR_UPLOAD) || !is_writable(DIR_UPLOAD)) {
				$json['error'] = $this->language->get('error_upload') . ' Upload directory is not writable.';
				$json['validation_details'] = ['Upload directory is not writable'];
				if (method_exists($this, 'log')) {
					$this->log->write('Upload error: Upload directory is not writable: ' . DIR_UPLOAD);
				}
			} else {
				// Generate a unique filename with a token
				$file = $filename . '.' . rms_token(32);
				$destination = DIR_UPLOAD . $file;

				if (!move_uploaded_file($this->request->files['file']['tmp_name'], $destination)) {
					$json['error'] = $this->language->get('error_upload') . ' Failed to move uploaded file.';
					$json['validation_details'] = ['Failed to move uploaded file to destination'];
					if (method_exists($this, 'log')) {
						$this->log->write('Upload error: Failed to move uploaded file to ' . $destination);
					}
				} else {
					// Hide the uploaded file name so people cannot link to it directly.
					$this->load->model('tool/upload');

					$json['code'] = $this->model_tool_upload->addUpload($filename, $file);
					$json['success'] = $this->language->get('text_upload');
					
					// Add file information for the client
					$json['file_info'] = [
						'name' => $filename,
						'size' => $this->request->files['file']['size'],
						'type' => $this->request->files['file']['type']
					];
				}
			}
		}

		// Add upload limits to the response for client-side validation
		if (!isset($json['upload_limits'])) {
			$json['upload_limits'] = [
				'max_file_size' => $this->getMaxUploadSize(),
				'allowed_extensions' => $this->getAllowedExtensions(),
				'allowed_mime_types' => $this->getAllowedMimeTypes()
			];
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	/**
	 * Get the upload security instance
	 *
	 * @return UploadSecurity
	 */
	protected function getUploadSecurity(): UploadSecurity {
		// Configure the upload security with system settings
		$config = [
			'max_file_size' => $this->getMaxUploadSize(true),
			'allowed_extensions' => $this->getAllowedExtensions(),
			'allowed_mime_types' => $this->getAllowedMimeTypes(),
		];
		
		return new UploadSecurity($config, $this->log);
	}
	
	/**
	 * Get the maximum upload size in bytes
	 *
	 * @param bool $inBytes Whether to return the size in bytes (true) or KB (false)
	 * @return int|float The maximum upload size
	 */
	protected function getMaxUploadSize(bool $inBytes = false) {
		// Get the PHP upload limit
		$maxUpload = $this->parseSize(ini_get('upload_max_filesize'));
		$maxPost = $this->parseSize(ini_get('post_max_size'));
		
		// Get the smaller of the two limits
		$maxSize = min($maxUpload, $maxPost);
		
		// Get the system config limit if set
		$configLimit = $this->config->get('config_file_max_size');
		
		if ($configLimit) {
			$configLimit = (int)$configLimit * 1024; // Convert KB to bytes
			$maxSize = min($maxSize, $configLimit);
		}
		
		return $inBytes ? $maxSize : ($maxSize / 1024); // Return in KB if not in bytes
	}
	
	/**
	 * Parse PHP size string to bytes
	 *
	 * @param string $size Size string (e.g., '2M', '1G')
	 * @return int Size in bytes
	 */
	protected function parseSize(string $size): int {
		$unit = preg_replace('/[^bkmgtpezy]/i', '', $size);
		$size = preg_replace('/[^0-9\.]/', '', $size);
		
		if ($unit) {
			return (int)($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
		}
		
		return (int)$size;
	}
	
	/**
	 * Get allowed file extensions
	 *
	 * @return array Array of allowed extensions
	 */
	protected function getAllowedExtensions(): array {
		$allowed = [];
		$extension_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_ext_allowed'));
		$filetypes = explode("\n", $extension_allowed);
		
		foreach ($filetypes as $filetype) {
			$allowed[] = trim($filetype);
		}
		
		return $allowed;
	}
	
	/**
	 * Get allowed MIME types
	 *
	 * @return array Array of allowed MIME types
	 */
	protected function getAllowedMimeTypes(): array {
		$allowed = [];
		$mime_allowed = preg_replace('~\r?\n~', "\n", $this->config->get('config_file_mime_allowed'));
		$filetypes = explode("\n", $mime_allowed);
		
		foreach ($filetypes as $filetype) {
			$allowed[] = trim($filetype);
		}
		
		return $allowed;
	}
}
