<?php

class Cool_Kids_Ajax {

    public function __construct() {
        // Handle AJAX for non-logged-in and logged-in users
        add_action('wp_ajax_nopriv_signup_user', [$this, 'signup_user']);
        add_action('wp_ajax_signup_user', [$this, 'signup_user']);
    }

    // Handle user sign-up via AJAX
    public function signup_user() {
        check_ajax_referer('cool_kids_signup_nonce', 'signup_nonce'); // Nonce verification
        $email = sanitize_email($_POST['email']);

        if (!is_email($email)) {
            wp_send_json_error(['message' => 'Invalid email.']);
        }

        if (email_exists($email)) {
            wp_send_json_error(['message' => 'Email already registered.']);
        }

        // Call randomuser.me API
        $response = wp_remote_get('https://randomuser.me/api/');
        if (is_wp_error($response)) {
            wp_send_json_error(['message' => 'Failed to generate character.']);
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true)['results'][0];
        $first_name = sanitize_text_field($data['name']['first']);
        $last_name = sanitize_text_field($data['name']['last']);
        $country = sanitize_text_field($data['location']['country']);

        // Create a new user
        $user_id = wp_create_user($email, wp_generate_password(), $email);
        if (is_wp_error($user_id)) {
            wp_send_json_error(['message' => 'User registration failed.']);
        }

        // Assign 'cool_kid' role to the new user
        wp_update_user(['ID' => $user_id, 'role' => 'cool_kid']);

        // Add meta fields for the user
        update_user_meta($user_id, 'first_name', $first_name);
        update_user_meta($user_id, 'last_name', $last_name);
        update_user_meta($user_id, 'country', $country);

        wp_send_json_success(['message' => 'Sign up successful!']);
    }
}

new Cool_Kids_Ajax();