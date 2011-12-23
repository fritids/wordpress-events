<?php

add_action( 'widgets_init', 'register_widgets' );

function register_widgets(){

	register_widget("Events");

}

/**
 * Events Class
 */
class Events extends WP_Widget {

	function __construct() {
		parent::WP_Widget( /* Base ID */'platform_events', /* Name */'Events', array( 'description' => 'Display your upcoming events' ) );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$number = $instance['number'];
		
		echo $before_widget;
	
		?>
		
			<div class="column_1_3">
			
					<div id="front_page_section_title" class="clear-left">
						<span class="shadow"><?php echo $title;?></span>
					</div>
					
					<?php global $post, $wpdb; 
								
					$querystr = "
					SELECT $wpdb->posts.* , $wpdb->postmeta.* 
					FROM $wpdb->posts, $wpdb->postmeta
					WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
					AND $wpdb->postmeta.meta_key = 'events_date' 
					AND $wpdb->posts.post_status = 'publish' 
					AND $wpdb->posts.post_type = 'events' 
					AND STR_TO_DATE($wpdb->postmeta.meta_value ,'%d-%m-%Y @ %H:%i') >= NOW() 
					ORDER BY STR_TO_DATE($wpdb->postmeta.meta_value ,'%d-%m-%Y @ %H:%i') ASC 
					LIMIT " . $number . " 
					";
					
					//echo $querystr;
					
					$pageposts = $wpdb->get_results($querystr, OBJECT);
					
					global $post;
					
					if ($pageposts){
					
						foreach ($pageposts as $post){ ?>
						
							<?php setup_postdata($post); ?>
							
							<?php echo '<div id="' . str_replace(' ', '', get_the_title()) . '" style="display:none;">
					
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
									
										echo '<p><span class="ticket"><a href="' . get_post_meta(get_the_ID(),'events_tickets',true) . '">Tickets for ' . get_the_title() . '</a></span></p>';
									
									}
															
								echo '</span>
							
							</div>'; ?>
												
							<span class="event-listing float-left">
						
								<a href="#TB_inline?height=700&width=700&inlineId=<?php echo str_replace(' ', '', get_the_title()); ?>&modal=true" class="light-blue thickbox">
							
									<?php the_title(); ?>
							
									<br>
									<span class="black small">
									
										<p><?php echo get_post_meta(get_the_ID(),'events_date',true); ?></p>
										<p><?php the_excerpt(); ?></p>
								
								</span>
								
								</a>
							
							</span>
							
							<br style="clear:both" />
							
							<br>
						
						<?php } 
					
					}
				
					wp_reset_query(); ?>
					
				<br style="clear:both" />
				<br>
				<div id="front_page_section_button">
					<div class="button">
						<span class="button_text"><a class="white" href="<?php echo home_url(); ?>/?post_type=events">see all...</a></span>
					</div>
				</div>	
				
				<br style="clear:both" />
							
				<div class="column_bottom"></div>
			</div>		
		
		<?php
		
		echo $after_widget;
		
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = strip_tags($new_instance['number']);
		return $instance;
	}

	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
		}
		else {
			$title = __( 'New title', 'theplatform' );
		}
		$number = esc_attr( $instance[ 'number' ] );
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		
		<p>
		<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of upcoming events to show:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		<?php 
	}

} // class Events

?>