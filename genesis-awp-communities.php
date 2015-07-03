<?php
/**
 * Genesis AWP Communities Plugin
 *
 * Read more about why we created this plugin at http://savvyjackiedesigns.com/genesis-site-title-styles-plugin/
 *
 * @package           Genesis_AWP_Communities
 * @author            Jackie D'Elia
 * @license           GPL-2.0+
 * @link              http://www.savvyjackiedesigns.com
 * @copyright         2015 Jackie D'Elia
 *
 * Plugin Name:       Genesis AWP Communities
 * Plugin URI:        
 * Description:       Adds a custom post type for Communities to Genesis Child Theme. Includes Featured Communities Widget, Custom Archive Page and ability to edit slug name.
 * Version:           0.2.0
 * Author:            Jackie D'Elia
 * Author URI:        http://www.savvyjackiedesigns.com
 * Text Domain:       genesis-awp-community
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 * GitHub Plugin URI: 
 * GitHub Branch:     master
 */

/*  
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
* Defining Genesis Community constants
 *
 * @since 0.2.0
 */

define( 'GENAWPCOMM_VERSION','0.2.0' );

if ( ! defined( 'GENAWPCOMM_BASE_FILE' ) )
    define( 'GENAWPCOMM_BASE_FILE', __FILE__ );
if ( ! defined( 'GENAWPCOMM_BASE_DIR' ) )
    define( 'GENAWPCOMM_BASE_DIR', dirname( GENAWPCOMM_BASE_FILE ) );
if ( ! defined( 'GENAWPCOMM_PLUGIN_URL' ) )
    define( 'GENAWPCOMM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
if ( ! defined( 'GENAWPCOMM_PLUGIN_PATH' ) )
    define( 'GENAWPCOMM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

define( 'GENAWPCOMM_SETTINGS_FIELD', 'genawpcomm-settings' );

/**
 * The text domain for the plugin
 *
 * @since 0.2.0
 */
define( 'GENAWPCOMM_DOMAIN' , 'genesis-awp-communities' );

/**
 * Load the text domain for translation of the plugin
 *
 * @since 0.2.0
 */
load_plugin_textdomain( 'genesis-awp-communities', false, 'genesis-awp-communities/languages' );

register_activation_hook( __FILE__, 'genawpcomm_activation_check' );

/**
 * Checks for activated Genesis Framework and its minimum version before allowing plugin to activate
 *
 * @author Nathan Rice, Remkus de Vries, Rian Rietveld, adjusted Jackie D'Elia for this plugin
 * @uses genawpcomm_activation_check()
 * @since 0.2.0
 */
function genawpcomm_activation_check() {

    // Find Genesis Theme Data
    $theme = wp_get_theme( 'genesis' );

    // Get the version
    $version = $theme->get( 'Version' );

    // Set what we consider the minimum Genesis version
    $minimum_genesis_version = '2.1.2';

    // Restrict activation to only when the Genesis Framework is activated
    if ( basename( get_template_directory() ) != 'genesis' ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );  // Deactivate ourself
        wp_die( sprintf( __( 'Whoa.. this plugin requires that you have installed the %1$sGenesis Framework version %2$s%3$s or greater.', GENAWPCOMM_DOMAIN ), '<a href="http://savvyjackiedesigns.com/go/genesis-framework-theme">', '</a>', $minimum_genesis_version ) );
    }

    // Set a minimum version of the Genesis Framework to be activated on
    if ( version_compare( $version, $minimum_genesis_version, '<' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );  // Deactivate ourself
        wp_die( sprintf( __( 'Oops.. you need to update to the latest version of the %1$sGenesis Framework version %2$s%3$s or greater to install this plugin.', GENAWPCOMM_DOMAIN ), '<a href="http://savvyjackiedesigns.com/go/genesis-framework-theme">', '</a>', $minimum_genesis_version ) );
    }

}

// Add custom image sizes if they don't exist
if ( !has_image_size( 'awp-feature-community' ) ) {
  add_image_size( 'awp-feature-community', 440, 300, true );
}
if ( !has_image_size( 'awp-feature-small' ) ) {
  add_image_size( 'awp-feature-small', 340, 140, true );
}
if ( !has_image_size( 'awp-feature-wide' ) ) {
  add_image_size( 'awp-feature-wide', 740, 285, true );
}

add_image_size( 'awp-feature-wide', 740, 285, true );
add_image_size( 'awp-feature-wide', 740, 285, true );

// Show the custom sizes when choosing image size in media
add_filter( 'image_size_names_choose', 'my_custom_sizes' );
function my_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
            'awp-feature-community' => __( 'awp-feature-community' ), 
            'awp-feature-small' => __( 'awp-feature-small' ), 
            'awp-feature-wide' => __( 'awp-feature-wide' )
        ) );
}


//require_once( dirname(__FILE__) . '/post-types.php' );
require_once( dirname(__FILE__) . '/widgets/awp-communities-widgets.php' );
require_once( dirname(__FILE__) . '/class-awp-communities.php' );

/** Instantiate */
    $_awp_community = new AWP_Community;

?>
