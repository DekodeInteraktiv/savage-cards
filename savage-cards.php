<?php
/**
 * Plugin Name: Savage Cards
 * Plugin URI: https://github.com/dekodeinteraktiv/savage-cards
 * GitHub Plugin URI: https://github.com/dekodeinteraktiv/savage-cards
 * Description: Card setup plugin
 * Version: 1.0.0-dev
 * Author: Dekode
 * Author URI: https://dekode.no
 * License: GPL-3.0
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


require_once 'includes/class-card.php';
require_once 'includes/class-core.php';
require_once 'includes/helper-functions.php';

$_dir = dirname( plugin_basename( __FILE__ ) );
$_url = plugin_dir_url( __FILE__ );

\Dekode\Savage\Core::get_instance( $_dir, $_url );

add_action( 'savage/register_cards', __NAMESPACE__ . '\\savage_custom_card' );

/**
 * Register custom card
 */
function savage_custom_card() {
	require_once 'includes/class-custom-card.php';
	\savage_register_card( new \Dekode\Savage\CustomCard() );
}
