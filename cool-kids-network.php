<?php
/**
 * Plugin Name: Cool Kids Network
 * Description: A proof of concept for user management and role-based access in WordPress.
 * Version: 1.0.1
 * Author: Nabil Kerkacha
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access.
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/class-cool-kids-network.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-cool-kids-ajax.php';

// Initialize the plugin
function cool_kids_network_init() {
    $cool_kids = new Cool_Kids_Network();
}
add_action('plugins_loaded', 'cool_kids_network_init');
