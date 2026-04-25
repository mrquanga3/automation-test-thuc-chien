<?php
namespace Opencart\Admin\Controller\Api;

class Product extends \Opencart\System\Engine\Controller {
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
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('access', 'catalog/product')) { $this->sendJson(['error' => 'Permission denied.'], 403); return; }

		$this->load->model('catalog/product');
		$page  = isset($this->request->get['page'])  ? max(1, (int)$this->request->get['page']) : 1;
		$limit = isset($this->request->get['limit']) ? min(100, max(1, (int)$this->request->get['limit'])) : 20;

		$results = $this->model_catalog_product->getProducts(['start' => ($page - 1) * $limit, 'limit' => $limit]);
		$total   = $this->model_catalog_product->getTotalProducts();

		$this->sendJson(['success' => true, 'total' => (int)$total, 'products' => $results]);
	}

	public function add(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('modify', 'catalog/product')) { $this->sendJson(['error' => 'Permission denied.'], 403); return; }

		$this->load->model('catalog/product');
		$product_id = $this->model_catalog_product->addProduct($this->request->post);
		$this->sendJson(['success' => true, 'product_id' => $product_id]);
	}

	public function edit(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('modify', 'catalog/product')) { $this->sendJson(['error' => 'Permission denied.'], 403); return; }

		$product_id = isset($this->request->get['product_id']) ? (int)$this->request->get['product_id'] : 0;
		if (!$product_id) { $this->sendJson(['error' => 'Missing product_id.'], 400); return; }

		$this->load->model('catalog/product');
		$this->model_catalog_product->editProduct($product_id, $this->request->post);
		$this->sendJson(['success' => true]);
	}

	public function delete(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('modify', 'catalog/product')) { $this->sendJson(['error' => 'Permission denied.'], 403); return; }

		$product_id = isset($this->request->get['product_id']) ? (int)$this->request->get['product_id'] : 0;
		if (!$product_id) { $this->sendJson(['error' => 'Missing product_id.'], 400); return; }

		$this->load->model('catalog/product');
		$this->model_catalog_product->deleteProduct($product_id);
		$this->sendJson(['success' => true]);
	}

	public function get(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('access', 'catalog/product')) { $this->sendJson(['error' => 'Permission denied.'], 403); return; }

		$product_id = isset($this->request->get['product_id']) ? (int)$this->request->get['product_id'] : 0;
		if (!$product_id) { $this->sendJson(['error' => 'Missing product_id.'], 400); return; }

		$this->load->model('catalog/product');
		$product = $this->model_catalog_product->getProduct($product_id);

		if (!$product) { $this->sendJson(['error' => 'Product not found.'], 404); return; }

		$this->sendJson(['success' => true, 'product' => $product]);
	}
}
