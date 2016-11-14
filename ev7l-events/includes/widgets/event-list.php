<?php
/**
 * Event List Widget
 *
 * @package   EV7L_Events
 * @license   AGPL-3.0+
 */

class EventListWidget extends WP_Widget {

  // constructor
  public function __construct() {
    $details = array(
      'classname'   => 'EventListWidget',
      'description' => 'Show Events'
    );
    parent::__construct( 'EventListWidget', __('Event List Widget', 'ev7l-events'), $details );
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
    $events = upcoming_events();
    if ( $events->have_posts() ) {
      echo '<div class="widget widget_ev7l_event_list_widget">';
      echo '<ul class="ev7l_event_list">';
      $month = -1;
      $year = -1;
      foreach ( $events->get_posts() as $event ) {
        // New month?
        $start_month = date_i18n('F', get_post_meta($event->ID, 'fromdate', true));
        if ($month != $start_month) {
          $month = $start_month;
          echo '</ul>';
          echo '<h2 class="event-list-month-name">' . $month . '</h2>';
          echo '<ul class="ev7l_event_list">';
        }
        ?>
          <li>
            <span class="eventdate">
              <?php echo date_i18n('d.m', get_post_meta($event->ID, 'fromdate', true)); ?>
              <?php /* bis <?php echo date_i18n('d.m', get_post_meta($event->ID, 'todate', true)); */ ?>
            </span>
            <a href="<?php echo get_permalink($event->ID); ?>" class="event-list-link">
              <?php echo get_the_title($event->ID); ?>
            </a>
          </li>
       <?php
      }
      echo '</ul>';
      echo '</div>';
    } // if $events->have_posts()
  } // function widget
}

?>
