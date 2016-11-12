<?php
/**
 * Event Category Post Type
 *
 * @package   EV7L_Events
 * @license   AGPL-3.0+
 */

/**
 * Register post type.
 *
 * @package EV7L_Events
 */
class EV7L_Event_Category_Post_Type_Registrations {

	public $post_type = 'ev7l-event-category';

	public function init() {
		// Add the event-category  post type.
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type.
	 *
	 * @uses EV7L_Event_Category_Post_Type_Registrations::register_post_type()
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
			'name'               => __( 'Event Categories', 'ev7l-events' ),
			'singular_name'      => __( 'Event Category',   'ev7l-events' ),
			'add_new'            => __( 'Add Event Category',  'ev7l-events' ),
			'add_new_item'       => __( 'Add Event Category',  'ev7l-events' ),
			'edit_item'          => __( 'Edit Event Category', 'ev7l-events' ),
			'new_item'           => __( 'New Event Category',  'ev7l-events' ),
			'view_item'          => __( 'View Category', 'ev7l-events' ),
			'search_items'       => __( 'Search Event Category', 'ev7l-events' ),
			'not_found'          => __( 'No Event Category found', 'ev7l-events' ),
			'not_found_in_trash' => __( 'No Event Category in the trash', 'ev7l-events' ),
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
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'event-category', ), // Permalinks format
			'taxonomies'      => array( 'language' ), // language/polylang support
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-id',
		);

		$args = apply_filters( 'ev7l_event_category_post_type_args', $args );

		register_post_type( $this->post_type, $args );
	}

}
