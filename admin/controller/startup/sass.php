<?php
namespace Reamur\Admin\Controller\Startup;
/**
 * Class Sass
 *
 * @package Reamur\Admin\Controller\Startup
 */
class Sass extends \Reamur\System\Engine\Controller {
	/**
	 * @return void
	 * @throws \ScssPhp\ScssPhp\Exception\SassException
	 */
	public function index(): void {
		$files = glob(DIR_APPLICATION . 'view/css/*.scss');

		if ($files) {
			foreach ($files as $file) {
				// Get the filename
				$filename = basename($file, '.scss');

				$stylesheet = DIR_APPLICATION . 'view/css/' . $filename . '.css';

				if (!is_file($stylesheet) || !$this->config->get('developer_sass')) {
					$scss = new \ScssPhp\ScssPhp\Compiler();
					$scss->setImportPaths(DIR_APPLICATION . 'view/css/');

					$output = $scss->compileString('@import "' . $filename . '.scss"')->getCss();

					$handle = fopen($stylesheet, 'w');

					flock($handle, LOCK_EX);

					fwrite($handle, $output);

					fflush($handle);

					flock($handle, LOCK_UN);

					fclose($handle);
				}
			}
		}
	}
}
