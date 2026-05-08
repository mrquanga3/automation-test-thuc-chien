<?php
namespace Opencart\Admin\Controller\Api;
/**
 * Class Login (API)
 *
 * API endpoint để xác thực admin và trả về user_token.
 *
 * Cách dùng:
 *   POST index.php?route=api/login
 *   Body (form-data hoặc x-www-form-urlencoded):
 *     username = <tên đăng nhập>
 *     password = <mật khẩu>
 *
 * Response thành công:
 *   Header: X-User-Token: <token>
 *   Body: { "success": true, "user_token": "...", "user_id": 1, "username": "admin" }
 *
 * Response lỗi:
 *   { "error": "Thông báo lỗi" }
 *
 * @package Opencart\Admin\Controller\Api
 */
class Login extends \Opencart\System\Engine\Controller {
	/**
	 * POST index.php?route=api/login
	 *
	 * @return void
	 */
	public function index(): void {
		$json = [];

		$this->load->language('common/login');

		// Chỉ cho phép POST
		if ($this->request->server['REQUEST_METHOD'] !== 'POST') {
			$this->response->addHeader('HTTP/1.1 405 Method Not Allowed');
			$json['error'] = 'Method not allowed. Use POST.';
			$this->sendJson($json);
			return;
		}

		$username = isset($this->request->post['username']) ? trim((string)$this->request->post['username']) : '';
		$password = isset($this->request->post['password']) ? (string)$this->request->post['password'] : '';

		if (!$username || !$password) {
			$this->response->addHeader('HTTP/1.1 400 Bad Request');
			$json['error'] = $this->language->get('error_required');
			$this->sendJson($json);
			return;
		}

		// Khởi tạo User library (nếu chưa có)
		if (!$this->registry->has('user')) {
			$this->registry->set('user', new \Opencart\System\Library\Cart\User($this->registry));
		}

		// Thực hiện đăng nhập qua User library
		if (!$this->user->login($username, html_entity_decode($password, ENT_QUOTES, 'UTF-8'))) {
			$this->response->addHeader('HTTP/1.1 401 Unauthorized');
			$json['error'] = $this->language->get('error_login');
			$this->sendJson($json);
			return;
		}

		// Tạo user_token và lưu vào session
		$this->session->data['user_token'] = oc_token(32);

		// Ghi lịch sử đăng nhập
		$login_data = [
			'ip'         => $this->request->server['REMOTE_ADDR'],
			'user_agent' => isset($this->request->server['HTTP_USER_AGENT']) ? $this->request->server['HTTP_USER_AGENT'] : 'API Client'
		];

		$this->load->model('user/user');
		$this->model_user_user->addLogin($this->user->getId(), $login_data);

		$json['success']    = true;
		$json['user_token'] = $this->session->data['user_token'];
		$json['user_id']    = $this->user->getId();
		$json['username']   = $this->user->getUserName();

		// Trả token về cả trong header để client tiện lưu
		$this->response->addHeader('X-User-Token: ' . $this->session->data['user_token']);

		$this->sendJson($json);
	}

	/**
	 * Gửi JSON response
	 *
	 * @param array $data
	 *
	 * @return void
	 */
	private function sendJson(array $data): void {
		$this->response->addHeader('Content-Type: application/json; charset=UTF-8');
		$this->response->setOutput(json_encode($data, JSON_UNESCAPED_UNICODE));
	}
}
