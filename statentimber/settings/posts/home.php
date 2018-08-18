<?php

namespace StatenTimber\Settings\Posts;

use StatenTimber\Base\Thing;

class Home extends Thing {

    public function attach_hooks() {
        add_action( 'admin_init', array( $this, 'hide_editor' ) );
    }

    public function hide_editor() {

        if ( ! array_key_exists( 'post', $_GET ) && ! array_key_exists( 'post_ID', $_GET ) ) {
            return;
        }

        $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
        if ( ! isset( $post_id ) || ! $post_id || $post_id !== get_option( 'page_on_front' ) ) {
            return;
        }

        remove_post_type_support( 'page', 'editor' );
        remove_post_type_support( 'page', 'thumbnail' );

    }


}