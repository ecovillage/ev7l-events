<?php
/**
 * Event Category Post Type
 *
 * @package   EV7L_Events
 * @license   AGPL-3.0+
 */

/**
 * Register metaboxes.
 *
 * @package EV7L_Events
 */
class Event_Category_Post_Type_7L_Metaboxes {

	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'event_meta_boxes' ) );
		add_action( 'save_post',      array( $this, 'save_related_category_meta_boxes' ),  10, 2 );
	}

	/**
	 * Register the metaboxes to be used for pages post type
	 *
	 * @since 0.0.1
	 */
	public function event_meta_boxes() {
		add_meta_box(
			'event_categories_metabox',
      // TODO: i18n
			'Related Event Categories',
			array( $this, 'render_event_categories_meta_box'),
			'page',
			'normal',
			'high'
		);
	}

   /**
	* The HTML for the fields
	*
	* @since 0.0.1
	*/
  function render_event_categories_meta_box( $post ) {
    $selected_categories = get_post_meta( $post->ID, 'ev7l_related_event_categories', false );
    $all_categories = get_posts( array(
                                  'post_type'   => 'ev7l-event-category',
                                  'numberposts' => -1,
                                  'orderby'     => 'post_title',
                                  'order'       => 'ASC'
                                ) );

    wp_nonce_field( basename( __FILE__ ), 'ev7l_event_categories_field' ); ?>
       <table class="form-table">
         <tr valign="top">
           <td scope="row">
             <label for="ev7l_related_event_categories">Related Event Categories
               <?php echo $selected_categories; ?>
               </label>
           </td>
           <td>
            <p class="description"><?php _e( 'STRG/CTRL gedrückt halten für Mehrfachauswahl', 'ev7l-events' ); ?></p>
             <select multiple name="ev7l_related_event_categories[]">
             <?php foreach ( $all_categories as $category ) : ?>
               <option value="<?php echo $category->ID; ?>" <?php echo (in_array( $category->ID, $selected_categories)) ? ' selected="selected"' : ''; ?>>
                 <?php echo $category->post_title; ?>
               </option>
             <?php endforeach; ?>
             </select>
           </td>
         </tr>
       </table>
     <?php
  }

   /**
	* Save metaboxes
	*
	* @since 0.0.1
	*/
	function save_related_category_meta_boxes( $post_id ) {

		global $post;

		// Verify nonce
		if ( !isset( $_POST['ev7l_event_categories_field'] ) || !wp_verify_nonce( $_POST['ev7l_event_categories_field'], basename(__FILE__) ) ) {
			return $post_id;
    }

		// Check Autosave
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || ( defined('DOING_AJAX') && DOING_AJAX) || isset($_REQUEST['bulk_edit']) ) {
			return $post_id;
		}

		// Don't save if only a revision
		if ( isset( $post->post_type ) && $post->post_type == 'revision' ) {
			return $post_id;
		}

		// Check permissions
		if ( !current_user_can( 'edit_post', $post->ID ) ) {
			return $post_id;
    }

    // from: http://wordpress.stackexchange.com/questions/4694/how-to-make-multicheck-for-post-page-meta-box
    $old_selected_cats = get_post_meta($post_id, 'ev7l_related_event_categories', false);
    $new_selected_cats = $_POST['ev7l_related_event_categories'];
    if (empty($new_selected_cats)) {
      $new_selected_cats = array();
    }
    $to_adds    = array_diff( $new_selected_cats, $old_selected_cats);
    $to_deletes = array_diff( $old_selected_cats, $new_selected_cats);
    foreach ( $to_adds as $to_add ) {
      add_post_meta( $post_id, 'ev7l_related_event_categories', $to_add );
    }
    foreach ( $to_deletes as $to_delete ) {
      delete_post_meta( $post_id, 'ev7l_related_event_categories', $to_delete );
    }
  }

}
