<?php
/**
 * Plugin Name: Cool Kids Network
 * Description: A proof of concept for user management and role-based access in WordPress.
 * Version: 1.0
 * Author: Dr. Nabil Kerkacha
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access.
}


class CoolKidsNetwork {

    public function __construct() {
        add_action('init', [$this, 'register_roles']);
        add_shortcode('cool_kids_signup', [$this, 'render_signup_form']);
        add_action('wp_ajax_nopriv_signup_user', [$this, 'signup_user']);
        add_action('wp_ajax_signup_user', [$this, 'signup_user']);
    }

    // Sign-up form shortcode
    public function render_signup_form() {
        $nonce = wp_create_nonce('cool_kids_signup_nonce'); // Nonce for security
        ob_start(); ?>
        <form id="cool-kids-signup">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="hidden" name="signup_nonce" value="<?php echo $nonce; ?>">
            <button type="submit">Sign Up</button>
        </form>
        <div id="signup-message"></div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const signupForm = document.getElementById('cool-kids-signup');
                signupForm.addEventListener('submit', function(event) {
                    event.preventDefault();
    
                    const email = signupForm.querySelector('input[name="email"]').value;
                    const signupNonce = signupForm.querySelector('input[name="signup_nonce"]').value;
    
                    // Basic front-end validation
                    if (!email.includes('@')) {
                        document.getElementById('signup-message').innerText = 'Please enter a valid email.';
                        return;
                    }
    
                    // Prepare data for AJAX
                    const data = new FormData();
                    data.append('action', 'signup_user');
                    data.append('email', email);
                    data.append('signup_nonce', signupNonce);
    
                    // Perform AJAX request using fetch API
                    fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                        method: 'POST',
                        body: data,
                    })
                    .then(response => response.json())
                    .then(result => {
                        document.getElementById('signup-message').innerText = result.message;
                    })
                    .catch(error => {
                        document.getElementById('signup-message').innerText = 'Something went wrong. Please try again.';
                    });
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }
    
    // Handle user sign-up process with nonce verification
    public function signup_user() {
        check_ajax_referer('cool_kids_signup_nonce', 'signup_nonce'); // Nonce verification
    
        $email = sanitize_email($_POST['email']);
        if (!is_email($email)) {
            wp_send_json_error(['message' => 'Invalid email.']);
        }
        
        if (email_exists($email)) {
            wp_send_json_error(['message' => 'Email already registered.']);
        }
    
        // Fetch character data from the randomuser.me API
        $response = wp_remote_get('https://randomuser.me/api/');
        if (is_wp_error($response)) {
            wp_send_json_error(['message' => 'Failed to generate character.']);
        }
    
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true)['results'][0];
    
        $first_name = sanitize_text_field($data['name']['first']);
        $last_name = sanitize_text_field($data['name']['last']);
        $country = sanitize_text_field($data['location']['country']);
    
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
    
        wp_send_json_success(['message' => 'Sign up successful!']);
    }
}    

new CoolKidsNetwork();