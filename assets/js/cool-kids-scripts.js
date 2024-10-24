// Handle login form submission
function switchLoginSignupForm(formType = 'login'){
	if (formType === 'login') {
		document.getElementById( 'login-form' ).style.display  = '';
		document.getElementById( 'signup-form' ).style.display = 'none';
		document.getElementById( 'signup-form' ).closest( 'form' ).reset();
	} else if (formType === 'signup') {
		document.getElementById( 'signup-form' ).style.display = '';
		document.getElementById( 'login-form' ).style.display  = 'none';
		document.getElementById( 'login-form' ).closest( 'form' ).reset();
	}
}


document.addEventListener(
	'DOMContentLoaded',
	function () {
		// Handle signup form submission
		const signupForm = document.getElementById( 'cool-kids-signup' );
		if (signupForm) {
			signupForm.addEventListener(
				'submit',
				function (event) {
					event.preventDefault();

					const email       = signupForm.querySelector( 'input[name="email"]' ).value;
					const signupNonce = signupForm.querySelector( 'input[name="signup_nonce"]' ).value;

					if ( ! email.includes( '@' )) {
						document.getElementById( 'signup-message' ).innerText = 'Please enter a valid email.';
						return;
					}

					const data = new FormData();
					data.append( 'action', 'signup_user' );
					data.append( 'email', email );
					data.append( 'signup_nonce', signupNonce );

					fetch(
						coolKidsData.ajaxurl,
						{
							method: 'POST',
							body: data,
						}
					)
					.then( response => response.json() )
					.then(
						result => {
                        document.getElementById( 'signup-message' ).innerText = result.data.message;
                        console.log( result );
							if (result.success) {
								setTimeout(
								() => {
									document.getElementById( 'signup-message' ).innerText = '';
									switchLoginSignupForm( 'login' );
								},
								3500
								);
							}
						}
					)
					.catch(
						error => {
							document.getElementById( 'signup-message' ).innerText = 'Something went wrong. Please try again.';
						}
					);
				}
			);
		}

		const loginForm = document.getElementById( 'cool-kids-login' );
		if (loginForm) {
			loginForm.addEventListener(
				'submit',
				function (event) {
					event.preventDefault();

					const email      = loginForm.querySelector( 'input[name="email"]' ).value;
					const loginNonce = loginForm.querySelector( 'input[name="login_nonce"]' ).value;

					if ( ! email.includes( '@' )) {
						document.getElementById( 'login-message' ).innerText = 'Please enter a valid email.';
						return;
					}

					const data = new FormData();
					data.append( 'action', 'login_user' );
					data.append( 'email', email );
					data.append( 'login_nonce', loginNonce );

					fetch(
						coolKidsData.ajaxurl,
						{
							method: 'POST',
							body: data,
						}
					)
					.then( response => response.json() )
					.then(
						result => {
							document.getElementById( 'login-message' ).innerText = result.data.message;
							if (result.success) {
								setTimeout(
								() => {
									document.getElementById( 'login-message' ).innerText = '';
									window.location.reload();
									},
								3500
								);
							}
						}
					)
					.catch(
						error => {
							document.getElementById( 'login-message' ).innerText = 'Something went wrong. Please try again.';
						}
					);
				}
			);
		}
	}
);


document.addEventListener(
	'DOMContentLoaded',
	function () {
		const tabs     = document.querySelectorAll( '.tab-link' );
		const contents = document.querySelectorAll( '.tab-content' );

		tabs.forEach(
			tab => {
				tab.addEventListener(
                'click',
                function () {
                    const target = this.getAttribute( 'data-tab' );

                    // Remove active class from all tabs and contents
                    tabs.forEach( t => t.classList.remove( 'active' ) );
                    contents.forEach( c => c.classList.remove( 'active' ) );

                    // Add active class to clicked tab and corresponding content
                    this.classList.add( 'active' );
                    document.getElementById( target ).classList.add( 'active' );
                }
            );
			}
		);
	}
);
