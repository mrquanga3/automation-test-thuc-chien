<?php
// Version
define('VERSION', '4.0.2.3');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

// Install
if (!defined('DIR_APPLICATION')) {
	header('Location: install/index.php');
	exit();
}

// Rate limit (per-IP, file-based)
require_once(DIR_SYSTEM . 'library/rate_limit.php');
rate_limit_check('web', 300, 60);

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Framework
require_once(DIR_SYSTEM . 'framework.php');
