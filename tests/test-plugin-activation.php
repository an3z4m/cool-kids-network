<?php
class PluginTestCase extends WP_UnitTestCase {

	// This method will run before every test function
	public function setUp(): void {
		parent::setUp();

		// Activate the plugin before each test
		activate_plugin( 'cool-kids-network/cool-kids-network.php' );
	}

	// Example test to verify roles
	public function test_roles_are_registered() {
		$this->assertNotFalse( get_role( 'cool_kid' ), 'Role "Cool Kid" not registered.' );
		$this->assertNotFalse( get_role( 'cooler_kid' ), 'Role "Cooler Kid" not registered.' );
		$this->assertNotFalse( get_role( 'coolest_kid' ), 'Role "Coolest Kid" not registered.' );
	}
}
