<?php

use StatenTimber\Actions;
use StatenTimber\Data_Structures\Taxonomies\Page_Context\Taxonomy;
use StatenTimber\Settings\Posts\Home;
use StatenTimber\Settings\Site;
use StatenTimber\Twig\Filters;

$namespace = 'StatenTimber';

spl_autoload_register( function ( $class ) use ( $namespace ) {
    $base = explode( '\\', $class );
    if ( $namespace === $base[0] ) {
        $file = __DIR__ . DIRECTORY_SEPARATOR . strtolower( str_replace( [ '\\', '_' ], [
                    DIRECTORY_SEPARATOR,
                    '-',
                ], $class ) . '.php' );
        if ( file_exists( $file ) ) {
            require $file;
        } else {
            wp_die( sprintf( 'File %s not found', esc_html( $file ) ) );
        }
    }

} );

$actions = new Actions();
$actions->init();
$filters = new \StatenTimber\Filters();
$filters->init();
$site_settings = new Site();
$site_settings->init();
$twig_filters = new Filters();
$twig_filters->init();
$home_settings = new Home();
$home_settings->init();
$page_context = new Taxonomy();
$page_context->init();