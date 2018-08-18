<?php

namespace StatenTimber\Data_Structures\Taxonomies\Page_Context;

class Taxonomy {

    const TAXONOMY = 'sw-page-context';
    protected static $post_types = [ 'page' ];
    protected static $types = [
        [ 'name' => 'Brown Text', 'slug' => 'brown-text' ],
        [ 'name' => 'Brown Background, White Text', 'slug' => 'brown-background-white-text' ],
        [ 'name' => 'White Background, Brown Text', 'slug' => 'white-background-brown-text' ],

    ];


    public function init() {
        $this->attach_hooks();
    }

    /**
     * Attach WordPress hooks
     */
    public function attach_hooks() {
        add_action( 'admin_init', array( $this, 'add_terms' ) );
        add_action( 'init', array( $this, 'register_taxonomy' ) );
        add_filter( 'timber_context', array( $this, 'timber_context' ) );

    }

    /**
     * Register taxonomy for pages
     */
    public function register_taxonomy() {
        $labels = array(
            'name'              => _x( 'Page Context', 'taxonomy general name' ),
            'singular_name'     => _x( 'Page Context', 'taxonomy singular name' ),
            'search_items'      => __( 'Search Page Contexts' ),
            'all_items'         => __( 'All Page Contexts' ),
            'parent_item'       => __( 'Parent Page Context' ),
            'parent_item_colon' => __( 'Parent Page Context:' ),
            'edit_item'         => __( 'Edit Page Context' ),
            'update_item'       => __( 'Update Page Context' ),
            'add_new_item'      => __( 'Add New Page Context' ),
            'new_item_name'     => __( 'New Page Context' ),
            'menu_name'         => __( 'Page Context' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => true,
            'capabilities'      => array(
                'manage_terms' => 'activate_plugins',
                'edit_terms'   => 'activate_plugins',
                'delete_terms' => 'activate_plugins',
                'assign_terms' => 'read'
            )
        );

        register_taxonomy( static::TAXONOMY, (array) static::$post_types, $args );
    }

    public function add_terms() {
        foreach ( self::$types as $term_args ) {
            $term = term_exists( $term_args['slug'], static::TAXONOMY );
            if ( ! $term ) {
                wp_insert_term( $term_args['name'], static::TAXONOMY,
                    array_merge( [ 'parent' => 0 ], $term_args ) );
            }
        }
    }

    public static function get_post_types() {
        return (array) self::$post_types;
    }

    public function timber_context( $context ) {

        if ( !is_admin() && is_page() ) {
            $slugs = (array)Helpers::get_page_context_slugs();


            $slugs = array_reduce($slugs, function($carry, $item){
                return $carry . ' ' . $item . ' ';
            }, '');
            $context['title_style'] = $slugs;
        }

        return $context;
    }

}