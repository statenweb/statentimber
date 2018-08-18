<?php

namespace StatenTimber;

use StatenTimber\Base\Thing;

class Filters extends Thing {

    public function attach_hooks() {
        add_filter( 'timber_context', array( $this, 'timber_context' ) );
    }

    public function timber_context( $context ) {

        if ( is_front_page() ) {
            $context['is_front_page'] = true;
        }

        $context['main_menu']   = new \Timber\Menu( 'main' );
        $context['footer_menu'] = new \Timber\Menu( 'footer' );
        $context['subfooter'] = new \Timber\Menu( 'subfooter' );
        $context['contact_url'] = get_field( 'contact_page', 'options' ) ? get_permalink( get_field( 'contact_page',
            'options' ) ) : null;

        return $context;

    }

}