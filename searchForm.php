
<?php
/**
 * @package SearchForm_Widget
 * @version 1.05
 */
/*
Plugin Name: Google News Search Widget
Description: Widget that allows user to search using the Google News RSS API on a WordPress site
Author: Toni-Lee M.
Author URI: 
Version: 1.05
*/

//Add Scripts to the footer
function GoogleSearch_scripts()
{   
   wp_enqueue_script( 'jquery', true);
   wp_register_script('search', plugin_dir_url( __FILE__ ) . 'assets/js/search.js', true);
   wp_enqueue_script('search', plugin_dir_url( __FILE__ ) . 'assets/js/search.js', array('jQuery'), true);
   wp_enqueue_script('jquery modal','https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', true);
}
add_action( 'wp_footer', 'GoogleSearch_scripts' ); // Write our JS below here

//Add Scripts to the head
function headScripts(){
	wp_enqueue_script('axios', plugin_dir_url( __FILE__ ) . 'node_modules/axios/dist/axios.min.js', false);
	wp_enqueue_script('xml2json', 'https://cdnjs.cloudflare.com/ajax/libs/x2js/1.2.0/xml2json.min.js', false);
	wp_enqueue_script('modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js', false);
	wp_enqueue_style('styles', plugin_dir_url( __FILE__ ) . 'assets/css/styles.css', false);
	wp_enqueue_style('modal', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', false);
}
add_action( 'wp_enqueue_scripts', 'headScripts' ); // Write our JS below here


// Register and load the widget
function searchForm_load_widget() {
    register_widget( 'searchForm_widget' );
}
add_action( 'widgets_init', 'searchForm_load_widget' );
 
class searchForm_widget extends WP_Widget {
	// class constructor
	
	public function __construct() {
		parent::__construct(
			 
		// Base ID of your widget
		'searchForm_widget', 
			 
		// Widget name will appear in UI
		__('Google News Search Widget', 'searchForm_widget_domain'), 
			 
		// Widget description
		array( 'description' => __( 'Widget that allows user to search using the Google News RSS Feed API on a WordPress site', 'searchForm_load_widget' ), ) 
		);
	}
	
	// Creating widget front-end
	 
	public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
		 
		// This is where you run the code and display the output
		// echo __( 'Hello, World!', 'tl_widget_domain' );
		?>
		<div id="loader"></div>
		<div class="hold-form-and-info" div="hold-form-and-info">
			<?php 
				echo $args['before_widget'];
				if ( ! empty( $title ) )
				echo $args['before_title'] . $title . $args['after_title'];
			?>
			<form role="search" class="api-search-form" id="api-search-form" >
				<!-- <label for="api-search-form" />  -->
				<div class="hold-search">
					<input type="text" id="search-input" name="Google_Search_Form" placeholder="Search..." />
					<input type="submit" id="search-submit-btn" />
				</div> 
			</form>
		</div>
		<div class="modal-bg">
			<div class="hold-modal">
				<div class="modal">
					<div id="display_info"></div>  
				</div>
			</div>
		</div>
		<?php 
		
		echo $args['after_widget'];
	}

	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'tl_widget_domain' );
		}
		// Widget admin form
		?>
		<p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
	// save options
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}

function register_searchFormShortcode(){
	add_shortcode('google_rss_news', 'searchForm_widget');
 }

 add_action( 'init', 'register_searchFormShortcode');

 add_filter('widget_text', 'do_shortcode');

?>