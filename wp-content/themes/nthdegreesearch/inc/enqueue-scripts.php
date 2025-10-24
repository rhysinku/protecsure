<?php
/**
 * Enqueue theme assets.
 */
add_action( 'wp_enqueue_scripts', 'nds_enqueue_scripts' );
function nds_enqueue_scripts() {
	$theme = wp_get_theme();

	wp_enqueue_style( 'nds', nds_asset( 'assets/css/style.css' ), array(), $theme->get( 'Version' ) );

	wp_enqueue_script( 'nds', nds_asset( 'assets/js/script.js' ), array('jquery'), $theme->get( 'Version' ), true );
}


/**
 * Enqueue admin scripts and styles.
 */
add_action( 'enqueue_block_editor_assets', 'nds_block_enqueues' );
function nds_block_enqueues() {
	$theme = wp_get_theme();
	
	wp_enqueue_style( 'nds-block', nds_asset( 'assets/css/block-editor.css' ), array(), $theme->get( 'Version' ) );
	wp_enqueue_style( 'nds', nds_asset( 'assets/css/style.css' ), array(), $theme->get( 'Version' ) );
	wp_enqueue_script( 'nds-block', nds_asset( 'assets/js/block-editor.js' ), array(), $theme->get( 'Version' ) );
	wp_enqueue_script( 'nds', nds_asset( 'assets/js/script.js' ), array('jquery'), $theme->get( 'Version' ), true );
}


/**
 * Get asset path.
 *
 * @param string  $path Path to asset.
 *
 * @return string
 */
function nds_asset( $path ) {
	if ( wp_get_environment_type() === 'production' ) {
		return get_stylesheet_directory_uri() . '/' . $path;
	}

	return add_query_arg( 'time', time(),  get_stylesheet_directory_uri() . '/' . $path );
}