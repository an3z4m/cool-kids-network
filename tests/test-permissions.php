<?php

class TestPermissions extends WP_UnitTestCase {

	public function setUp(): void {
		parent::setUp();
		$this->api_instance = new Cool_Kids_API();
	}

	public function test_permission_denied_for_non_admin_user() {
		// Create a user without admin privileges
		$non_admin = $this->factory->user->create_and_get( array( 'role' => 'subscriber' ) );
		wp_set_current_user( $non_admin->ID );

		// Prepare the request
		$request = new WP_REST_Request( 'POST', '/cool-kids/v1/update-role' );
		$request->set_param( 'role', 'cool_kid' );

		// Execute the request
		$response = rest_do_request( $request );

		// Expect permission denied
		$this->assertEquals( 403, $response->get_status() );
	}

	public function test_permission_granted_for_admin_user() {
		// Create an admin user
		$admin = $this->factory->user->create_and_get( array( 'role' => 'administrator' ) );
		wp_set_current_user( $admin->ID );

		// Prepare the request
		$request = new WP_REST_Request( 'POST', '/cool-kids/v1/update-role' );
		$request->set_param( 'role', 'cool_kid' );

		// Execute the request
		$response = rest_do_request( $request );

		// Ensure the request succeeds
		$this->assertNotEquals( 403, $response->get_status() );
	}
}
