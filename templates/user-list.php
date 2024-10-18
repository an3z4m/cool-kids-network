<?php
if (!empty($users)) {
    echo '<table id="user-list">';
    echo '<tr><th>Profile Image</th><th>First Name</th><th>Last Name</th><th>Country</th></tr>';
    foreach ($users as $user) {
        $first_name = get_user_meta($user->ID, 'first_name', true);
        $last_name = get_user_meta($user->ID, 'last_name', true);
        $country = get_user_meta($user->ID, 'country', true);
        $profile_image = get_user_meta($user->ID, 'profile_image', true);

        // Use the profile image if available, otherwise use a default image
        $image_url = !empty($profile_image) ? esc_url($profile_image) : esc_url(plugins_url('../assets/images/default-profile.jpg', __FILE__));

        echo '<tr>';
        echo '<td><img src="' . $image_url . '" alt="Profile Image" style="border-radius: 50%; width: 50px; height: 50px;"></td>';
        echo '<td>' . esc_html($first_name) . '</td>';
        echo '<td>' . esc_html($last_name) . '</td>';
        echo '<td>' . esc_html($country) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>No users found.</p>';
}
?>