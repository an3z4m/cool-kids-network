<?php

class TestUserRoleUpdates extends WP_UnitTestCase {

    public function setUp(): void {
        parent::setUp();
        $this->api_instance = new Cool_Kids_API();
        $this->administrator = $this->factory->user->create_and_get(['role' => 'administrator']);
        wp_set_current_user($this->administrator->ID);
    }

    public function test_user_role_is_updated_successfully() {
        // Create a user to be updated
        $user = $this->factory->user->create_and_get(['role' => 'subscriber', 'user_email' => 'user@example.org']);

        // Prepare the request
        $request = new WP_REST_Request('POST', '/cool-kids/v1/update-role');
        $request->set_param('email', 'user@example.org');
        $request->set_param('role', 'coolest_kid');

        // Execute the request
        rest_do_request($request);

        // Verify the user's role has been updated
        $updated_user = get_userdata($user->ID);
        $this->assertTrue($updated_user->has_cap('coolest_kid'));
    }

    public function test_user_role_update_fails_with_invalid_role() {
        // Create a user to be updated
        $user = $this->factory->user->create_and_get(['role' => 'subscriber', 'user_email' => 'user@example.org']);

        // Prepare the request with an invalid role
        $request = new WP_REST_Request('POST', '/cool-kids/v1/update-role');
        $request->set_param('email', 'user@example.org');
        $request->set_param('role', 'invalid_role');  // Invalid role

        // Execute the request
        $response = rest_do_request($request);

        // Expect failure due to invalid role
        $this->assertEquals(400, $response->get_status());
    }

    public function test_user_role_does_not_change_if_already_set() {
        // Create a user with a specific role
        $user = $this->factory->user->create_and_get(['role' => 'coolest_kid', 'user_email' => 'user@example.org']);

        // Prepare the request with the same role
        $request = new WP_REST_Request('POST', '/cool-kids/v1/update-role');
        $request->set_param('email', 'user@example.org');
        $request->set_param('role', 'coolest_kid');

        // Execute the request
        $response = rest_do_request($request);

        // Verify the user's role has not been changed unnecessarily
        $updated_user = get_userdata($user->ID);
        $this->assertTrue($updated_user->has_cap('coolest_kid'));
    }
}
