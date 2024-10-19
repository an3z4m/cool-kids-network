document.addEventListener('DOMContentLoaded', function () {
    // Handle signup form submission
    const signupForm = document.getElementById('cool-kids-signup');
    if (signupForm) {
        signupForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const email = signupForm.querySelector('input[name="email"]').value;
            const signupNonce = signupForm.querySelector('input[name="signup_nonce"]').value;

            if (!email.includes('@')) {
                document.getElementById('signup-message').innerText = 'Please enter a valid email.';
                return;
            }

            const data = new FormData();
            data.append('action', 'signup_user');
            data.append('email', email);
            data.append('signup_nonce', signupNonce);

            fetch(coolKidsData.ajaxurl, {
                method: 'POST',
                body: data,
            })
            .then(response => response.json())
            .then(result => {
                document.getElementById('signup-message').innerText = result.message;
            })
            .catch(error => {
                document.getElementById('signup-message').innerText = 'Something went wrong. Please try again.';
            });
        });
    }

    // Handle login form submission
    const loginForm = document.getElementById('cool-kids-login');
    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const email = loginForm.querySelector('input[name="email"]').value;
            const loginNonce = loginForm.querySelector('input[name="login_nonce"]').value;

            if (!email.includes('@')) {
                document.getElementById('login-message').innerText = 'Please enter a valid email.';
                return;
            }

            const data = new FormData();
            data.append('action', 'login_user');
            data.append('email', email);
            data.append('login_nonce', loginNonce);

            fetch(coolKidsData.ajaxurl, {
                method: 'POST',
                body: data,
            })
            .then(response => response.json())
            .then(result => {
                document.getElementById('login-message').innerText = result.message;
            })
            .catch(error => {
                document.getElementById('login-message').innerText = 'Something went wrong. Please try again.';
            });
        });
    }
});
