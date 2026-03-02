<?php
namespace Reamur\Admin\Model\Tool;

/**
 * Class Upload
 *
 * Handles upload management operations including CRUD operations
 * for upload records in the database.
 * 
 * Based on OpenCart's upload model structure for compatibility.
 *
 * @package Reamur\Admin\Model\Tool
 */
class Upload extends \Reamur\System\Engine\Model {
	
	/**
	 * Add a new upload record to the database
	 *
	 * @param string $name The display name of the upload
	 * @param string $filename The actual filename of the uploaded file
	 *
	 * @return string The generated unique code for the upload
	 * @throws \InvalidArgumentException If name or filename is empty
	 */
	public function addUpload(string $name, string $filename): string {
		// Validate input parameters
		if (empty(trim($name))) {
			throw new \InvalidArgumentException('Upload name cannot be empty');
		}
		
		if (empty(trim($filename))) {
			throw new \InvalidArgumentException('Upload filename cannot be empty');
		}
		
		// Generate a unique code for this upload
		$code = '';
		$max_attempts = 5;
		
		for ($i = 0; $i < $max_attempts; $i++) {
			// Use token generation function if available, otherwise use md5
			if (function_exists('rms_token')) {
				$code = rms_token(32);
			} else {
				$code = md5(mt_rand() . microtime(true) . $name . $filename);
			}
			
			// Check if code is unique
			if ($this->isCodeUnique($code)) {
				break;
			}
		}
		
		if (empty($code) || !$this->isCodeUnique($code)) {
			// Last resort if we couldn't generate a unique code
			$code = md5(uniqid(mt_rand(), true) . $name . $filename . time());
		}

		$sql = "INSERT INTO `" . DB_PREFIX . "upload` 
				SET `name` = '" . $this->db->escape($name) . "', 
					`filename` = '" . $this->db->escape($filename) . "', 
					`code` = '" . $this->db->escape($code) . "', 
					`date_added` = NOW()";
		
		$this->db->query($sql);
		
		// Get the upload_id for the newly inserted record
		$upload_id = $this->db->getLastId();
		
		// Log the successful upload
		if (defined('DIR_LOGS') && is_writable(DIR_LOGS)) {
			$log_message = date('Y-m-d H:i:s') . " - Upload added: ID=" . $upload_id . ", Name=" . $name . ", Code=" . $code . "\n";
			file_put_contents(DIR_LOGS . 'upload.log', $log_message, FILE_APPEND);
		}

		return $code;
	}

	/**
	 * Delete an upload record from the database
	 *
	 * @param int $upload_id The ID of the upload to delete
	 *
	 * @return bool Returns true if deletion was successful, false otherwise
	 * @throws \InvalidArgumentException If upload_id is not positive
	 */
	public function deleteUpload(int $upload_id): bool {
		if ($upload_id <= 0) {
			throw new \InvalidArgumentException('Upload ID must be a positive integer');
		}
		
		$sql = "DELETE FROM `" . DB_PREFIX . "upload` WHERE `upload_id` = '" . (int)$upload_id . "'";
		$this->db->query($sql);
		
		return $this->db->countAffected() > 0;
	}

	/**
	 * Retrieve a single upload record by ID
	 *
	 * @param int $upload_id The ID of the upload to retrieve
	 *
	 * @return array The upload record or empty array if not found
	 * @throws \InvalidArgumentException If upload_id is not positive
	 */
	public function getUpload(int $upload_id): array {
		if ($upload_id <= 0) {
			throw new \InvalidArgumentException('Upload ID must be a positive integer');
		}
		
		$sql = "SELECT `upload_id`, `name`, `filename`, `code`, `date_added` 
				FROM `" . DB_PREFIX . "upload` 
				WHERE `upload_id` = '" . (int)$upload_id . "'";
		
		$query = $this->db->query($sql);

		return $query->row ?? [];
	}

	/**
	 * Retrieve a single upload record by unique code
	 *
	 * @param string $code The unique code of the upload to retrieve
	 *
	 * @return array The upload record or empty array if not found
	 * @throws \InvalidArgumentException If code is empty
	 */
	public function getUploadByCode(string $code): array {
		if (empty(trim($code))) {
			throw new \InvalidArgumentException('Upload code cannot be empty');
		}
		
		$sql = "SELECT `upload_id`, `name`, `filename`, `code`, `date_added` 
				FROM `" . DB_PREFIX . "upload` 
				WHERE `code` = '" . $this->db->escape($code) . "'";
		
		$query = $this->db->query($sql);

		return $query->row ?? [];
	}

	/**
	 * Retrieve multiple upload records with filtering, sorting, and pagination
	 *
	 * @param array $data Filter and pagination parameters
	 *   - filter_name: Filter by name (LIKE search)
	 *   - filter_code: Filter by code (LIKE search)
	 *   - filter_date_from: Filter by date from (inclusive)
	 *   - filter_date_to: Filter by date to (inclusive)
	 *   - sort: Sort field (name, code, date_added)
	 *   - order: Sort order (ASC, DESC)
	 *   - start: Pagination start offset
	 *   - limit: Pagination limit
	 *
	 * @return array Array of upload records
	 */
	public function getUploads(array $data = []): array {
		$sql = "SELECT `upload_id`, `name`, `filename`, `code`, `date_added` 
				FROM `" . DB_PREFIX . "upload`";

		$where_conditions = [];

		// Build WHERE conditions
		if (!empty($data['filter_name'])) {
			$where_conditions[] = "`name` LIKE '" . $this->db->escape((string)$data['filter_name']) . "%'";
		}

		if (!empty($data['filter_code'])) {
			$where_conditions[] = "`code` LIKE '" . $this->db->escape((string)$data['filter_code']) . "%'";
		}

		if (!empty($data['filter_date_from'])) {
			$where_conditions[] = "DATE(`date_added`) >= DATE('" . $this->db->escape((string)$data['filter_date_from']) . "')";
		}

		if (!empty($data['filter_date_to'])) {
			$where_conditions[] = "DATE(`date_added`) <= DATE('" . $this->db->escape((string)$data['filter_date_to']) . "')";
		}

		if ($where_conditions) {
			$sql .= " WHERE " . implode(" AND ", $where_conditions);
		}

		// Allowed sort fields for security
		$allowed_sort_fields = ['name', 'code', 'date_added'];
		$sort_field = 'date_added'; // default
		
		if (isset($data['sort']) && in_array($data['sort'], $allowed_sort_fields)) {
			$sort_field = $data['sort'];
		}
		
		$sql .= " ORDER BY `" . $sort_field . "`";

		// Sort order validation
		$order = 'ASC'; // default
		if (isset($data['order']) && strtoupper($data['order']) === 'DESC') {
			$order = 'DESC';
		}
		$sql .= " " . $order;

		// Pagination with validation
		if (isset($data['start']) || isset($data['limit'])) {
			$start = max(0, (int)($data['start'] ?? 0));
			$limit = max(1, min(1000, (int)($data['limit'] ?? 20))); // Max 1000 records per page
			
			$sql .= " LIMIT " . $start . ", " . $limit;
		}
		
		$query = $this->db->query($sql);

		return $query->rows ?? [];
	}

	/**
	 * Get total count of uploads matching the filter criteria
	 *
	 * @param array $data Filter parameters (same as getUploads)
	 *
	 * @return int Total count of matching uploads
	 */
	public function getTotalUploads(array $data = []): int {
		$sql = "SELECT COUNT(*) AS `total` FROM `" . DB_PREFIX . "upload`";

		$where_conditions = [];

		// Build WHERE conditions (same logic as getUploads)
		if (!empty($data['filter_name'])) {
			$where_conditions[] = "`name` LIKE '" . $this->db->escape((string)$data['filter_name']) . "%'";
		}

		if (!empty($data['filter_code'])) {
			$where_conditions[] = "`code` LIKE '" . $this->db->escape((string)$data['filter_code']) . "%'";
		}

		if (!empty($data['filter_date_from'])) {
			$where_conditions[] = "DATE(`date_added`) >= DATE('" . $this->db->escape((string)$data['filter_date_from']) . "')";
		}

		if (!empty($data['filter_date_to'])) {
			$where_conditions[] = "DATE(`date_added`) <= DATE('" . $this->db->escape((string)$data['filter_date_to']) . "')";
		}

		if ($where_conditions) {
			$sql .= " WHERE " . implode(" AND ", $where_conditions);
		}
		
		$query = $this->db->query($sql);

		return (int)($query->row['total'] ?? 0);
	}

	/**
	 * Check if an upload exists by ID
	 *
	 * @param int $upload_id The ID to check
	 *
	 * @return bool True if upload exists, false otherwise
	 */
	public function uploadExists(int $upload_id): bool {
		if ($upload_id <= 0) {
			return false;
		}
		
		$sql = "SELECT 1 FROM `" . DB_PREFIX . "upload` WHERE `upload_id` = '" . (int)$upload_id . "' LIMIT 1";
		$query = $this->db->query($sql);
		
		return !empty($query->row);
	}

	/**
	 * Check if an upload code is unique
	 *
	 * @param string $code The code to check
	 *
	 * @return bool True if code is unique, false otherwise
	 */
	public function isCodeUnique(string $code): bool {
		if (empty(trim($code))) {
			return false;
		}
		
		$sql = "SELECT 1 FROM `" . DB_PREFIX . "upload` WHERE `code` = '" . $this->db->escape($code) . "' LIMIT 1";
		$query = $this->db->query($sql);
		
		return empty($query->row);
	}
	
	/**
	 * Check if the physical file exists for an upload
	 *
	 * @param int|string $upload_id_or_code The upload ID or code
	 * @param bool $is_code Whether the first parameter is a code (true) or ID (false)
	 *
	 * @return bool True if file exists, false otherwise
	 */
	public function fileExists($upload_id_or_code, bool $is_code = false): bool {
		$upload_info = $is_code ? $this->getUploadByCode($upload_id_or_code) : $this->getUpload($upload_id_or_code);
		
		if (empty($upload_info) || empty($upload_info['filename'])) {
			return false;
		}
		
		$file_path = DIR_UPLOAD . $upload_info['filename'];
		
		// Security check: ensure file is within upload directory
		$real_file_path = realpath($file_path);
		$real_upload_dir = realpath(DIR_UPLOAD);
		
		if (!$real_file_path || strpos($real_file_path, $real_upload_dir) !== 0) {
			return false;
		}
		
		return is_file($file_path) && is_readable($file_path);
	}
	
	/**
	 * Get the file path for an upload
	 *
	 * @param int|string $upload_id_or_code The upload ID or code
	 * @param bool $is_code Whether the first parameter is a code (true) or ID (false)
	 *
	 * @return string|null The file path or null if not found
	 */
	public function getFilePath($upload_id_or_code, bool $is_code = false): ?string {
		$upload_info = $is_code ? $this->getUploadByCode($upload_id_or_code) : $this->getUpload($upload_id_or_code);
		
		if (empty($upload_info) || empty($upload_info['filename'])) {
			return null;
		}
		
		$file_path = DIR_UPLOAD . $upload_info['filename'];
		
		// Security check: ensure file is within upload directory
		$real_file_path = realpath($file_path);
		$real_upload_dir = realpath(DIR_UPLOAD);
		
		if (!$real_file_path || strpos($real_file_path, $real_upload_dir) !== 0) {
			return null;
		}
		
		return $file_path;
	}
	
	/**
	 * Clean up old uploads based on age
	 *
	 * @param int $days Number of days to keep uploads (default: 30)
	 * @return int Number of uploads deleted
	 */
	public function cleanOldUploads(int $days = 30): int {
		// Validate input
		$days = max(1, $days); // Minimum 1 day
		
		// Get uploads older than specified days
		$date = date('Y-m-d', strtotime('-' . $days . ' days'));
		
		$sql = "SELECT `upload_id`, `filename` FROM `" . DB_PREFIX . "upload` 
				WHERE DATE(`date_added`) < '" . $this->db->escape($date) . "'";
		
		$query = $this->db->query($sql);
		
		$count = 0;
		
		foreach ($query->rows as $result) {
			$file_path = DIR_UPLOAD . $result['filename'];
			
			// Security check: ensure file is within upload directory
			$real_file_path = realpath($file_path);
			$real_upload_dir = realpath(DIR_UPLOAD);
			
			if ($real_file_path && strpos($real_file_path, $real_upload_dir) === 0) {
				// Delete physical file if it exists
				if (is_file($file_path)) {
					@unlink($file_path);
				}
			}
			
			// Delete database record
			$this->deleteUpload($result['upload_id']);
			$count++;
		}
		
		// Log cleanup activity
		if ($count > 0 && defined('DIR_LOGS') && is_writable(DIR_LOGS)) {
			$log_message = date('Y-m-d H:i:s') . " - Cleaned " . $count . " uploads older than " . $days . " days\n";
			file_put_contents(DIR_LOGS . 'upload_cleanup.log', $log_message, FILE_APPEND);
		}
		
		return $count;
	}
	
	/**
	 * Get file information for an upload
	 *
	 * @param int|string $upload_id_or_code The upload ID or code
	 * @param bool $is_code Whether the first parameter is a code (true) or ID (false)
	 *
	 * @return array|null File information or null if not found
	 */
	public function getFileInfo($upload_id_or_code, bool $is_code = false): ?array {
		$file_path = $this->getFilePath($upload_id_or_code, $is_code);
		
		if (!$file_path || !is_file($file_path)) {
			return null;
		}
		
		$upload_info = $is_code ? $this->getUploadByCode($upload_id_or_code) : $this->getUpload($upload_id_or_code);
		
		if (empty($upload_info)) {
			return null;
		}
		
		$file_info = [
			'upload_id' => $upload_info['upload_id'],
			'name' => $upload_info['name'],
			'filename' => $upload_info['filename'],
			'code' => $upload_info['code'],
			'date_added' => $upload_info['date_added'],
			'size' => filesize($file_path),
			'size_formatted' => $this->formatFileSize(filesize($file_path)),
			'mime_type' => $this->getFileMimeType($file_path),
			'extension' => strtolower(pathinfo($upload_info['name'], PATHINFO_EXTENSION)),
			'is_image' => $this->isImageFile($file_path)
		];
		
		return $file_info;
	}
	
	/**
	 * Format file size to human-readable format
	 *
	 * @param int $bytes File size in bytes
	 * @return string Formatted file size
	 */
	private function formatFileSize(int $bytes): string {
		$units = ['B', 'KB', 'MB', 'GB', 'TB'];
		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);
		
		$bytes /= pow(1024, $pow);
		
		return round($bytes, 2) . ' ' . $units[$pow];
	}
	
	/**
	 * Get MIME type of a file
	 *
	 * @param string $file_path Path to the file
	 * @return string MIME type
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
		
		// Last resort: guess based on extension
		$ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
		$mime_types = [
			'jpg' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png' => 'image/png',
			'gif' => 'image/gif',
			'bmp' => 'image/bmp',
			'webp' => 'image/webp',
			'svg' => 'image/svg+xml',
			'pdf' => 'application/pdf',
			'zip' => 'application/zip',
			'doc' => 'application/msword',
			'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'xls' => 'application/vnd.ms-excel',
			'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
			'ppt' => 'application/vnd.ms-powerpoint',
			'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
			'txt' => 'text/plain',
			'csv' => 'text/csv',
			'html' => 'text/html',
			'htm' => 'text/html',
			'xml' => 'application/xml',
			'json' => 'application/json'
		];
		
		return $mime_types[$ext] ?? 'application/octet-stream';
	}
	
	/**
	 * Check if a file is an image
	 *
	 * @param string $file_path Path to the file
	 * @return bool True if file is an image, false otherwise
	 */
	private function isImageFile(string $file_path): bool {
		// Check if file exists
		if (!is_file($file_path)) {
			return false;
		}
		
		// Check extension first (faster)
		$ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
		$image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'];
		
		if (!in_array($ext, $image_extensions)) {
			return false;
		}
		
		// Check MIME type
		$mime = $this->getFileMimeType($file_path);
		return strpos($mime, 'image/') === 0;
	}
}