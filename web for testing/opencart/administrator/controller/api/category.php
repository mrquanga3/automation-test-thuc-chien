<?php
namespace Opencart\Admin\Controller\Api;

class Category extends \Opencart\System\Engine\Controller {
	private function validate(): string {
		if (!$this->registry->has('user')) { $this->registry->set('user', new \Opencart\System\Library\Cart\User($this->registry)); }
		if (!$this->user->isLogged()) { return 'Unauthorized.'; }
		$bearer_token = $this->getBearerToken();
		if (!$bearer_token || !isset($this->session->data['user_token']) || $bearer_token !== $this->session->data['user_token']) { return 'Invalid token.'; }
		return '';
	}

	private function getBearerToken(): string {
		$auth_header = '';
		if (isset($this->request->server['HTTP_AUTHORIZATION'])) { $auth_header = (string)$this->request->server['HTTP_AUTHORIZATION']; }
		elseif (isset($this->request->server['REDIRECT_HTTP_AUTHORIZATION'])) { $auth_header = (string)$this->request->server['REDIRECT_HTTP_AUTHORIZATION']; }
		elseif (function_exists('getallheaders')) {
			$headers = getallheaders();
			if (isset($headers['Authorization'])) { $auth_header = (string)$headers['Authorization']; }
			elseif (isset($headers['authorization'])) { $auth_header = (string)$headers['authorization']; }
		}
		if ($auth_header && strpos($auth_header, 'Bearer ') === 0) { return trim(substr($auth_header, 7)); }
		if (isset($this->request->server['HTTP_X_USER_TOKEN'])) { return trim((string)$this->request->server['HTTP_X_USER_TOKEN']); }
		return '';
	}

	private function sendJson(array $data, int $code = 200): void {
		if ($code !== 200) { $this->response->addHeader('HTTP/1.1 ' . $code); }
		$this->response->addHeader('Content-Type: application/json; charset=UTF-8');
		$this->response->setOutput(json_encode($data, JSON_UNESCAPED_UNICODE));
	}

	public function index(): void {
		$error = $this->validate();
		$this->load->language('catalog/category');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('access', 'catalog/category')) { $this->sendJson(['error' => $this->language->get('error_permission')], 403); return; }

		$this->load->model('catalog/category');
		$results = $this->model_catalog_category->getCategories();
		$this->sendJson(['success' => true, 'categories' => $results]);
	}

	public function add(): void {
		$error = $this->validate();
		$this->load->language('catalog/category');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('modify', 'catalog/category')) { $this->sendJson(['error' => $this->language->get('error_permission')], 403); return; }

		$this->load->model('catalog/category');
		$category_id = $this->model_catalog_category->addCategory($this->request->post);
		$this->sendJson(['success' => true, 'category_id' => $category_id]);
	}

	public function edit(): void {
		$error = $this->validate();
		$this->load->language('catalog/category');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('modify', 'catalog/category')) { $this->sendJson(['error' => $this->language->get('error_permission')], 403); return; }

		$category_id = isset($this->request->get['category_id']) ? (int)$this->request->get['category_id'] : 0;
		if (!$category_id) { $this->sendJson(['error' => $this->language->get('error_category_id')], 400); return; }

		$this->load->model('catalog/category');
		$category_info = $this->model_catalog_category->getCategory($category_id);
		if (!$category_info) { $this->sendJson(['error' => $this->language->get('error_not_found')], 404); return; }

		$this->model_catalog_category->editCategory($category_id, $this->request->post);
		$this->sendJson(['success' => true]);
	}

	public function delete(): void {
		$error = $this->validate();
		$this->load->language('catalog/category');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }

		// [DISABLED] Tính năng xóa đã bị vô hiệu hóa
		$this->sendJson(['error' => $this->language->get('error_delete_disabled')], 403);
	}

	public function get(): void {
		$error = $this->validate();
		$this->load->language('catalog/category');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('access', 'catalog/category')) { $this->sendJson(['error' => $this->language->get('error_permission')], 403); return; }

		$category_id = isset($this->request->get['category_id']) ? (int)$this->request->get['category_id'] : 0;
		if (!$category_id) { $this->sendJson(['error' => $this->language->get('error_category_id')], 400); return; }

		$this->load->model('catalog/category');
		$category = $this->model_catalog_category->getCategory($category_id);

		if (!$category) { $this->sendJson(['error' => $this->language->get('error_not_found')], 404); return; }

		$this->sendJson(['success' => true, 'category' => $category]);
	}
}
