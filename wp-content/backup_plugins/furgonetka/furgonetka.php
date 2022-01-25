<?php

/**
 *
 * @link              https://furgonetka.pl
 * @since             1.0.0
 * @package           Furgonetka
 *
 * @wordpress-plugin
 * Plugin Name:       Furgonetka.pl
 * Plugin URI:        https://furgonetka.pl
 * Description:       Połącz swój sklep z modułem Furgonetka.pl! Generuj etykiety, twórz szablony przesyłek, śledź statusy paczek. Nadawaj paczki szybko i tanio korzystając z 10 firm kurierskich.
 * Version:           1.0.9
 * Author:            Furgonetka.pl
 * Author URI:        https://furgonetka.pl
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Developer:         codebox
 * Developer URI:     http://codebox.pl
 * Text Domain:       furgonetka
 * Domain Path:       /languages
 *
 * WC requires at least: 3.4.7
 * WC tested up to: 5.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FURGONETKA_VERSION', '1.0.9' );
define( 'FURGONETKA_PLUGIN_NAME', 'furgonetka' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-furgonetka-activator.php
 */
function activate_furgonetka() {
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-furgonetka-activator.php';
        Furgonetka_Activator::activate();
    }

}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-furgonetka-deactivator.php
 */
function deactivate_furgonetka() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-furgonetka-deactivator.php';
    Furgonetka_Deactivator::deactivate();

}

register_activation_hook( __FILE__, 'activate_furgonetka' );
register_deactivation_hook( __FILE__, 'deactivate_furgonetka' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-furgonetka.php';

add_filter('woocommerce_rest_orders_prepare_object_query', function(array $args, \WP_REST_Request $request) {
    $modified_after = $request->get_param('modified_after');

    if (!$modified_after) {
        return $args;
    }

    $args['date_query'][] = array(
        'column' => 'post_modified',
        'after' => $modified_after
    );

    return $args;

}, 100, 2);

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_furgonetka() {
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $plugin = new Furgonetka();
        $plugin->run();
    }

}
run_furgonetka();