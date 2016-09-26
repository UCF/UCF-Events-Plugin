<?php
/**
 * Handles uninstallation logic.
 **/
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}


require_once 'includes/ucf-events-config.php';

// Delete options
UCF_Events_Config::delete_options();
