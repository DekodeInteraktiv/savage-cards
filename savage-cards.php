<?php
/**
 * Plugin Name: Savage Cards
 * Plugin URI: https://github.com/dekodeinteraktiv/savage-cards
 * GitHub Plugin URI: https://github.com/dekodeinteraktiv/savage-cards
 * Description: Card setup plugin
 * Version: 1.0.4
 * Author: Dekode
 * Author URI: https://dekode.no
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * Text Domain: savage-cards
 * Domain Path: /languages/
 *
 * @package Savage
 * @author Dekode
 */

declare( strict_types = 1 );
namespace Dekode\Savage;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'SAVAGE_CARDS_PATH', plugin_dir_path( __FILE__ ) );
define( 'SAVAGE_CARDS_DIR', dirname( plugin_basename( __FILE__ ) ) );
define( 'SAVAGE_CARDS_URL', plugin_dir_url( __FILE__ ) );

require_once 'includes/class-card.php';
require_once 'includes/class-core.php';
require_once 'includes/class-classnames.php';
require_once 'includes/helper-functions.php';

/**
 * Boot
 */
function init() {
	load_plugin_textdomain( 'savage-cards', false, SAVAGE_CARDS_DIR . '/languages' );
	\Dekode\Savage\Core::get_instance();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\init' );
