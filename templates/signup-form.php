<form id="cool-kids-signup">
    <input type="email" name="email" placeholder="Enter your email" required>
    <input type="hidden" name="signup_nonce" value="<?php echo wp_create_nonce('cool_kids_signup_nonce'); ?>">
    <button type="submit">Sign Up</button>
</form>
<div id="signup-message"></div>