<?php

class TestCoolKidApiEndpoints extends WP_UnitTestCase {

	public function setUp(): void {
		parent::setUp();
		$this->api_instance  = new Cool_Kids_API();
		$this->administrator = $this->factory->user->create_and_get( array( 'role' => 'administrator' ) );
		wp_set_current_user( $this->administrator->ID );
	}

	public function test_register_routes() {
		// Ensure the route is registered
		$routes = rest_get_server()->get_routes();
		$this->assertArrayHasKey( '/cool-kids/v1/update-role', $routes );
	}

	public function test_update_user_role_with_valid_data() {
		// Create a user to be updated
		$user = $this->factory->user->create_and_get(
			array(
				'role'       => 'subscriber',
				'user_email' => 'user@example.org',
			)
		);

		// Prepare the request
		$request = new WP_REST_Request( 'POST', '/cool-kids/v1/update-role' );
		$request->set_param( 'email', 'user@example.org' );
		$request->set_param( 'role', 'coolest_kid' );

		// Execute the request
		$response = rest_do_request( $request );

		// Verify successful response
		$this->assertEquals( 200, $response->get_status() );
	}

	public function test_update_user_role_with_invalid_email() {
		// Prepare the request with invalid email
		$request = new WP_REST_Request( 'POST', '/cool-kids/v1/update-role' );
		$request->set_param( 'email', 'invalid-email' );
		$request->set_param( 'role', 'coolest_kid' );

		// Execute the request
		$response = rest_do_request( $request );

		// Expect validation failure
		$this->assertEquals( 400, $response->get_status() );
	}

	public function test_update_user_role_user_not_found() {
		// Test case where the user is not found
		$request = new WP_REST_Request( 'POST', '/cool-kids/v1/update-role' );
		$request->set_param( 'email', 'nonexistent@example.org' );
		$request->set_param( 'role', 'cool_kid' );

		// Execute the request
		$response = rest_do_request( $request );

		// Expect a 404 user not found response
		$this->assertEquals( 404, $response->get_status() );
	}
}
