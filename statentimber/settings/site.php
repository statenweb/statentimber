<?php

namespace StatenTimber\Settings;

use StatenTimber\Base\Thing;

class Site extends Thing {


    public function attach_hooks() {

        add_action( 'init', array( $this, 'add_settings_page' ) );
        add_filter( 'timber_context', array( $this, 'timber_context' ) );
    }

    public function add_settings_page() {

        if ( function_exists( 'acf_add_options_sub_page' ) ) {
            acf_add_options_sub_page( array(
                'page_title'  => 'Site Options',
                'menu_title'  => 'Site Options',
                'menu_slug'   => 'statenweb_settings',
                'capability'  => 'edit_users',
                'parent_slug' => 'options-general.php'
            ) );
        }
    }

    public static function get( $key ) {

        if ( ! function_exists( 'get_field' ) ) {
            return;
        }

        return get_field( $key, 'option' );
    }

    public function timber_context( $context ) {

        $context['options'] = get_fields( 'option' );

        return $context;
    }
}
