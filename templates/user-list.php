<?php
if (!empty($users)) {

    $is_coolest_kid = in_array('coolest_kid', $current_user->roles); // Check if user is Coolest Kid

    echo '<table id="user-list">';
    
    // Header
    if ($is_coolest_kid) {
        echo '<tr><th>Profile Image</th><th>First Name</th><th>Last Name</th><th>Country</th><th>Email</th><th>Role</th></tr>';
    } else {
        echo '<tr><th>Profile Image</th><th>First Name</th><th>Last Name</th><th>Country</th></tr>';
    }
    
    // Loop through users
    foreach ($users as $user) {
        $first_name = get_user_meta($user->ID, 'first_name', true);
        $last_name = get_user_meta($user->ID, 'last_name', true);
        $country = get_user_meta($user->ID, 'country', true);
        $profile_image = get_user_meta($user->ID, 'profile_image', true);
        $email = $user->user_email;
        $user_roles = $user->roles; // Display roles as comma-separated list

        // Use the profile image if available, otherwise use a default image
        $image_url = !empty($profile_image) ? esc_url($profile_image) : esc_url(plugins_url('../assets/images/default-profile.jpg', __FILE__));

        echo '<tr>';
        echo '<td><img src="' . $image_url . '" alt="Profile Image" style="border-radius: 50%; width: 50px; height: 50px;"></td>';
        echo '<td>' . esc_html($first_name) . '</td>';
        echo '<td>' . esc_html($last_name) . '</td>';
        echo '<td>' . esc_html($country) . '</td>';
        
        // If the user is Coolest Kid, show email and role
        if ($is_coolest_kid) {
            echo '<td>' . esc_html($email) . '</td>';
            echo '<td>';
            foreach ($user_roles as $role_slug) {
                // Replace underscores with spaces and capitalize the first letter of each word
                $formatted_role_name = str_replace('_', ' ', $role_slug);
                $formatted_role_name = ucwords($formatted_role_name);
                
                echo esc_html($formatted_role_name) . '<br>'; // Display the formatted role name
            }            
            echo '</td>';
        }

        echo '</tr>';
    }

    echo '</table>';
} else {
    echo '<p>No users found.</p>';
}
?>