<?php
// Version
define('VERSION', '4.0.2.3');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Installs
if (!defined('DIR_APPLICATION')) {
	header('Location: ../install/index.php');
	exit();
}

// Rate limit (per-IP, file-based). Stricter bucket on the login route.
require_once(DIR_SYSTEM . 'library/rate_limit.php');
$is_login = isset($_GET['route']) && strpos($_GET['route'], 'common/login') !== false;
$is_api   = isset($_GET['route']) && strpos($_GET['route'], 'api/login')    !== false;
if ($is_login || $is_api) {
	rate_limit_check('login', 10, 60);
}
rate_limit_check('admin', 200, 60);

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Framework
require_once(DIR_SYSTEM . 'framework.php');
