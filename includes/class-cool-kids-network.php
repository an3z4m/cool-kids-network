<?php

class Cool_Kids_Network {

    public function __construct() {
        // Add roles and capabilities during plugin activation
        register_activation_hook(__FILE__, [$this, 'add_roles']);

        // Remove roles and capabilities during plugin deactivation
        register_deactivation_hook(__FILE__, [$this, 'remove_roles']);

        // Register shortcode for sign-up form
        add_shortcode('cool_kids_signup', [$this, 'render_signup_form']);

        // Enqueue scripts and styles
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    // Add custom roles on activation
    public function add_roles() {
        add_role('cool_kid', 'Cool Kid', [
            'read' => true,
            'edit_posts' => false,
        ]);
    }

    // Remove custom roles on deactivation
    public function remove_roles() {
        remove_role('cool_kid');
    }

    // Register and enqueue plugin scripts and styles
    public function enqueue_scripts() {
        // Enqueue CSS
        wp_enqueue_style('cool-kids-styles', plugin_dir_url(__FILE__) . '../assets/css/cool-kids-styles.css');
    
        // Enqueue JS
        wp_enqueue_script('cool-kids-scripts', plugin_dir_url(__FILE__) . '../assets/js/cool-kids-scripts.js', [], false, true);
    
        // Localize the script with the AJAX URL
        wp_localize_script('cool-kids-scripts', 'coolKidsData', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('cool_kids_signup_nonce')
        ]);
    }
    

    // Render the sign-up form using a template
    public function render_signup_form() {
        ob_start();
        include plugin_dir_path(__FILE__) . '../templates/signup-form.php';
        return ob_get_clean();
    }
}
