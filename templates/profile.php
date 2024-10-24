<?php
// Ensure the user is logged in
if ( ! is_user_logged_in() ) {
	echo '<p>You must be logged in to view your profile.</p>';
	return;
}

$user_id           = get_current_user_id();
$user_data         = get_userdata( $user_id );
$first_name        = get_user_meta( $user_id, 'first_name', true );
$last_name         = get_user_meta( $user_id, 'last_name', true );
$country           = get_user_meta( $user_id, 'country', true );
$user_email        = $user_data->user_email;
$user_roles        = str_replace( '_', ' ', implode( ', ', $user_data->roles ) );
$profile_image     = get_user_meta( $user_id, 'profile_image', true );  // Get profile image URL
$username          = $user_data->user_login;
$registration_date = date( 'F j, Y', strtotime( $user_data->user_registered ) ); // Format the registration date
$user_bio          = get_user_meta( $user_id, 'description', true ); // Assume there's a user bio
?>

<div id="cool-kids-profile" class="grid-layout modern-profile">
	<div class="profile-grid">
		<!-- Profile Image Section -->
		<div class="profile-image">
			<?php if ( ! empty( $profile_image ) ) : ?>
				<img src="<?php echo esc_url( $profile_image ); ?>" alt="Profile Image">
			<?php else : ?>
				<img src="<?php echo esc_url( plugins_url( '../assets/images/default-profile.jpg', __FILE__ ) ); ?>" alt="Default Profile Image">
			<?php endif; ?>
		</div>

		<!-- Basic Information Section -->
		<div class="profile-details">
			<h3>Basic Information</h3>
			<p><strong>Username:</strong> <?php echo esc_html( $username ); ?></p>
			<p><strong>First Name:</strong> <?php echo esc_html( $first_name ); ?></p>
			<p><strong>Last Name:</strong> <?php echo esc_html( $last_name ); ?></p>
		</div>

		<!-- Contact Information Section -->
		<div class="profile-details">
			<h3>Contact Information</h3>
			<p><strong>Email:</strong> <?php echo esc_html( $user_email ); ?></p>
			<p><strong>Country:</strong> <?php echo esc_html( $country ); ?></p>
		</div>

		<!-- Account Information Section -->
		<div class="profile-details">
			<h3>Account Information</h3>
			<p><strong>Role:</strong> <?php echo esc_html( ucwords( $user_roles ) ); ?></p>
			<p><strong>Registration Date:</strong> <?php echo esc_html( $registration_date ); ?></p>
		</div>

		<!-- Bio Section (Optional) -->
		<?php if ( $user_bio ) : ?>
			<div class="profile-details bio-section">
				<h3>About Me</h3>
				<p><?php echo esc_html( $user_bio ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>
