


<div id="auth-forms">
	<div id="login-form">
		<h2>Login</h2>
		<form id="cool-kids-login" class="cool-kids-form">
			<input type="email" name="email" placeholder="Enter your email" required>
			<input type="hidden" name="login_nonce" value="<?php echo wp_create_nonce( 'cool_kids_login_nonce' ); ?>">
			<button type="submit">Login</button>
		</form>
	<div id="login-message" class="cool-kids-message"></div>
		<p>Don't have an account? <a href="#" id="show-signup" onclick="switchLoginSignupForm('signup');">Sign Up</a></p>
</div>
						
	<div id="signup-form" style="display:none;">
		<h2>Signup</h2>
		<form id="cool-kids-signup" class="cool-kids-form">
			<input type="email" name="email" placeholder="Enter your email" required>
			<input type="hidden" name="signup_nonce" value="<?php echo wp_create_nonce( 'cool_kids_signup_nonce' ); ?>">
			<button type="submit">Sign Up</button>
		</form>
	<div id="signup-message" class="cool-kids-message"></div>

	<p>Already have an account? <a href="#" id="show-login" onclick="switchLoginSignupForm('login');">Login</a></p>

	</div>            
</div>