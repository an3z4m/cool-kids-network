<?php
if (!empty($users)) {
    echo '<table id="user-list">';
    echo '<tr><th>First Name</th><th>Last Name</th><th>Country</th></tr>';
    foreach ($users as $user) {
        $first_name = get_user_meta($user->ID, 'first_name', true);
        $last_name = get_user_meta($user->ID, 'last_name', true);
        $country = get_user_meta($user->ID, 'country', true);

        echo '<tr>';
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