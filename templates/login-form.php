<form id="cool-kids-login">
    <input type="email" name="email" placeholder="Enter your email" required>
    <input type="hidden" name="login_nonce" value="<?php echo wp_create_nonce('cool_kids_login_nonce'); ?>">
    <button type="submit">Login</button>
</form>
<div id="login-message"></div>