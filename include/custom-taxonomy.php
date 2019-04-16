<?php

namespace ScorpioTek\WordPress\Util\CPT;

class CustomTaxonomy {
    private $taxonomy_name;
    private $content_type;
    private $options = array();
    private $labels = array();

    public function __construct( $taxonomy_name, $content_type, $options = array(), $labels = array() ) {
        $this->taxonomy_name = $taxonomy_name;
        $this->content_type = $content_type;

       // Merge the default options with the custom options
       $this->options = $options + $this->get_default_options();

       $required_labels = array(
           'singular_name' => ucwords( $this->get_content_type() ),
           'plural_name' => ucwords ( $this->get_content_type() ) . 's',
       );
       
       // Required labels will only take effect if $labels is not defined, otherwise they overwrite it in this merge.
       $this->labels = $labels + $required_labels;
       $this->options['labels'] = $this->labels + $this->get_default_labels( $labels['singular_name'], $labels['plural_name'] );        

        add_action( 'init', array( $this, 'register' ) );
        add_filter( 'term_updated_messages', array( $this, 'category_updated_messages' ) );

    }

    public function register() {
        register_taxonomy( $this->get_taxonomy_name(), array( $this->get_content_type() ), $this->get_options() ) ;
    }

    function category_updated_messages( $messages ) {
        $messages[$this->get_content_type()] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => __( $this->get_content_type() . 's category added.', 'scorpiotek_cpt_factory' ),
            2 => __( $this->get_content_type() . 's category deleted.', 'scorpiotek_cpt_factory' ),
            3 => __( $this->get_content_type() . 's category updated.', 'scorpiotek_cpt_factory' ),
            4 => __( $this->get_content_type() . 's category not added.', 'scorpiotek_cpt_factory' ),
            5 => __( $this->get_content_type() . 's category not updated.', 'scorpiotek_cpt_factory' ),
            6 => __( $this->get_content_type() . 's categories deleted.', 'scorpiotek_cpt_factory' ),
        );
    
        return $messages;
    }    

    private function get_default_options() {
        $default_options =          array(
        'hierarchical'              => false,
        'public'                    => true,
        'show_in_nav_menus'         => true,
        'show_ui'                   => true,
        'show_admin_column'         =>  false,
        'query_var'                 => true,
        'rewrite'                   => true,
        'capabilities'              => array(
            'manage_terms'          => 'edit_posts',
            'edit_terms'            => 'edit_posts',
            'delete_terms'          => 'edit_posts',
            'assign_terms'          => 'edit_posts',
        ),
		'show_in_rest'              => true,
		'rest_base'                 => $this->get_content_type(),
		'rest_controller_class'     => 'WP_REST_Terms_Controller',
        );
        return $default_options;
    }
    private function get_default_labels( $singular_name, $plural_name ) {
    		$labels =                    array(
			'name'                       => __( $plural_name , 'scorpiotek_cpt_factory' ),
			'singular_name'              => _x( $plural_name , 'taxonomy general name', 'scorpiotek_cpt_factory' ),
			'search_items'               => __( 'Search ' . strtolower ( $plural_name ) , 'scorpiotek_cpt_factory' ),
			'popular_items'              => __( 'Popular ' . strtolower ( $plural_name ) , 'scorpiotek_cpt_factory' ),
			'all_items'                  => __( 'All '. strtolower ( $plural_name ) , 'scorpiotek_cpt_factory' ),
			'parent_item'                => __( 'Parent ' . strtolower ( $plural_name ) , 'scorpiotek_cpt_factory' ),
			'parent_item_colon'          => __( 'Parent ' . strtolower ( $plural_name ) .  ' category:', 'scorpiotek_cpt_factory' ),
			'edit_item'                  => __( 'Edit ' . strtolower ( $plural_name ) , 'scorpiotek_cpt_factory' ),
			'update_item'                => __( 'Update ' . strtolower ( $plural_name ) , 'scorpiotek_cpt_factory' ),
			'view_item'                  => __( 'View ' . strtolower ( $plural_name ) , 'scorpiotek_cpt_factory' ),
			'add_new_item'               => __( 'New ' . strtolower ( $plural_name ) , 'scorpiotek_cpt_factory' ),
			'new_item_name'              => __( 'New ' . strtolower ( $plural_name ) , 'scorpiotek_cpt_factory' ),
			'separate_items_with_commas' => __( 'Separate ' . strtolower ( $plural_name ) .  ' with commas', 'scorpiotek_cpt_factory' ),
			'add_or_remove_items'        => __( 'Add or remove ' . strtolower ( $plural_name ), 'scorpiotek_cpt_factory' ),
			'choose_from_most_used'      => __( 'Choose from the most used ' . strtolower ( $plural_name ), 'scorpiotek_cpt_factory' ),
			'not_found'                  => __( 'No ' . strtolower ( $plural_name ) . ' found.', 'scorpiotek_cpt_factory' ),
			'no_terms'                   => __( 'No ' . strtolower ( $plural_name ), 'scorpiotek_cpt_factory' ),
			'menu_name'                  => __( $plural_name, 'scorpiotek_cpt_factory' ),
			'items_list_navigation'      => __( $plural_name . '  list navigation', 'scorpiotek_cpt_factory' ),
			'items_list'                 => __( $plural_name . '  list', 'scorpiotek_cpt_factory' ),
			'most_used'                  => _x( 'Most Used', $this->get_content_type(), 'scorpiotek_cpt_factory' ),
			'back_to_items'              => __( '&larr; Back to ' . strtolower ( $plural_name ), 'scorpiotek_cpt_factory' ),
            );
            return $labels;
    }

    /**
     * Setter for taxonomy_name
     *
     * @param string $taxonomy_name the new value of the taxonomy_name property.
     */
    public function set_taxonomy_name( $taxonomy_name ) {
        $this->taxonomy_name = $taxonomy_name;
    }
    /**
     * Getter for the taxonomy_name property.
     */
    public function get_taxonomy_name() {
        return $this->taxonomy_name;
    }

    /**
     * Setter for content_type
     *
     * @param string $content_type the new value of the content_type property.
     */
    public function set_content_type( $content_type ) {
        $this->content_type = $content_type;
    }
    /**
     * Getter for the content_type property.
     */
    public function get_content_type() {
        return $this->content_type;
    }

    /**
     * Setter for options
     *
     * @param string $options the new value of the options property.
     */
    public function set_options( $options ) {
        $this->options = $options;
    }
    /**
     * Getter for the options property.
     */
    public function get_options() {
        return $this->options;
    }

    /**
     * Setter for labels
     *
     * @param string $labels the new value of the labels property.
     */
    public function set_labels( $labels ) {
        $this->labels = $labels;
    }
    /**
     * Getter for the labels property.
     */
    public function get_labels() {
        return $this->labels;
    }

}