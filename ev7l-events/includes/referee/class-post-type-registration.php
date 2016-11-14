<?php
/**
 * Referee Post Type
 *
 * @package   EV7L_Events
 * @license   AGPL-3.0+
 */

/**
 * Register post type.
 *
 * @package EV7L_Events
 */
class EV7L_Referee_Post_Type_Registration {

	public $post_type = 'ev7l-referee';

	public function init() {
		// Add the event-category  post type.
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type.
	 *
	 * @uses EV7L_Referee_Post_Type_Registrations::register_post_type()
	 */
	public function register() {
		$this->register_post_type();
	}

	/**
	 * Register the custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'Referees',     'ev7l-events' ),
			'singular_name'      => __( 'Referee',      'ev7l-events' ),
			'add_new'            => __( 'Add Referee',  'ev7l-events' ),
			'add_new_item'       => __( 'Add Referee',  'ev7l-events' ),
			'edit_item'          => __( 'Edit Referee', 'ev7l-events' ),
			'new_item'           => __( 'New Referee',  'ev7l-events' ),
			'view_item'          => __( 'View Referee', 'ev7l-events' ),
			'search_items'       => __( 'Search Referee', 'ev7l-events' ),
			'not_found'          => __( 'No Referee found', 'ev7l-events' ),
			'not_found_in_trash' => __( 'No Referee in the trash', 'ev7l-events' ),
		);

		$supports = array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields',
			'revisions',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'has_archive'     => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'referee', ), // Permalinks format
			'taxonomies'      => array( 'language' ), // language/polylang support
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-id',
		);

		$args = apply_filters( 'ev7l_referee_post_type_args', $args );

		register_post_type( $this->post_type, $args );
	}

}
