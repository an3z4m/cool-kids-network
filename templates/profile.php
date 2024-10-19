<?php
// Ensure the user is logged in
if (!is_user_logged_in()) {
    echo '<p>You must be logged in to view your profile.</p>';
    return;
}

$user_id = get_current_user_id();
$first_name = get_user_meta($user_id, 'first_name', true);
$last_name = get_user_meta($user_id, 'last_name', true);
$country = get_user_meta($user_id, 'country', true);
$profile_image = get_user_meta($user_id, 'profile_image', true);  // Get profile image URL
?>


<div id="cool-kids-profile">
    <h2>Your Character Profile</h2>
    
    <?php if (!empty($profile_image)) : ?>
        <img src="<?php echo esc_url($profile_image); ?>" alt="Profile Image" style="border-radius: 50%; width: 150px; height: 150px;">
    <?php else : ?>
        <img src="<?php echo esc_url(plugins_url('../assets/images/default-profile.jpg', __FILE__)); ?>" alt="Default Profile Image" style="border-radius: 50%; width: 150px; height: 150px;">
    <?php endif; ?>
    
    <p><strong>First Name:</strong> <?php echo esc_html($first_name); ?></p>
    <p><strong>Last Name:</strong> <?php echo esc_html($last_name); ?></p>
    <p><strong>Country:</strong> <?php echo esc_html($country); ?></p>

    <p><a href="<?php echo wp_logout_url(home_url()); ?>">Logout</a></p>
</div>
