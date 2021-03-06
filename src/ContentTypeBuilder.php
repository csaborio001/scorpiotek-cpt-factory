<?php

namespace ScorpioTek\WordPress;

class ContentTypeBuilder {
    private $type;
    private $options = array();
    private $labels = array();

    public function __construct( $type, $options = array(), $labels = array() ) {
        $this->type = $type;

        // Set the default options for the type.
        $default_options = array(
            'public' => true,
            'supports' => array( 'title' ),
            'capability_type' => array($labels['singular_name'], $labels['plural_name']),
            'capabilities' => array(
				'publish_posts' => 'publish_' .$this->type,
				'edit_posts' => 'edit_' .$this->type,
				'edit_others_posts' => 'edit_others_' .$this->type,
				'edit_published_posts' => 'edit_published_' .$this->type,
				'delete_posts' => 'delete_' .$this->type,
				'delete_others_posts' => 'delete_others_' .$this->type,
				'read_private_posts' => 'read_private_' .$this->type,
				'edit_post' => 'edit_' .$this->type,
				'delete_post' => 'delete_' .$this->type,
				'read_post' => 'read_' .$this->type
            ),
            // 'map_meta_cap' => true,
        );

        // $capabilities = $default_options['capabilities'];
        // $admin_role = get_role( 'administrator' );
        // foreach ( $capabilities as $capabilities => $capability_name ) {
        //     $admin_role->remove_cap( $capability_name );
        // }



        // Merge the default options with the custom options
        $this->options = $options + $default_options;

        $required_labels = array(
            'singular_name' => ucwords( $this->type ),
            'plural_name' => ucwords ( $this->type )
        );
        
        // Required labels will only take effect if $labels is not defined, otherwise they overwrite it in this merge.
        $this->labels = $labels + $required_labels;
        $this->options['labels'] = $this->labels + $this->default_labels();

        add_action( 'init', array( $this, 'register') );

    }

    public function register() {
        register_post_type( $this->type, $this->options );
        $capabilities = $this->options['capabilities'];
        $admin_role = get_role( 'administrator' );
        $editor_role = get_role( 'editor' );
        foreach ( $capabilities as $capabilities => $capability_name ) {
            $admin_role->add_cap( $capability_name );
            // $editor_role->add_cap( $capability_name );
        }
    }

    public function default_labels() {
        return array(
            'name' => $this->labels['plural_name'],
            'singular_name' => $this->labels['singular_name'],
            'add_new'=> __('Add New ' ) . $this->labels['singular_name'],
            'add_new_item' => __('Add New ') . $this->labels['singular_name'],
            'edit' => __('Edit'),
            'edit_item' => __('Edit ') , $this->labels['singular_name'],
            'new_item' => __('New ') . $this->labels['singular_name'],
            'view' => __('View ') . $this->labels['singular_name'] . __(' Page'),
            'view_item' => __('View ') . $this->labels['singular_name'],
            'search_items' => __('Search ') . $this->labels['plural_name'],
            'not_found' => __('No matching ' . strtolower( $this->labels['plural_name'] ) . ' found'),
            'not_found_in_trash' => __('No ' . strtolower( $this->labels['plural_name'] ) . ' found in Trash'),
            'parent_item_colon' => 'Parent ' . $this->labels['singular_name']
        );
    }

}