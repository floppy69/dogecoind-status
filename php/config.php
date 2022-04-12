<?php
/**
 * Dogecoin Status Page
 *
 * @category File
 * @package  DogecoinStatus
 * @author   Craig Watson <craig@cwatson.org>
 * @Forked   By   Floppy69 <a.maaded@gmail.com>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/floppy69/dogecoind-status
 */

$config = array(
  // RPC
  'rpc_user'                => 'rpcuser',
  'rpc_pass'                => 'rpcpasswd',
  'rpc_host'                => 'localhost',
  'rpc_port'                => '22555',
  'rpc_ssl'                 => false,
  'rpc_ssl_ca'              => null,

  // Donations
  'display_donation_text'   => true,
  // 'donation_address'        => 'DNxB12TG8ijZxcG4oGaDAgVNuzSxdkMRDD', //
  'donation_address'        => 'not_set',
  'donation_amount'         => '1.69420',

  // Peers
  'display_peer_info'       => true,
  'display_peer_port'       => false,
  'hide_dark_peers'         => true,
  'peers_to_ignore'         => array(),

  // Cache
  'use_cache'               => true,
  'cache_file'              => '/tmp/dogecoind-status.cache',
  'max_cache_time'          => 60,
  'nocache_whitelist'       => array('127.0.0.1'),

  // Geolocation
  'geolocate_peer_ip'       => true,
  'display_ip_location'     => true,

  // UI
  'display_ip'              => true,
  'display_free_disk_space' => true,
  'display_testnet'         => false,
  'display_version'         => true,
  'display_github_ribbon'   => true,
  'display_max_height'      => true,
  'use_dogecoind_ip'         => true,
  'intro_text'              => 'Dogecoin node -_-  Much WoW !',
  'display_sochain_info'   => true,
  'display_chart'           => true,
  'node_links'              => array(),

  // Stats
  'stats_whitelist'         => array('127.0.0.1'),
  'stats_file'              => '/tmp/dogecoind-status.data',
  'stats_max_age'           => '604800',
  'stats_min_data_points'   => 5,

  // Uptime
  'display_dogecoind_uptime' => true,
  'dogecoind_process_name'   => 'dogecoind',

  // System
  'date_format'             => 'j F Y , H:i:s T',
  'disk_space_mount_point'  => '/',
  'timezone'                => 'Europe/Paris',
  'stylesheet'              => 'v2-dark.css',
  'debug'                   => false,
  'admin_email'             => 'admin@server.tld',
 
  // Miscellaneous
 'particles'               => true,
);
