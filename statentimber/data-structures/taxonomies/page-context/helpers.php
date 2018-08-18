<?php

namespace StatenTimber\Data_Structures\Taxonomies\Page_Context;

class Helpers {

    public static function get_page_context_string( $prefix = '', $implode_character = ';' ) {
        $page_context_terms = self::get_page_context_slugs();
        if ( ! $page_context_terms ) {
            return null;
        }

        if ( $prefix ) {
            $page_context_terms = array_map( function ( $element ) use ( $prefix ) {
                return $prefix . $element;
            }, $page_context_terms );
        }

        $page_context_terms_output = implode( $implode_character, $page_context_terms );

        return $page_context_terms_output;
    }

    public static function get_page_context_slugs( $id = false ) {

        if ( ! $id ) {
            // the special case is is_home() which if we are on that page get_the_ID() would return the last post id
            $id = is_home() ? get_option( 'page_for_posts' ) : get_the_ID();
        }
        if ( ! in_array( get_post_type( $id ), Taxonomy::get_post_types() ) ) {
            return false;
        }

        return wp_get_object_terms( $id, Taxonomy::TAXONOMY,
            array( 'fields' => 'slugs' ) );
    }

    public static function has_context( $context, $id = false ) {

        $contexts = self::get_page_context_slugs( $id );
        if ( in_array( $context, (array) $contexts ) ) {
            return true;
        }

        return false;


    }

}