<?php
/**
 * Dogecoin Status Page - Peer Stats
 *
 * @category File
 * @package  DogecoinStatus
 * @author   Craig Watson <craig@cwatson.org>
 * @Forked   By   Floppy69 <a.maaded@gmail.com>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/floppy69/dogecoind-status
 */
 // Get config
 require_once './php/config.php';

 // Die if we're not in the whitelist or running on CLI
if (php_sapi_name() != 'cli') {
    if (!in_array($_SERVER['REMOTE_ADDR'], $config['peercount_whitelist'])) {
        die("you're not not in the whitelist");
    }
}

// Clear data if variable present
if (isset($_GET['clear']) & is_file($config['peercount_file'])) {
    unlink($config['peercount_file']);
}

// Check for existing data
if (is_file($config['peercount_file'])) {
    $data = json_decode(file_get_contents($config['peercount_file']), true);
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

// Get data via RPC
$new_peers = $dogecoin->getpeerinfo();

// Default types
$default_types = array(
  'shibetoshi'  => 'Shibetoshi',
  'classic'  => 'Classic',
  'bitcoinj' => 'BitcoinJ',
  'core'     => 'Satoshi',
  'unlimited'=> 'Unlimited'
);

// If extra nodes are set, include them
if (is_array($config['peercount_extra_nodes'])) {
    $node_types = $default_types + $config['peercount_extra_nodes'];
} else {
    $node_types = $default_types;
}

// Initialise arrays
$to_insert = array(
    'time'     => time(),
    'other'    => 0
);

// Add counters
foreach ($node_types as $key => $val) {
    $to_insert[$key] = 0;
}

 // Loop through peers
foreach ($new_peers as $peer) {

    // Default peer counter
    $peer_type = 'other';

    // Check peer against array
    foreach ($node_types as $key => $regex) {
        if (strpos(strtolower($peer['subver']), strtolower($regex)) !== false) {
            $peer_type = $key;
        }
    }

    // Increment counters
    $to_insert[$peer_type] = $to_insert[$peer_type]+1;
}

// Insert data
$data[] = $to_insert;

// Purge old data
for ($i = 0; $i < count($data); $i++) {
    if ($data[$i]['time'] < (time() - $config['peercount_max_age'])) {
        array_splice($data, $i, 1);
    }
}

// Save array
if (file_put_contents($config['peercount_file'], json_encode($data), LOCK_EX) === false) {
    die("Failure storing data");
}