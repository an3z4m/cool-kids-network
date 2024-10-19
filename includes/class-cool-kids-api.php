<?php

class Cool_Kids_API
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes()
    {
        register_rest_route('cool-kids/v1', '/update-role', [
            'methods' => 'POST',
            'callback' => [$this, 'update_user_role'],
            'permission_callback' => [$this, 'check_permissions'],
            'args' => $this->get_endpoint_args(),
        ]);
    }

    public function get_endpoint_args()
    {
        return [
            'email' => [
                'required' => false,
                'validate_callback' => function ($param) {
                    return is_email($param);
                },
                'description' => 'The email of the user to update.',
            ],
            'first_name' => [
                'required' => false,
                'validate_callback' => function ($param) {
                    return !empty($param);
                },
                'description' => 'The first name of the user.',
            ],
            'last_name' => [
                'required' => false,
                'validate_callback' => function ($param) {
                    return !empty($param);
                },
                'description' => 'The last name of the user.',
            ],
            'role' => [
                'required' => true,
                'validate_callback' => function ($param) {
                    return in_array($param, ['cool_kid', 'cooler_kid', 'coolest_kid']);
                },
                'description' => 'The new role to assign to the user.',
            ],
        ];
    }

    public function check_permissions()
    {
        // Only administrators or maintainers can access this endpoint
        return current_user_can('administrator');
    }

    public function update_user_role(WP_REST_Request $request)
    {
        $email = sanitize_email($request->get_param('email'));
        $first_name = sanitize_text_field($request->get_param('first_name'));
        $last_name = sanitize_text_field($request->get_param('last_name'));
        $new_role = sanitize_text_field($request->get_param('role'));
    
        // Check if we are searching by email or first and last name
        if (!empty($email)) {
            $user = get_user_by('email', $email);
        } elseif (!empty($first_name) && !empty($last_name)) {
            $user_query = new WP_User_Query([
                'meta_query' => [
                    'relation' => 'AND',
                    [
                        'key' => 'first_name',
                        'value' => $first_name,
                        'compare' => '='
                    ],
                    [
                        'key' => 'last_name',
                        'value' => $last_name,
                        'compare' => '='
                    ]
                ]
            ]);
    
            $users = $user_query->get_results();
            if (!empty($users)) {
                $user = $users[0];
            }
        }
    
        // If user not found
        if (empty($user)) {
            error_log('User not found for role update request. Email: ' . $email . ', First Name: ' . $first_name . ', Last Name: ' . $last_name);
            return new WP_Error('user_not_found', 'User not found with the provided information.', ['status' => 404]);
        }
    
        // Log the role change action
        error_log('Changing role for user: ' . $user->user_email . ' to ' . $new_role);
    
        // Update the user's role
        $user->set_role($new_role);
    
        // Check if the capability (role) is correctly set by using has_cap
        if (!$user->has_cap($new_role)) {
            error_log('Failed to update role for user: ' . $user->user_email);
            return new WP_Error('role_update_failed', 'Failed to update user role.', ['status' => 500]);
        }
    
        return new WP_REST_Response([
            'status' => 'success',
            'message' => 'User role updated successfully.',
            'user' => [
                'ID' => $user->ID,
                'email' => $user->user_email,
                'role' => $new_role,
            ]
        ], 200);
    }
    
}

new Cool_Kids_API();