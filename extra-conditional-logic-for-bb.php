<?php
/**
 * Plugin Name: Extra Conditional Logic for Beaver Builder
 * Plugin URI: https://github.com/sethstevenson/bb-extra-conditional-logic
 * Description: Adds extra options to Beaver Builder's conditional logic settings
 * Version: 1.0.1
 * Author: Seth Stevenson
 * Author URI: https://sethstevenson.net
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'EXTRA_CONDITIONAL_LOGIC_FOR_BB_DIR', plugin_dir_path( __FILE__ ) );
define( 'EXTRA_CONDITIONAL_LOGIC_FOR_BB_URL', plugins_url( '/', __FILE__ ) );
define( 'EXTRA_CONDITIONAL_LOGIC_FOR_BB_VERSION', '1.0.1');

/**
 * The core plugin class
 * 
 * @since 1.0.0
 * 
 * Defines the core actions for the plugin. Registers backend
 * and frontend functionality with WordPress
 */

class Extra_Conditional_Logic_For_Bb {

	public function run() {

		require_once EXTRA_CONDITIONAL_LOGIC_FOR_BB_DIR . 'vendor/autoload.php';
		require_once EXTRA_CONDITIONAL_LOGIC_FOR_BB_DIR . 'includes/rules.php';

		$backend_rules = new Extra_Conditional_Logic_For_Bb_Rules();
		$backend_rules->init();
		
		add_action( 'bb_logic_enqueue_scripts', function() {
			wp_enqueue_script(
				'extra-conditional-logic-for-bb-rules',
				EXTRA_CONDITIONAL_LOGIC_FOR_BB_URL . 'js/rules.js',
				array( 'bb-logic-core' ),
				EXTRA_CONDITIONAL_LOGIC_FOR_BB_VERSION,
				true
			);
		} );
	}
}

/**
 * Runs the core plugin
 *
 * @since 1.0.0
 * @return void
 */
function run_extra_conditional_logic_for_bb() {
	$plugin = new Extra_Conditional_Logic_For_Bb();
	$plugin->run();
}


/**
 * Displays error message in Admin dashboard if Beaver Themer is not active
 *
 * @since 1.0.1
 * @return void
 */
function dependency_error_admin_notice() {
  echo '<div class="error"><p>Extra Conditional Logic for Beaver Builder requires the Beaver Themer plugin.</p></div>';
}

if ( ! function_exists( 'is_plugin_active' ) ){
	require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

// If Beaver Themer is active then run plugin
if( is_plugin_active( 'bb-theme-builder/bb-theme-builder.php' ) ) {
	run_extra_conditional_logic_for_bb();
} else {
	// Otherwise show the dependency error
	add_action( 'admin_notices', 'dependency_error_admin_notice' );
}