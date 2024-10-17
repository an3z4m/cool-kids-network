document.addEventListener('DOMContentLoaded', function() {
    const signupForm = document.getElementById('cool-kids-signup');
    signupForm.addEventListener('submit', function(event) {
        event.preventDefault();

        const email = signupForm.querySelector('input[name="email"]').value;
        const signupNonce = coolKidsData.nonce;

        // Basic validation
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
});
