<?php

class Cool_Kids_Ajax
{
    public function __construct()
    {
        // Handle AJAX for non-logged-in and logged-in users
        add_action('wp_ajax_nopriv_signup_user', [$this, 'signup_user']);
        add_action('wp_ajax_signup_user', [$this, 'signup_user']);

        add_action('wp_ajax_nopriv_login_user', [$this, 'login_user']);
        add_action('wp_ajax_login_user', [$this, 'login_user']);
    }

    // Handle user sign-up via AJAX
    public function signup_user()
    {
        check_ajax_referer('cool_kids_signup_nonce', 'signup_nonce'); // Nonce verification

        $email = sanitize_email($_POST['email']);
        if (!is_email($email)) {
            wp_send_json_error(['message' => 'Invalid email.']);
        }

        if (email_exists($email)) {
            wp_send_json_error(['message' => 'Email already registered.']);
        }

        // Call the randomuser.me API to get character data
        $response = wp_remote_get('https://randomuser.me/api/');
        if (is_wp_error($response)) {
            wp_send_json_error(['message' => 'Failed to generate character.']);
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true)['results'][0];

        $first_name = sanitize_text_field($data['name']['first']);
        $last_name = sanitize_text_field($data['name']['last']);
        $country = sanitize_text_field($data['location']['country']);
        $profile_image = esc_url($data['picture']['large']);  // Extracting profile image URL

        // Create a new user with the email
        $user_id = wp_create_user($email, wp_generate_password(), $email);
        if (is_wp_error($user_id)) {
            wp_send_json_error(['message' => 'User registration failed.']);
        }

        // Assign the default role to the new user
        wp_update_user(['ID' => $user_id, 'role' => 'cool_kid']);

        // Store additional character data as user meta
        update_user_meta($user_id, 'first_name', $first_name);
        update_user_meta($user_id, 'last_name', $last_name);
        update_user_meta($user_id, 'country', $country);
        update_user_meta($user_id, 'profile_image', $profile_image);  // Store profile image

        wp_send_json_success(['message' => 'Sign up successful!']);
    }



    // Handle user login via AJAX
    public function login_user()
    {
        check_ajax_referer('cool_kids_login_nonce', 'login_nonce'); // Nonce verification

        $email = sanitize_email($_POST['email']);
        $user = get_user_by('email', $email);

        if (!$user || !email_exists($email)) {
            wp_send_json_error(['message' => 'Invalid email address.']);
        }

        // Log the user in
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);

        wp_send_json_success(['message' => 'Login successful!']);
    }
}

new Cool_Kids_Ajax();
