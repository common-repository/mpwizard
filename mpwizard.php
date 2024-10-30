<?php
/**
 * Plugin Name:     MPWizard
 * Plugin URI:      https://laudanumsoft.com
 * Description:     Create Mercado Pago payment links directly on your WordPress website.
 * Requires at least: 4.9.19
 * Requires PHP:      5.6
 * Version:         1.2.1
 * Author:          Laudanumsoft
 * Author URI:      https://laudanumsoft.com
 * Text Domain:     mpwizard
 * Domain Path:     /languages
 * 
 *
 * You should have received a copy of the GNU General Public License
 * along with MPWizard. If not, see <https://www.gnu.org/licenses/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Folder Path.
 *
 * @since 1.0.0
 * 
 */
if ( ! defined( 'MPWIZARD_PLUGIN_DIR' ) ) {
	define( 'MPWIZARD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

/**
 * Plugin Folder URL.
 *
 * @since 1.0.0
 * 
 */
if ( ! defined( 'MPWIZARD_PLUGIN_URL' ) ) {
	define( 'MPWIZARD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Activation.
 */
require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-activate.php';

register_activation_hook( __FILE__, 'mpwizard_activate' );

/**
 * Plugin menu.
 */
require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-menu.php';

/**
 * Post types.
 */
require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-post-types.php';

/**
 * Plugin settings.
 */
require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-settings.php';

/**
 * Load actions and filters.
 */
require_once MPWIZARD_PLUGIN_DIR . '/includes/admin/mpwizard-actions-filters-load.php';

/**
 * Utility functions.
 */
require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-utilities.php';

/**
 * Assets load.
 */
require_once MPWIZARD_PLUGIN_DIR . '/includes/admin/mpwizard-assets-load.php';

/**
 * Mercado Pago functions.
 */
require_once MPWIZARD_PLUGIN_DIR . '/includes/admin/mpwizard-mercadopago-fb.php';

/**
 * Wordpress table class.
 */
if ( ! class_exists( 'WP_List_Table', false ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Plugin table class.
 */
require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/class-mpwizard-links-table.php';

/**
 * Plugin table class.
 */
require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/class-mpwizard-susplns-table.php';

/**
 * Other functions.
 */
require_once MPWIZARD_PLUGIN_DIR . 'includes/admin/mpwizard-functions.php';

/**********************************************************
 Translations
***********************************************************/

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 * 
 */

if ( !function_exists( 'mpwizard_load_textdomain' ) ) {
  function mpwizard_load_textdomain() {
    load_plugin_textdomain( 'mpwizard', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
  }
}

add_action( 'init', 'mpwizard_load_textdomain' );