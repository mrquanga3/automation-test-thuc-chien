<?php
// Lightweight file-based IP rate limiter (no DB, no extension required).
// Usage: rate_limit_check('web', 300, 60);

function rate_limit_check($bucket, $max, $window, $whitelist = ['127.0.0.1', '::1']) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    if (in_array($ip, $whitelist, true)) {
        return;
    }

    $dir = (defined('DIR_CACHE') ? DIR_CACHE : sys_get_temp_dir() . '/') . 'ratelimit/';
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }

    $file = $dir . $bucket . '_' . md5($ip) . '.json';
    $now  = time();

    $fp = @fopen($file, 'c+');
    if (!$fp) {
        return;
    }
    flock($fp, LOCK_EX);
    $raw  = stream_get_contents($fp);
    $hits = $raw ? json_decode($raw, true) : [];
    if (!is_array($hits)) {
        $hits = [];
    }
    $hits = array_values(array_filter($hits, function ($t) use ($now, $window) {
        return $t > $now - $window;
    }));

    if (count($hits) >= $max) {
        flock($fp, LOCK_UN);
        fclose($fp);
        $retry = $window;
        header('Content-Type: application/json; charset=utf-8', true, 429);
        header('Retry-After: ' . $retry);
        exit(json_encode([
            'error'       => 'Too Many Requests',
            'ip'          => $ip,
            'retry_after' => $retry,
        ]));
    }

    $hits[] = $now;
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($hits));
    flock($fp, LOCK_UN);
    fclose($fp);
}
