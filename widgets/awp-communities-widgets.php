<?php
/**
 * Register Custom Widgets
 *
 * @package Winning Agent Pro / Widgets
 * @author  Carrie Dils
 * @license GPL-2.0+
 * @link    https://store.winningagent.com/themes/winning-agent-pro/
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'widgets_init', 'awp_register_widget' );
/**
* Register Genesis Featured Community widget.
*
* @since 1.0.0
*/
function awp_register_widget() {

	register_widget( 'AWP_Featured_Community' );

}

require 'featured-awp-communities-widget.php';