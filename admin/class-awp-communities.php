<?php
/**
 * This file contains the Community class.
 */

/**
 * This class handles the creation of the "Community" post type,
 * and creates a UI to display the Community-specific data on
 * the admin screens.
 */
class AWP_Communities {
    
    var $settings_page  = 'awp-settings';
    
    var $settings_field = 'awp_community_options';
    
    var $options;
    
    /**
     * Construct Method.
     */
    function __construct() {
        
        $this->options = get_option( 'plugin_awp_community_settings' );
        
        add_action( 'admin_init', array(&$this,
            'register_settings'
        ) );
        add_action( 'admin_init', array(&$this,
            'update_options'
        ) );
        add_action( 'admin_menu', array(&$this,
            'settings_init'
        ) , 15 );
    }
    
    function register_settings() {
        
        register_setting( 'awp_community_options', 'plugin_awp_community_settings', array(
            $this,
            'awp_sanitize_data'
        ) );
    }
    
    function awp_sanitize_data( $input ) {
        
        echo 'We are in the sanitize';
        var_dump( $input );
        
        if( !isset( $input['stylesheet_load'] ) || $input['stylesheet_load'] != '1' ) {
            $input['stylesheet_load'] = 0;
        } 
        else {
            $input['stylesheet_load'] = 1;
        }
        
        $input['slug'] = sanitize_title( $input['slug'] );
        
        return $input;
    }
    
    function update_options() {
        
        $new_options = array(
            'stylesheet_load' => 0,
            'slug' => 'communities'
        );
        
        if( empty( $this->options['stylesheet_load'] ) && empty( $this->options['slug'] ) ) {
            
            update_option( 'plugin_awp_community_settings', $new_options );
        }
    }
    
    /**
     * Adds settings page under Community post type in admin menu
     */
    function settings_init() {
        add_submenu_page( 'edit.php?post_type=awp-community', __( 'Settings', 'awp' ), __( 'Settings', 'awp' ), 'manage_options', $this->settings_page, array(&$this,
            'settings_page'
        ) );
    }
    
    /**
     * Creates display of settings page along with form fields
     */
    function settings_page() {
        include( dirname( __FILE__ ) . '/views/awp-settings.php' );
    }
}
?>
