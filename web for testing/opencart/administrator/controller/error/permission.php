<?php
namespace Opencart\Admin\Controller\Error;
/**
 * Class Permission
 *
 * @package Opencart\Admin\Controller\Error
 */
class Permission extends \Opencart\System\Engine\Controller {
	/**
	 * @return void
	 */
	public function index(): void {
		$this->load->language('error/permission');

		$route = isset($this->request->get['route']) ? (string)$this->request->get['route'] : '';

		if (strpos($route, 'api/') === 0) {
			$this->response->addHeader('HTTP/1.1 403 Forbidden');
			$this->response->addHeader('Content-Type: application/json; charset=UTF-8');
			$this->response->setOutput(json_encode([
				'error' => $this->language->get('error_permission')
			], JSON_UNESCAPED_UNICODE));
			return;
		}

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->request->get['route'], 'user_token=' . $this->session->data['user_token'])
		];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('error/permission', $data));
	}
}
