<?php
namespace Reamur\Install\Controller\Install\Extensions;

use Reamur\System\Engine\Controller;
use RuntimeException;
use Throwable;

/**
 * Instala as tabelas e configurações iniciais da extensão de Blog.
 *
 * Rota: install/extensions/blog_installer
 * Método recomendado: POST (recebe credenciais de banco) ou usa config.php se presente.
 */
class BlogInstaller extends Controller {
	/**
	 * Executa a instalação da extensão.
	 *
	 * @return void
	 */
	public function index(): void {
		$this->response->addHeader('Content-Type: application/json');

		try {
			$dbData = $this->getDbCredentials();

			// Carrega o model responsável por aplicar o bundle SQL
			$this->load->model('extensions/blog_install');

			$executed = $this->model_extensions_blog_install->install($dbData);

			$this->respond([
				'success'  => true,
				'executed' => $executed,
				'message'  => 'Extensão de blog instalada com sucesso.'
			]);
		} catch (Throwable $e) {
			$this->respond([
				'success' => false,
				'error'   => $e->getMessage()
			], 500);
		}
	}

	/**
	 * Extrai credenciais de banco do POST ou do arquivo config.php.
	 *
	 * @return array
	 */
	private function getDbCredentials(): array {
		$configValues = $this->parseConfigFile(DIR_REAMUR . 'config.php');

		$fetch = function (string $key, ?string $default = null) use ($configValues) {
			return $this->request->post[$key] ?? $configValues[$key] ?? $default;
		};

		$credentials = [
			'db_driver'   => $fetch('db_driver'),
			'db_hostname' => $fetch('db_hostname'),
			'db_username' => $fetch('db_username'),
			'db_password' => $fetch('db_password', ''),
			'db_database' => $fetch('db_database'),
			'db_port'     => (string)($fetch('db_port', '3306') ?: '3306'),
			'db_prefix'   => $fetch('db_prefix', 'rms_')
		];

		foreach (['db_driver', 'db_hostname', 'db_username', 'db_database'] as $required) {
			if ($credentials[$required] === null || $credentials[$required] === '') {
				throw new RuntimeException('Parâmetro de banco ausente: ' . $required);
			}
		}

		return $credentials;
	}

	/**
	 * Lê valores de DB_* diretamente do config.php sem redefinir constantes.
	 *
	 * @param string $path
	 * @return array
	 */
	private function parseConfigFile(string $path): array {
		if (!is_file($path)) {
			return [];
		}

		$content = file_get_contents($path);
		if ($content === false) {
			return [];
		}

		$map = [];
		$patterns = [
			'db_driver'   => 'DB_DRIVER',
			'db_hostname' => 'DB_HOSTNAME',
			'db_username' => 'DB_USERNAME',
			'db_password' => 'DB_PASSWORD',
			'db_database' => 'DB_DATABASE',
			'db_port'     => 'DB_PORT',
			'db_prefix'   => 'DB_PREFIX',
		];

		foreach ($patterns as $key => $constant) {
			if (preg_match("/define\\('\\Q{$constant}\\E',\\s*['\"]([^'\"]*)['\"]\\);/i", $content, $match)) {
				$map[$key] = stripcslashes($match[1]);
			}
		}

		return $map;
	}

	/**
	 * Envia resposta JSON padronizada.
	 *
	 * @param array $payload
	 * @param int   $status
	 * @return void
	 */
	private function respond(array $payload, int $status = 200): void {
		http_response_code($status);
		$this->response->setOutput(json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
	}
}
