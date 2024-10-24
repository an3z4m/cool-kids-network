<?php
/**
 * Plugin Name: Cool Kids Network
 * Description: A proof of concept for user management and role-based access in WordPress.
 * Version: 1.0.1
 * Author: Nabil Kerkacha

 * @package CoolKidsNetwork
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Prevent direct access.
}

// Include necessary files.
require_once plugin_dir_path( __FILE__ ) . 'includes/class-cool-kids-network.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-cool-kids-ajax.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-cool-kids-api.php';

// Initialize the class.
$cool_kids_network = new Cool_Kids_Network();

// Register activation and deactivation hooks.
// register the new custom roles and capabilities when the plugin is activated.
register_activation_hook( __FILE__, array( $cool_kids_network, 'add_roles' ) );
// remove the custom roles and capabilities when the plugin is deactivated.
register_deactivation_hook( __FILE__, array( $cool_kids_network, 'remove_roles' ) );
