<?php
namespace Opencart\Admin\Controller\Api;

class User extends \Opencart\System\Engine\Controller {
	private function validate(): string {
		if (!$this->registry->has('user')) {
			$this->registry->set('user', new \Opencart\System\Library\Cart\User($this->registry));
		}

		if (!$this->user->isLogged()) {
			return 'Unauthorized. Please login via api/login first.';
		}

		$bearer_token = $this->getBearerToken();
		if (!$bearer_token || !isset($this->session->data['user_token']) || $bearer_token !== $this->session->data['user_token']) {
			return 'Invalid or missing token.';
		}

		return '';
	}

	private function getBearerToken(): string {
		$auth_header = '';
		if (isset($this->request->server['HTTP_AUTHORIZATION'])) {
			$auth_header = (string)$this->request->server['HTTP_AUTHORIZATION'];
		} elseif (isset($this->request->server['REDIRECT_HTTP_AUTHORIZATION'])) {
			$auth_header = (string)$this->request->server['REDIRECT_HTTP_AUTHORIZATION'];
		} elseif (function_exists('getallheaders')) {
			$headers = getallheaders();
			if (isset($headers['Authorization'])) { $auth_header = (string)$headers['Authorization']; }
			elseif (isset($headers['authorization'])) { $auth_header = (string)$headers['authorization']; }
		}
		if ($auth_header && strpos($auth_header, 'Bearer ') === 0) { return trim(substr($auth_header, 7)); }
		if (isset($this->request->server['HTTP_X_USER_TOKEN'])) { return trim((string)$this->request->server['HTTP_X_USER_TOKEN']); }
		return '';
	}

	private function sendJson(array $data, int $code = 200): void {
		if ($code !== 200) {
			$status_texts = [400 => 'Bad Request', 401 => 'Unauthorized', 403 => 'Forbidden', 405 => 'Method Not Allowed'];
			$text = isset($status_texts[$code]) ? $status_texts[$code] : 'Error';
			$this->response->addHeader('HTTP/1.1 ' . $code . ' ' . $text);
		}
		$this->response->addHeader('Content-Type: application/json; charset=UTF-8');
		$this->response->setOutput(json_encode($data, JSON_UNESCAPED_UNICODE));
	}

	public function index(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }

		if (!$this->user->hasPermission('access', 'user/user')) {
			$this->sendJson(['error' => $this->language->get('error_permission')], 403); return;
		}

		$page  = isset($this->request->get['page'])  ? max(1, (int)$this->request->get['page']) : 1;
		$limit = isset($this->request->get['limit']) ? min(100, max(1, (int)$this->request->get['limit'])) : 20;
		$sort  = isset($this->request->get['sort'])  ? (string)$this->request->get['sort'] : 'username';
		$order = isset($this->request->get['order']) ? strtoupper((string)$this->request->get['order']) : 'ASC';

		$this->load->model('user/user');
		$total   = $this->model_user_user->getTotalUsers();
		$results = $this->model_user_user->getUsers(['sort' => $sort, 'order' => $order, 'start' => ($page - 1) * $limit, 'limit' => $limit]);

		$users = [];
		foreach ($results as $result) {
			$users[] = [
				'user_id'    => (int)$result['user_id'],
				'username'   => $result['username'],
				'firstname'  => $result['firstname'],
				'lastname'   => $result['lastname'],
				'email'      => $result['email'],
				'status'     => (int)$result['status'],
				'date_added' => $result['date_added']
			];
		}

		$this->sendJson(['success' => true, 'total' => (int)$total, 'users' => $users]);
	}

	public function add(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }

		if (!$this->user->hasPermission('modify', 'user/user')) {
			$this->sendJson(['error' => $this->language->get('error_permission')], 403); return;
		}

		if ($this->request->server['REQUEST_METHOD'] !== 'POST') {
			$this->sendJson(['error' => 'POST method required.'], 405); return;
		}

		$this->load->model('user/user');
		$user_id = $this->model_user_user->addUser($this->request->post);
		$this->sendJson(['success' => true, 'user_id' => $user_id]);
	}

	public function edit(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }

		$this->load->language('user/user');

		if (!$this->user->hasPermission('modify', 'user/user')) {
			$this->sendJson(['error' => $this->language->get('error_permission')], 403); return;
		}

		$user_id = isset($this->request->get['user_id']) ? (int)$this->request->get['user_id'] : 0;
		if (!$user_id) { $this->sendJson(['error' => $this->language->get('error_user_id')], 400); return; }

		$this->load->model('user/user');

		$user_info = $this->model_user_user->getUser($user_id);
		if (!$user_info) {
			$this->sendJson(['error' => $this->language->get('error_not_found')], 404); return;
		}

		$this->model_user_user->editUser($user_id, $this->request->post);
		$this->sendJson(['success' => true]);
	}

	public function delete(): void {
		$error = $this->validate();
		$this->load->language('user/user');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }

		// [DISABLED] Tính năng xóa đã bị vô hiệu hóa
		$this->sendJson(['error' => $this->language->get('error_delete_disabled')], 403);
	}

	public function get(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }

		$this->load->language('user/user');

		if (!$this->user->hasPermission('access', 'user/user')) {
			$this->sendJson(['error' => $this->language->get('error_permission')], 403); return;
		}

		$user_id = isset($this->request->get['user_id']) ? (int)$this->request->get['user_id'] : 0;
		if (!$user_id) { $this->sendJson(['error' => $this->language->get('error_user_id')], 400); return; }

		$this->load->model('user/user');
		$user = $this->model_user_user->getUser($user_id);

		if (empty($user)) { $this->sendJson(['error' => $this->language->get('error_not_found')], 404); return; }

		unset($user['password'], $user['salt']);
		$this->sendJson(['success' => true, 'user' => $user]);
	}
}
