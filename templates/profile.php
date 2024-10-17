<?php
// Ensure the user is logged in
if (!is_user_logged_in()) {
    echo '<p>You must be logged in to view your profile.</p>';
    return;
}
?>

<div id="cool-kids-profile">
    <h2>Your Character Profile</h2>
    <p><strong>First Name:</strong> <?php echo esc_html($first_name); ?></p>
    <p><strong>Last Name:</strong> <?php echo esc_html($last_name); ?></p>
    <p><strong>Country:</strong> <?php echo esc_html($country); ?></p>

    <p><a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a></p>
</div>