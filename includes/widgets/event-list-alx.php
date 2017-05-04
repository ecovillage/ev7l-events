<?php
/**
 * Event List Alx Widget
 *
 * @package   EV7L_Events
 * @license   AGPL-3.0+
 */

class EventListAlxWidget extends WP_Widget {

  // constructor
  public function __construct() {
    $details = array(
      'classname'   => 'EventListAlxWidget',
      'description' => 'Show Events (Alx style)'
    );
    parent::__construct( 'EventListAlxWidget', __('Event List Alx Widget', 'ev7l-events'), $details );
  }

  // Widget backend form creation
  public function form($instance) {
    /* Not needed. */
    echo 'displays events';
  }

  // Widget ("settings") update
  function update($new_instance, $old_instance) {
    return $new_instance;
  }

  // Widget display
  function widget($args, $instance) {
    // Check for related categories,
    // "ev7l_related_event_categories" (from posts metabox)
    global $wp_query;
    if (is_object($wp_query->queried_object) && $wp_query->get_queried_object_id()) {
      $related_categories = get_post_meta($wp_query->queried_object->ID, 'ev7l_related_event_categories', false);
      //echo "<div>";
      //echo var_export($related_categories);
      //echo "</div>";
      // query via array IN http://wordpress.stackexchange.com/questions/55354/how-can-i-create-a-meta-query-with-an-array-as-meta-field
      $events = upcoming_events_in_categories($related_categories);
    }
    else {
      // No related categories
      $events = upcoming_events();
    }

    if ( $events->have_posts() ) {
      echo '<div class="widget widget_ev7l_event_list_widget">';
      // move separate uls into loop
      echo '<h4>Folgende Veranstaltungen könnten Dich vielleicht interessieren:</h4>';
      echo '<ul class="ev7l_event_list alx-posts group thumbs-enabled">';
      $month = -1;
      $year = -1;
      global $post;
      while ( $events->have_posts() ) {
        $events->the_post();
        // New month?
        $start_month = date_i18n('F', get_post_meta($post->ID, 'fromdate', true));
        if ($month != $start_month) {
          $month = $start_month;
          echo '</ul>';
          echo '<h2 class="event-list-month-name">' . $month . '</h2>';
          echo '<ul class="ev7l_event_list alx-posts group thumbs-enabled">';
        }
        ?>
          <li>
            <div class="post-item-thumbnail">
              <a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo get_the_title($post->ID); ?>">
              <?php hu_the_post_thumbnail('thumb-medium'); ?>
            </div>
            <div class="post-item-inner group">
              <p class="post-item-category"><a href="" rel="category tag">Veranstaltung</a>
              </p>
              <p class="post-item-title">
                <a href="<?php echo get_permalink($post->ID); ?>" rel="bookmark" title="<?php echo get_the_title($post->ID); ?>"><?php echo get_the_title($post->ID); ?></a>
              </p>
              <p class="post-item-date">
                <?php echo date_i18n('D, d.m', get_post_meta($post->ID, 'fromdate', true)); ?>
                -
                <?php echo date_i18n('D, d.m.Y', get_post_meta($post->ID, 'todate', true)); ?>
              </p>
            </div>
          </li>
       <?php
      } // while $events->have_posts()
      echo '</ul>';
      echo '<div>... und viele weitere Veranstaltungen.</div>';
      echo '</div>';

      wp_reset_postdata();
    } // if $events->have_posts()
  } // function widget
}

?>
