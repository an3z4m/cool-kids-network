<?php

class CoolKidsApiTest extends WP_UnitTestCase {
    function test_update_user_role() {
        // Mock user creation
        $user_id = $this->factory->user->create(['role' => 'cool_kid']);

        // Mock an API call to update the user role
        $response = $this->api_call_update_user_role($user_id, 'coolest_kid');
        
        // Assert that the role was updated successfully
        $this->assertEquals('coolest_kid', get_userdata($user_id)->roles[0]);
    }

    function api_call_update_user_role($user_id, $new_role) {
        // Simulate an API call or direct update
        wp_update_user(['ID' => $user_id, 'role' => $new_role]);
        return true;
    }
}
