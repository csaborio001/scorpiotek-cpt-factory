<?php

namespace ScorpioTek\WordPress\Util\CPT;

class ContentType {
    private $type;
    private $options = array();
    private $labels = array();

    public function __construct( $type, $options = array(), $labels = array() ) {
        $this->type = $type;

        // Set the default options for the type
        $default_options = array(
            'public' => true,
            'supports' => array('title', 'editor', 'revisions', 'thumbnail'),
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
            )
        );

        $this->options = $options + $default_options;

        $required_labels = array(
            'singular_name' => ucwords( $this->type ),
            'plural_name' => ucwords ( $this->type )
        );
        
        $this->labels = $labels + $required_labels;
        $this->options['labels'] = $this->labels + $this->default_labels();

        add_action( 'init', array( $this, 'register') );

    }

    public function register() {
        register_post_type( $this->type, $this->options );
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

    public static function get() {
        echo 'get';
    }
}