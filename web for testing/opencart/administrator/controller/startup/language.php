<?php
namespace Opencart\Admin\Controller\Startup;
/**
 * Class Language
 *
 * @package Opencart\Admin\Controller\Startup
 */
class Language extends \Opencart\System\Engine\Controller {
	/**
	 * @var array
	 */
	private static array $languages = [];

	/**
	 * @return void
	 */
	public function index(): void {
		if (isset($this->request->get['language'])) {
			$code = (string)$this->request->get['language'];
		} elseif (isset($this->request->cookie['language'])) {
			$code = (string)$this->request->cookie['language'];
		} elseif (isset($this->request->server['HTTP_LANGUAGE'])) {
			$code = (string)$this->request->server['HTTP_LANGUAGE'];
		} elseif (isset($this->request->server['HTTP_X_LANGUAGE'])) {
			$code = (string)$this->request->server['HTTP_X_LANGUAGE'];
		} else {
			$code = $this->config->get('config_language_admin');
		}

		$this->load->model('localisation/language');

		self::$languages = $this->model_localisation_language->getLanguages();

		if (isset(self::$languages[$code])) {
			$language_info = self::$languages[$code];

			$this->config->set('config_language_id', $language_info['language_id']);
			$this->config->set('config_language_admin', $language_info['code']);

			// Re-initialize language object with new code so subsequent load() calls use it
			$language = new \Opencart\System\Library\Language($language_info['code']);
			$language->addPath(DIR_LANGUAGE);
			
			if ($language_info['extension']) {
				$language->addPath('extension/' . $language_info['extension'], DIR_EXTENSION . $language_info['extension'] . '/admin/language/');
			}

			$this->registry->set('language', $language);

			$this->load->language('default');
		}
	}

	// Fill the language up with default values

	/**
	 * @param $route
	 * @param $prefix
	 * @param $code
	 * @param $output
	 *
	 * @return void
	 */
	public function after(&$route, &$prefix, &$code, &$output): void {
		if (!$code) {
			$code = $this->config->get('config_language_admin');
		}

		// Use $this->language->load so it's not triggering infinite loops
		$this->language->load($route, $prefix, $code);

		if (isset(self::$languages[$code])) {
			$language_info = self::$languages[$code];

			$path = '';

			if ($language_info['extension']) {
				$extension = 'extension/' . $language_info['extension'];

				if (oc_substr($route, 0, strlen($extension)) != $extension) {
					$path = $extension . '/';
				}
			}

			// Use $this->language->load so it's not triggering infinite loops
			$this->language->load($path . $route, $prefix, $code);
		}
	}
}
