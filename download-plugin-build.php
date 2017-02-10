<?php
/**
 * Plugin Name:     Download Plugin Build
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Adds a "Download Plugin" link if the plugin's build is found.
 * Author:          Daniel Bachhuber
 * Author URI:      https://danielbachhuber.com
 * Text Domain:     download-plugin-build
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Download_Plugin_Build
 */

add_filter( 'plugin_action_links', function( $links, $plugin ){
	$plugin_base_dir = dirname( $plugin );
	if ( in_array( $plugin_base_dir, array( '.', 'download-plugin-build' ), true ) ) {
		return $links;
	}

	$builds = glob( WP_PLUGIN_DIR . '/' . $plugin_base_dir . '*.zip' );
	if ( empty( $builds ) ) {
		return $links;
	}
	$build = array_shift( $builds );
	$build_url = str_replace( WP_PLUGIN_DIR, plugins_url(), $build );
	$build_label = sprintf( 'Download %s', basename( $build ) );
	$new_links = array();
	foreach( $links as $k => $j ) {
		$new_links[ $k ] = $j;
		if ( in_array( $k, array( 'activate', 'deactivate' ), true ) ) {
			$new_links['download_plugin_build'] = '<a title="' . esc_attr( $build_label ) . '" href="' . esc_url( $build_url ) . '">Download Build</a>';
		}
	}
	return $new_links;
}, 10, 2);
