<?php
namespace Opencart\Admin\Controller\Api;

class Customer extends \Opencart\System\Engine\Controller {
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
		if ($code !== 200) {
			$status_texts = [400 => 'Bad Request', 401 => 'Unauthorized', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed'];
			$text = isset($status_texts[$code]) ? $status_texts[$code] : 'Error';
			$this->response->addHeader('HTTP/1.1 ' . $code . ' ' . $text);
		}
		$this->response->addHeader('Content-Type: application/json; charset=UTF-8');
		$this->response->setOutput(json_encode($data, JSON_UNESCAPED_UNICODE));
	}

	public function index(): void {
		$error = $this->validate();
		$this->load->language('customer/customer');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('access', 'customer/customer')) { $this->sendJson(['error' => $this->language->get('error_permission')], 403); return; }

		$page  = isset($this->request->get['page'])  ? max(1, (int)$this->request->get['page']) : 1;
		$limit = isset($this->request->get['limit']) ? min(100, max(1, (int)$this->request->get['limit'])) : 20;
		$sort  = isset($this->request->get['sort'])  ? (string)$this->request->get['sort'] : 'name';
		$order = isset($this->request->get['order']) ? strtoupper((string)$this->request->get['order']) : 'ASC';

		$filter_data = [
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $limit,
			'limit' => $limit
		];

		if (isset($this->request->get['filter_name']))             { $filter_data['filter_name']              = (string)$this->request->get['filter_name']; }
		if (isset($this->request->get['filter_email']))            { $filter_data['filter_email']             = (string)$this->request->get['filter_email']; }
		if (isset($this->request->get['filter_status']))           { $filter_data['filter_status']            = (string)$this->request->get['filter_status']; }
		if (isset($this->request->get['filter_customer_group_id'])){ $filter_data['filter_customer_group_id'] = (int)$this->request->get['filter_customer_group_id']; }

		$this->load->model('customer/customer');
		$total     = $this->model_customer_customer->getTotalCustomers($filter_data);
		$results   = $this->model_customer_customer->getCustomers($filter_data);

		$customers = [];
		foreach ($results as $result) {
			$customers[] = [
				'customer_id'    => (int)$result['customer_id'],
				'firstname'      => $result['firstname'],
				'lastname'       => $result['lastname'],
				'email'          => $result['email'],
				'telephone'      => $result['telephone'],
				'customer_group' => $result['customer_group'],
				'status'         => (int)$result['status'],
				'date_added'     => $result['date_added']
			];
		}

		$this->sendJson(['success' => true, 'total' => (int)$total, 'customers' => $customers]);
	}

	public function get(): void {
		$error = $this->validate();
		$this->load->language('customer/customer');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('access', 'customer/customer')) { $this->sendJson(['error' => $this->language->get('error_permission')], 403); return; }

		$customer_id = isset($this->request->get['customer_id']) ? (int)$this->request->get['customer_id'] : 0;
		if (!$customer_id) { $this->sendJson(['error' => $this->language->get('error_customer_id')], 400); return; }

		$this->load->model('customer/customer');
		$customer = $this->model_customer_customer->getCustomer($customer_id);

		if (!$customer) { $this->sendJson(['error' => $this->language->get('error_not_found')], 404); return; }

		unset($customer['password']);
		$this->sendJson(['success' => true, 'customer' => $customer]);
	}

	public function add(): void {
		$error = $this->validate();
		$this->load->language('customer/customer');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('modify', 'customer/customer')) { $this->sendJson(['error' => $this->language->get('error_permission')], 403); return; }

		if ($this->request->server['REQUEST_METHOD'] !== 'POST') {
			$this->sendJson(['error' => 'POST method required.'], 405); return;
		}

		$this->load->model('customer/customer');
		$customer_id = $this->model_customer_customer->addCustomer($this->request->post);
		$this->sendJson(['success' => true, 'customer_id' => $customer_id]);
	}

	public function edit(): void {
		$error = $this->validate();
		$this->load->language('customer/customer');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }
		if (!$this->user->hasPermission('modify', 'customer/customer')) { $this->sendJson(['error' => $this->language->get('error_permission')], 403); return; }

		$customer_id = isset($this->request->get['customer_id']) ? (int)$this->request->get['customer_id'] : 0;
		if (!$customer_id) { $this->sendJson(['error' => $this->language->get('error_customer_id')], 400); return; }

		$this->load->model('customer/customer');
		$customer_info = $this->model_customer_customer->getCustomer($customer_id);
		if (!$customer_info) { $this->sendJson(['error' => $this->language->get('error_not_found')], 404); return; }

		$this->model_customer_customer->editCustomer($customer_id, $this->request->post);
		$this->sendJson(['success' => true]);
	}

	public function delete(): void {
		$error = $this->validate();
		$this->load->language('customer/customer');
		if ($error) { $this->sendJson(['error' => $error], 401); return; }

		// [DISABLED] Tính năng xóa đã bị vô hiệu hóa
		$this->sendJson(['error' => $this->language->get('error_delete_disabled')], 403);
	}
}
