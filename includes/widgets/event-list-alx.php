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
    if (is_object($wp_query->queried_object) && $wp_query->get_queried_object_id) {
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
              <!--svg class="hu-svg-placeholder thumb-medium-empty" id="58af4916a9b78" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg" style="opacity: 0.3;"><path d="M928 832q0-14-9-23t-23-9q-66 0-113 47t-47 113q0 14 9 23t23 9 23-9 9-23q0-40 28-68t68-28q14 0 23-9t9-23zm224 130q0 106-75 181t-181 75-181-75-75-181 75-181 181-75 181 75 75 181zm-1024 574h1536v-128h-1536v128zm1152-574q0-159-112.5-271.5t-271.5-112.5-271.5 112.5-112.5 271.5 112.5 271.5 271.5 112.5 271.5-112.5 112.5-271.5zm-1024-642h384v-128h-384v128zm-128 192h1536v-256h-828l-64 128h-644v128zm1664-256v1280q0 53-37.5 90.5t-90.5 37.5h-1536q-53 0-90.5-37.5t-37.5-90.5v-1280q0-53 37.5-90.5t90.5-37.5h1536q53 0 90.5 37.5t37.5 90.5z" style="stroke-dasharray: 18959, 18961; stroke-dashoffset: 0;"></path></svg>

              <script type="text/javascript">
                jQuery( function($){
                  if ( $('#flexslider-featured').length ) {
                    $('#flexslider-featured').on('featured-slider-ready', function() {
                      $( '#58af4916a9b78' ).animateSvg();
                    });
                  } else { $( '#58af4916a9b78' ).animateSvg( { svg_opacity : 0.3, filter_opacity : 0.5 } ); }
                });
              </script-->
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
      echo '</div>';

      wp_reset_postdata();
    } // if $events->have_posts()
  } // function widget
}

?>
