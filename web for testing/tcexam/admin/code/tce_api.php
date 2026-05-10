<?php
//============================================================+
// File name   : tce_api.php
// Begin       : 2026-05-10
// Description : REST API handler for admin operations
// Author: Claude Code
//============================================================+

require_once('../config/tce_config.php');
require_once('../../shared/code/tce_functions_auth_sql.php');
require_once('../../shared/code/tce_functions_form.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Global variables for authenticated user
$authenticated_user_id = null;
$authenticated_user_level = null;

$response = array('status' => 'error', 'message' => 'Invalid request');

try {
    $request_method = $_SERVER['REQUEST_METHOD'];
    $route = isset($_REQUEST['route']) ? $_REQUEST['route'] : '';

    if (empty($route)) {
        http_response_code(400);
        $response['message'] = 'No route specified';
        echo json_encode($response);
        exit;
    }

    // Route dispatcher - auth.login doesn't require authentication
    if ($route !== 'api/auth.login') {
        F_validateBearerToken();
    }

    // Route dispatcher
    switch ($route) {
        case 'api/auth.login':
            if ($request_method === 'POST') {
                handleLogin();
                exit;
            } else {
                http_response_code(405);
                $response['message'] = 'Method not allowed';
            }
            break;
        case 'api/user.add':
            if ($request_method === 'POST') {
                handleAddUser();
                exit;
            } else {
                http_response_code(405);
                $response['message'] = 'Method not allowed';
            }
            break;

        case 'api/user.edit':
            if ($request_method === 'POST') {
                handleEditUser();
                exit;
            } else {
                http_response_code(405);
                $response['message'] = 'Method not allowed';
            }
            break;

        case 'api/user.list':
            if ($request_method === 'GET') {
                handleListUsers();
                exit;
            } else {
                http_response_code(405);
                $response['message'] = 'Method not allowed';
            }
            break;

        case 'api/user.get':
            if ($request_method === 'GET') {
                handleGetUser();
                exit;
            } else {
                http_response_code(405);
                $response['message'] = 'Method not allowed';
            }
            break;

        case 'api/user.delete':
            if ($request_method === 'POST') {
                handleDeleteUser();
                exit;
            } else {
                http_response_code(405);
                $response['message'] = 'Method not allowed';
            }
            break;

        default:
            http_response_code(404);
            $response['message'] = 'Route not found: ' . htmlspecialchars($route);
    }

} catch (Exception $e) {
    http_response_code(500);
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

echo json_encode($response);

// ============================================================
// AUTHENTICATION HELPERS
// ============================================================

function F_generateToken($user_id, $user_level) {
    $secret = defined('K_API_SECRET') ? K_API_SECRET : 'tce_api_secret_key';
    $payload = base64_encode(json_encode(array(
        'user_id' => intval($user_id),
        'user_level' => intval($user_level),
        'issued_at' => time()
    )));
    $signature = hash_hmac('sha256', $payload, $secret);
    return $payload . '.' . $signature;
}

function F_validateBearerToken() {
    global $authenticated_user_id, $authenticated_user_level, $response;

    // Get Authorization header from $_SERVER (set by Apache SetEnvIf directive)
    $auth_header = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : '';

    if (empty($auth_header) || strpos($auth_header, 'Bearer ') !== 0) {
        http_response_code(401);
        $response['message'] = 'Missing or invalid Authorization header. Use: Authorization: Bearer <token>';
        echo json_encode($response);
        exit;
    }

    $token = substr($auth_header, 7);
    if (strpos($token, '.') === false) {
        http_response_code(401);
        $response['message'] = 'Invalid token format';
        echo json_encode($response);
        exit;
    }

    list($payload, $signature) = explode('.', $token, 2);

    $secret = defined('K_API_SECRET') ? K_API_SECRET : 'tce_api_secret_key';
    $expected_signature = hash_hmac('sha256', $payload, $secret);

    if (!hash_equals($signature, $expected_signature)) {
        http_response_code(401);
        $response['message'] = 'Invalid token signature';
        echo json_encode($response);
        exit;
    }

    $data = json_decode(base64_decode($payload), true);
    if (!isset($data['user_id']) || !isset($data['user_level'])) {
        http_response_code(401);
        $response['message'] = 'Invalid token payload';
        echo json_encode($response);
        exit;
    }

    $authenticated_user_id = intval($data['user_id']);
    $authenticated_user_level = intval($data['user_level']);
}

// ============================================================
// HANDLERS
// ============================================================

function handleLogin() {
    global $db, $l, $authenticated_user_id, $authenticated_user_level, $response;

    if (empty($_POST['user_name']) || empty($_POST['password'])) {
        http_response_code(400);
        $response['message'] = 'Missing user_name or password';
        echo json_encode($response);
        exit;
    }

    $user_name = F_escape_sql($db, $_POST['user_name']);
    $password = $_POST['password'];

    $sql = "SELECT user_id, user_password, user_level FROM ".K_TABLE_USERS." WHERE user_name='".$user_name."'";
    if ($r = F_db_query($sql, $db)) {
        if ($row = F_db_fetch_array($r)) {
            if (password_verify($password, $row['user_password'])) {
                $token = F_generateToken($row['user_id'], $row['user_level']);
                http_response_code(200);
                $response['status'] = 'success';
                $response['message'] = 'Login successful';
                $response['token'] = $token;
                $response['user_id'] = intval($row['user_id']);
                $response['user_level'] = intval($row['user_level']);
            } else {
                http_response_code(401);
                $response['message'] = 'Invalid password';
            }
        } else {
            http_response_code(401);
            $response['message'] = 'User not found';
        }
    } else {
        http_response_code(500);
        $response['message'] = 'Database error: ' . F_db_error($db);
    }

    echo json_encode($response);
}

function handleAddUser() {
    global $db, $l, $authenticated_user_level;

    $response = array('status' => 'error', 'message' => 'Failed to add user');

    // Permission check: only admin (level 10) can add users
    if ($authenticated_user_level < 10) {
        http_response_code(403);
        $response['message'] = 'Permission denied: only administrators can add users';
        echo json_encode($response);
        exit;
    }

    // Validate required fields
    $required_fields = array('user_name', 'password', 'firstname', 'lastname', 'email');
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            http_response_code(400);
            $response['message'] = 'Missing required field: ' . $field;
            echo json_encode($response);
            exit;
        }
    }

    $user_name = F_escape_sql($db, $_POST['user_name']);
    $password = F_escape_sql($db, $_POST['password']);
    $firstname = F_escape_sql($db, $_POST['firstname']);
    $lastname = F_escape_sql($db, $_POST['lastname']);
    $email = F_escape_sql($db, $_POST['email']);
    $user_level = isset($_POST['user_level']) ? intval($_POST['user_level']) : 1;

    // Check if user already exists
    $check_sql = "SELECT user_id FROM ".K_TABLE_USERS." WHERE user_name='".$user_name."'";
    if ($r = F_db_query($check_sql, $db)) {
        if (F_db_num_rows($r) > 0) {
            http_response_code(409);
            $response['message'] = 'User already exists';
            echo json_encode($response);
            exit;
        }
    }

    // Hash password
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $password_hash_escaped = F_escape_sql($db, $password_hash);

    // Insert user
    $sql = "INSERT INTO ".K_TABLE_USERS." (user_name, user_password, user_firstname, user_lastname, user_email, user_level)
            VALUES ('".$user_name."', '".$password_hash_escaped."', '".$firstname."', '".$lastname."', '".$email."', ".$user_level.")";

    if ($result = F_db_query($sql, $db)) {
        $user_id = F_db_insert_id($db);
        http_response_code(201);
        $response['status'] = 'success';
        $response['message'] = 'User added successfully';
        $response['user_id'] = $user_id;
    } else {
        http_response_code(500);
        $response['message'] = 'Database error: ' . F_db_error($db);
    }

    echo json_encode($response);
}

function handleEditUser() {
    global $db, $l, $authenticated_user_id, $authenticated_user_level;

    $response = array('status' => 'error', 'message' => 'Failed to edit user');

    if (empty($_POST['user_id'])) {
        http_response_code(400);
        $response['message'] = 'Missing user_id';
        echo json_encode($response);
        exit;
    }

    $user_id = intval($_POST['user_id']);

    // Check if user exists
    $check_sql = "SELECT user_id FROM ".K_TABLE_USERS." WHERE user_id=".$user_id;
    if ($r = F_db_query($check_sql, $db)) {
        if (F_db_num_rows($r) == 0) {
            http_response_code(404);
            $response['message'] = 'User not found';
            echo json_encode($response);
            exit;
        }
    }

    // Permission check: only admin (level 10) can edit any user, others can only edit themselves
    if ($authenticated_user_level < 10) {
        // Non-admin users can only edit themselves
        if ($authenticated_user_id != $user_id) {
            http_response_code(403);
            $response['message'] = 'Permission denied: you can only edit your own user';
            echo json_encode($response);
            exit;
        }
        // Non-admin users cannot change their user_level
        if (isset($_POST['user_level'])) {
            unset($_POST['user_level']);
        }
    }

    // Build update query - map POST fields to DB columns
    $updates = array();
    $field_mapping = array(
        'user_name' => 'user_name',
        'firstname' => 'user_firstname',
        'lastname' => 'user_lastname',
        'email' => 'user_email',
        'user_level' => 'user_level'
    );

    foreach ($field_mapping as $post_field => $db_field) {
        if (isset($_POST[$post_field]) && $_POST[$post_field] !== '') {
            $value = F_escape_sql($db, $_POST[$post_field]);
            if (in_array($db_field, array('user_level'))) {
                $updates[] = $db_field . '=' . intval($value);
            } else {
                $updates[] = $db_field . "='" . $value . "'";
            }
        }
    }

    // Handle password separately
    if (!empty($_POST['password'])) {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $password_hash_escaped = F_escape_sql($db, $password_hash);
        $updates[] = "user_password='" . $password_hash_escaped . "'";
    }

    if (empty($updates)) {
        http_response_code(400);
        $response['message'] = 'No fields to update';
        echo json_encode($response);
        exit;
    }

    $sql = "UPDATE ".K_TABLE_USERS." SET " . implode(', ', $updates) . " WHERE user_id=" . $user_id;

    if ($result = F_db_query($sql, $db)) {
        http_response_code(200);
        $response['status'] = 'success';
        $response['message'] = 'User updated successfully';
        $response['user_id'] = $user_id;
    } else {
        http_response_code(500);
        $response['message'] = 'Database error: ' . F_db_error($db);
    }

    echo json_encode($response);
}

function handleListUsers() {
    global $db;

    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    $sql = "SELECT user_id, user_name, user_firstname, user_lastname, user_email, user_level FROM ".K_TABLE_USERS." LIMIT ".$offset.", ".$limit;

    if ($r = F_db_query($sql, $db)) {
        $users = array();
        while ($row = F_db_fetch_array($r)) {
            $users[] = array(
                'user_id' => $row['user_id'],
                'user_name' => $row['user_name'],
                'firstname' => $row['user_firstname'],
                'lastname' => $row['user_lastname'],
                'email' => $row['user_email'],
                'user_level' => $row['user_level']
            );
        }

        http_response_code(200);
        echo json_encode(array(
            'status' => 'success',
            'page' => $page,
            'limit' => $limit,
            'users' => $users
        ));
    } else {
        http_response_code(500);
        echo json_encode(array('status' => 'error', 'message' => 'Database error'));
    }
}

function handleGetUser() {
    global $db;

    if (empty($_GET['user_id'])) {
        http_response_code(400);
        echo json_encode(array('status' => 'error', 'message' => 'Missing user_id'));
        exit;
    }

    $user_id = intval($_GET['user_id']);
    $sql = "SELECT user_id, user_name, user_firstname, user_lastname, user_email, user_level FROM ".K_TABLE_USERS." WHERE user_id=".$user_id;

    if ($r = F_db_query($sql, $db)) {
        if ($row = F_db_fetch_array($r)) {
            http_response_code(200);
            echo json_encode(array(
                'status' => 'success',
                'user' => array(
                    'user_id' => $row['user_id'],
                    'user_name' => $row['user_name'],
                    'firstname' => $row['user_firstname'],
                    'lastname' => $row['user_lastname'],
                    'email' => $row['user_email'],
                    'user_level' => $row['user_level']
                )
            ));
        } else {
            http_response_code(404);
            echo json_encode(array('status' => 'error', 'message' => 'User not found'));
        }
    } else {
        http_response_code(500);
        echo json_encode(array('status' => 'error', 'message' => 'Database error'));
    }
}

function handleDeleteUser() {
    global $db, $authenticated_user_level;

    if (empty($_POST['user_id'])) {
        http_response_code(400);
        echo json_encode(array('status' => 'error', 'message' => 'Missing user_id'));
        exit;
    }

    $user_id = intval($_POST['user_id']);

    // Permission check: only admin (level 10) can delete users
    if ($authenticated_user_level < 10) {
        http_response_code(403);
        echo json_encode(array('status' => 'error', 'message' => 'Permission denied: only administrators can delete users'));
        exit;
    }

    // Check if user exists
    $check_sql = "SELECT user_id FROM ".K_TABLE_USERS." WHERE user_id=".$user_id;
    if ($r = F_db_query($check_sql, $db)) {
        if (F_db_num_rows($r) == 0) {
            http_response_code(404);
            echo json_encode(array('status' => 'error', 'message' => 'User not found'));
            exit;
        }
    }

    $sql = "DELETE FROM ".K_TABLE_USERS." WHERE user_id=".$user_id;

    if ($result = F_db_query($sql, $db)) {
        http_response_code(200);
        echo json_encode(array(
            'status' => 'success',
            'message' => 'User deleted successfully',
            'user_id' => $user_id
        ));
    } else {
        http_response_code(500);
        echo json_encode(array('status' => 'error', 'message' => 'Database error'));
    }
}

//============================================================+
// END OF FILE
//============================================================+
