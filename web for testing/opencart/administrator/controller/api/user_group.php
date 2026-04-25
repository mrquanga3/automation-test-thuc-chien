<?php
namespace Opencart\Admin\Controller\Api;

class UserGroup extends \Opencart\System\Engine\Controller {
	private function validate(): string {
		if (!$this->registry->has('user')) {
			$this->registry->set('user', new \Opencart\System\Library\Cart\User($this->registry));
		}
		if (!$this->user->isLogged()) { return 'Unauthorized.'; }
		$bearer_token = $this->getBearerToken();
		if (!$bearer_token || !isset($this->session->data['user_token']) || $bearer_token !== $this->session->data['user_token']) {
			return 'Invalid token.';
		}
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
		if (!$this->user->hasPermission('access', 'user/user_group')) { $this->sendJson(['error' => 'Permission denied.'], 403); return; }

		$this->load->model('user/user_group');
		$results = $this->model_user_user_group->getUserGroups();
		$this->sendJson(['success' => true, 'user_groups' => $results]);
	}

	public function add(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('modify', 'user/user_group')) { $this->sendJson(['error' => 'Permission denied.'], 403); return; }

		$this->load->model('user/user_group');
		$user_group_id = $this->model_user_user_group->addUserGroup($this->request->post);
		$this->sendJson(['success' => true, 'user_group_id' => $user_group_id]);
	}

	public function edit(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('modify', 'user/user_group')) { $this->sendJson(['error' => 'Permission denied.'], 403); return; }

		$user_group_id = isset($this->request->get['user_group_id']) ? (int)$this->request->get['user_group_id'] : 0;
		if (!$user_group_id) { $this->sendJson(['error' => 'Missing user_group_id.'], 400); return; }

		$this->load->model('user/user_group');
		$this->model_user_user_group->editUserGroup($user_group_id, $this->request->post);
		$this->sendJson(['success' => true]);
	}

	public function delete(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('modify', 'user/user_group')) { $this->sendJson(['error' => 'Permission denied.'], 403); return; }

		$user_group_id = isset($this->request->get['user_group_id']) ? (int)$this->request->get['user_group_id'] : 0;
		if (!$user_group_id) { $this->sendJson(['error' => 'Missing user_group_id.'], 400); return; }

		$this->load->model('user/user_group');
		$this->model_user_user_group->deleteUserGroup($user_group_id);
		$this->sendJson(['success' => true]);
	}

	public function get(): void {
		$error = $this->validate();
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('access', 'user/user_group')) { $this->sendJson(['error' => 'Permission denied.'], 403); return; }

		$user_group_id = isset($this->request->get['user_group_id']) ? (int)$this->request->get['user_group_id'] : 0;
		if (!$user_group_id) { $this->sendJson(['error' => 'Missing user_group_id.'], 400); return; }

		$this->load->model('user/user_group');
		$user_group = $this->model_user_user_group->getUserGroup($user_group_id);

		if (!$user_group) { $this->sendJson(['error' => 'User group not found.'], 404); return; }

		$this->sendJson(['success' => true, 'user_group' => $user_group]);
	}
}
