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
      'classname' => 'EventListWidget',
      'description' => 'Show Events'
    );
    parent::__construct( 'EventListWidget', __('Event List Widget', 'ev7l-events'), $details );
    //parent::__construct( 'EventListWidget', 'Event List Widget', $details );
  }

  // Widget backend form creation
  public function form($instance) {
    /* Not needed. */
    echo 'displays events';
  }

  // widget update
  function update($new_instance, $old_instance) {
    return $new_instance;
  }

  function widget($args, $instance) {
    $events = upcoming_events();
    if ( $events->have_posts() ) {
      echo '<ul>';
      $month = -1;
      $year = -1;
      foreach ( $events->get_posts() as $event ) {
        // New month?
        $start_month = date_i18n('F', get_post_meta($event->ID, 'fromdate', true));
        if ($month != $start_month) {
          echo '<h2>' . $start_month . '</h2>';
          $month = $start_month;
        }
        ?>
          <li>
            <?php echo date('d.m', get_post_meta($event->ID, 'fromdate', true)); ?> bis <?php echo date('d.m', get_post_meta($event->ID, 'todate', true)); ?>
              <a href="<?php echo get_permalink($event->ID); ?>"> <?php echo get_the_title($event->ID); ?></a>
          </li>
       <?php
      }
      echo '</ul>';
    }

  }
}

?>
