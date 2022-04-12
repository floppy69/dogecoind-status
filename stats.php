<?php
/**
 * Bitcoin Status Page - Stats
 *
 * @category File
 * @package  DogecoinStatus
 * @author   Craig Watson <craig@cwatson.org>
 * @Forked   By   Floppy69 <a.maaded@gmail.com>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/floppy69/dogecoind-status
 */

require_once './php/config.php';

// Die if we're not in the whitelist
if (php_sapi_name() != 'cli') {
    if (!in_array($_SERVER['REMOTE_ADDR'], $config['stats_whitelist'])) {
        die("you're not not in the whitelist");
    }
}

// Clear data if variable present
if (isset($_GET['clear']) & is_file($config['stats_file'])) {
    unlink($config['stats_file']);
}

// Check for existing data
if (is_file($config['stats_file'])) {
    $data = json_decode(file_get_contents($config['stats_file']), true);
} else {
    $data = array();
}

// If viewing is enabled, just output and die
if (isset($_GET['view'])) {
    print_r($data);
    die();
}

// Include EasyBitcoin library and set up connection
require_once './php/easybitcoin.php';
$dogecoin = new Dogecoin($config['rpc_user'], $config['rpc_pass'], $config['rpc_host'], $config['rpc_port']);

// Setup SSL if configured
if ($config['rpc_ssl'] === true) {
    $dogecoin->setSSL($config['rpc_ssl_ca']);
}

// Get info and handle errors
$new_raw_data = $dogecoin->getnetworkinfo();
if (!$new_raw_data) {
    die("RPC Error");
}

// Append to array
$data[] = array('time' => time(), 'connections' => $new_raw_data['connections']);

// Purge old data
for ($i = 0; $i < count($data); $i++) {
    if ($data[$i]['time'] < (time() - $config['stats_max_age'])) {
        array_splice($data, $i, 1);
    }
}

// Save array
if (file_put_contents($config['stats_file'], json_encode($data), LOCK_EX) === false) {
    die("Failure storing data");
}
