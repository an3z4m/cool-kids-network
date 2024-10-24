<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit; // Exit if accessed directly
}

// Remove the custom role
remove_role( 'cool_kid' );
