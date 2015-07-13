<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

global $wpdb;	

$table = $wpdb->prefix . "great_newsletter";
$sql = 'DROP TABLE '.$table;
$wpdb->query( $sql );

delete_option( 'wp_great_newsletter_text_color_button' );
delete_option( 'wp_great_newsletter_text_color_field' );
delete_option( 'wp_great_newsletter_color_button' );
delete_option( 'wp_great_newsletter_color_field' );
delete_option( 'wp_great_newsletter_name' );
delete_option( 'wp_great_newsletter_telephone' );
delete_option( 'wp_great_newsletter_type' );
delete_option( 'wp_great_newsletter_unsubscribe_option' );
