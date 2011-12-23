<?php

$wordpress_events = new wordpress_events;

class wordpress_events {

	function wordpress_events(){
	
		$this->__construct();
		
	} // function
	
	function __construct(){
	
		add_action("admin_init", array( &$this, 'admin_js_libs' ));
		
		add_action("admin_print_styles", array( &$this, 'style_libs' ));
		
		add_action("wp_print_styles", array( &$this, 'style_libs_front' ));
		
		add_action("wp_enqueue_scripts", array( &$this, 'front_js_libs' ));
					
		add_action( 'init', array( &$this, 'add_custom_post_type' ) );
		
		add_action( 'admin_init', array( &$this, 'add_meta_boxes' ) );
		
		add_action( 'save_post', array( &$this, 'save_meta_box_data' ), 1, 2 );
		
		add_shortcode( 'calendar' , array( &$this, 'display_calendar' ) );
	
	}
	
	function admin_js_libs(){
	
		wp_enqueue_script('jquery');
	
		wp_enqueue_script('jquery-ui-1.8.16.custom.min', WPE_url . '/js/jquery-ui-1.8.16.custom.min.js', array('jquery-ui-core'), 1.0 );
		
		wp_enqueue_script('timepicker', WPE_url . '/js/jquery-ui-timepicker-addon.js', array('jquery-ui-1.8.16.custom.min'), 1.0 );
	
	}
	
	function style_libs(){
	
		wp_enqueue_style('jquery.ui.theme', WPE_url . '/js/ui-lightness/jquery-ui-1.8.16.custom.css');
	
	}
	
	function style_libs_front(){
		
		wp_enqueue_style('thickbox');
		
		wp_enqueue_style('wpe', WPE_url . '/css/wpe.css');
	
	}
	
	function front_js_libs(){
	
		wp_enqueue_script( 'thickbox' );
	
	}
	
	function add_custom_post_type() {
	
		$labels = array(
			'name' => _x('Events', 'post type general name'),
			'singular_name' => _x('Event', 'post type singular name'),
			'add_new' => _x('Add New Event', 'Testimonial'),
			'add_new_item' => __('Add New Event'),
			'edit_item' => __('Edit Event'),
			'new_item' => __('New Event'),
			'view_item' => __('View Event'),
			'search_items' => __('Search Event'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
		
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'menu_icon' => WPE_url . '/img/events.png',
			'rewrite' => true,
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title', 'editor')
		); 
		
		register_post_type('events',$args);
	
	}
	
	function add_meta_boxes() {
	
		add_meta_box( 
	        'events_details',
	        'Event details',
	        array( &$this, 'events_details'),
	        'events',
	        'normal',
	        'core'
	    );
	
	}
	
	function events_details(){
	
		global $post;
	
		wp_nonce_field( plugin_basename( __FILE__ ), 'events_nonce' );
		
		?>
		
	  <script>
	 	jQuery(document).ready(function() {
	    	jQuery(".datepicker").datetimepicker({
				timeFormat: 'h:mm',
				separator: ' @ ',
				dateFormat: 'dd-mm-yy'
			});
	  	});
	  </script>

		<table class="form-table">
			<tbody>
			
				<tr valign="top">
					<th scope="row">
						<label for="venue_name">Venue name</label>
					</th>
					<td>
						<input type="text" id="events_venu_name" name="events_venue_name" value="<?php echo get_post_meta($post->ID,'events_venue_name',true); ?>" size="25" />
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">
						<label for="venue_location">Venue Address</label>
					</th>
					<td>
						
						<textarea cols="100" rows="10" name="venue_location_address" id="venue_location_address"><?php echo get_post_meta($post->ID,'venue_location_address',true); ?></textarea>
				
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">
						<label for="date">Date and time</label>
					</th>
					<td>
						<input class="datepicker" type="text" id="events_date" name="events_date" value="<?php echo get_post_meta($post->ID,'events_date',true); ?>" size="25" />
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">
						<label for="tickets">Tickets URL</label>
					</th>
					<td>
						<input type="text" id="events_tickets" name="events_tickets" value="<?php echo get_post_meta($post->ID,'events_tickets',true); ?>" size="50" />
					</td>
				</tr>				
				
			</tbody>
		</table>
		
		<?php
	
	}
	
	function save_meta_box_data($post_id){
	
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return;
			
		if(isset($_POST['events_venue_name'])){
		
			if ( !wp_verify_nonce( $_POST['events_nonce'], plugin_basename( __FILE__ ) ) )
		  		return;
		  		
		  	update_post_meta($post_id, 'venue_location_address', $_POST['venue_location_address']);
		  			  	
		  	update_post_meta($post_id, 'events_date', $_POST['events_date']);
		  	
		  	update_post_meta($post_id, 'events_tickets', $_POST['events_tickets']);
		  	
		  	update_post_meta($post_id, 'events_venue_name', $_POST['events_venue_name']);
		  	
		}
	
	}
	
	function display_calendar($atts){ 
	
		if(isset($_GET['m'])){
			$month = intval($_GET['m']);
		}else{
			$month = date("m");
		}
		
		if(isset($_GET['y'])){
			$year = intval($_GET['y']);
		}else{
			$year = date("Y");
		} ?>
	
		<span class="events_date_now"><?php echo date("F Y",strtotime($year."-".$month."-01")); ?></span>
	
		<span class="float-left calendar_nav"><a href="<?php echo the_permalink(); ?><?php echo date('&\m=m&\y=Y',strtotime($year."-".$month."-01 -1 months")); ?>"><< <?php echo date("F Y",strtotime($year."-".$month."-01 -1 months")); ?></a></span>
		
		<span class="float-right calendar_nav"><a href="<?php echo the_permalink(); ?><?php echo date('&\m=m&\y=Y',strtotime($year."-".$month."-01 +1 months")); ?>"><?php echo date("F Y",strtotime($year."-".$month."-01 +1 months")) ?> >></a></span>
		
		<br style="clear:both;">

		<?php 
		
		/* draw table */
		$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
		
		/* table headings */
		$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
		$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
		
		/* days and weeks vars now ... */
		$running_day = date('w',mktime(0,0,0,$month,1,$year));
		$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		$days_in_this_week = 1;
		$day_counter = 0;
		$dates_array = array();
		
		/* row for week one */
		$calendar.= '<tr class="calendar-row">';
		
		/* print "blank" days until the first of the current week */
		for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		$days_in_this_week++;
		endfor;
		
		/* keep going with days.... */
		for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day" valign="top">';
		  /* add in the day number */
		  $calendar.= '<div class="day-number">'.$list_day.'</div>';
				  
		global $post, $wpdb; 
					
		$querystr = "
		SELECT $wpdb->posts.* , $wpdb->postmeta.* 
		FROM $wpdb->posts, $wpdb->postmeta
		WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
		AND $wpdb->postmeta.meta_key = 'events_date' 
		AND $wpdb->posts.post_status = 'publish' 
		AND $wpdb->posts.post_type = 'events' 
		AND STR_TO_DATE($wpdb->postmeta.meta_value ,'%d-%m-%Y @ %H:%i') >= STR_TO_DATE('" .$year."-".$month."-".$list_day."-00-00', '%Y-%m-%d-%H-%i' )
		AND STR_TO_DATE($wpdb->postmeta.meta_value ,'%d-%m-%Y @ %H:%i') <= STR_TO_DATE('" .$year."-".$month."-".$list_day."-23-59', '%Y-%m-%d-%H-%i' )
		";
		
		//echo $querystr.'<br><br>';
		
		$pageposts = $wpdb->get_results($querystr, OBJECT);
		
		global $post;
		
		if ($pageposts){
		
			foreach ($pageposts as $post){ 
			
				setup_postdata($post); 
									
				$calendar.= '<span class="float-left">
				
					<div id="' . str_replace(' ', '', get_the_title()) . '" style="display:none;">
					
						<a class="close_x" onclick="self.parent.tb_remove();">X</a>
						
						<span class="float-left event_single_left">
					
						<h1>' . get_the_title() . '</h1>
						
						<br>
						
						<h2>' . get_post_meta(get_the_ID(),'events_venue_name',true) . '</h2>
						
						<br>
						
						<h3>' . get_post_meta(get_the_ID(),'events_date',true) . '</h3>
						
						<br>
						
						<p>' . get_the_content() . '</p>
						
						</span>
						
						<span class="float-right event_single_right">
						
							<p>'.get_post_meta(get_the_ID(),'venue_location_address',true).'</p>';
							
							if(get_post_meta(get_the_ID(),'events_tickets',true) != ''){
							
								$calendar.= '<p><span class="ticket"><a href="' . get_post_meta(get_the_ID(),'events_tickets',true) . '">Tickets for ' . get_the_title() . '</a></span></p>';
							
							}
													
						$calendar.= '</span>
					
					</div>
			
					<a href="#TB_inline?height=700&width=700&inlineId=' .str_replace(' ', '', get_the_title()). '&modal=true" title="' . get_the_title() . '" class="light-blue thickbox">'
				
						.get_the_title().
				
						'<br>
						<span class="grey_666 small">
						
							<p>'.get_post_meta(get_the_ID(),'events_venue_name',true).'</p>
							<p>'.get_the_excerpt().'</p>
					
						</span>
					
					</a>
				
				</span>
				
				<br style="clear:both" />
				
				<br>';
			
			} 
		
		}else{
			$calendar.= str_repeat('<p>&nbsp;</p>',2);
		}
	
		wp_reset_query(); 
		  
		$calendar.= '</td>';
		if($running_day == 6):
		  $calendar.= '</tr>';
		  if(($day_counter+1) != $days_in_month):
		    $calendar.= '<tr class="calendar-row">';
		  endif;
		  $running_day = -1;
		  $days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
		endfor;
		
		/* finish the rest of the days in the week */
		if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
		  $calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		endfor;
		endif;
		
		$calendar.= '</tr>';
		
		$calendar.= '</table>';
		
		return $calendar;
		
		
	
	}
	
}

?>