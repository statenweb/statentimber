<?php

namespace StatenTimber;


use StatenTimber\Base\Thing;

class Actions extends Thing {

    public function attach_hooks() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 999 );
        add_action( 'after_setup_theme', array( $this, 'register_menus' ) );
        add_action( 'wp_head', array( $this, 'head_script' ) );
    }

    public function enqueue() {

        wp_enqueue_style( 'statenweb-webpack', get_stylesheet_directory_uri() . '/dist/css/main.css', [],
            defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : '20171002' );
        wp_enqueue_script( 'statenweb-webpack', get_stylesheet_directory_uri() . '/dist/js/bundle.js', [ 'jquery' ],
            '20171001' );
    }

    public function register_menus() {
        register_nav_menus( array(
            'main'      => 'Main',
            'footer'    => 'Footer',
            'subfooter' => 'Subfooter',

        ) );

    }

    public function head_script() {
        ?>

		<script>
          window.FontAwesomeConfig = {
            searchPseudoElements: true,
          };
		</script>
        <?php
    }

}