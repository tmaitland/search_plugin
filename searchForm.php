<?php
/**
 * @package SearchForm_Widget
 * @version 1.05
 */
/*
Plugin Name: Google Search Widget
Description: Widget that allows user to search using the Google API on a WordPress site
Author: Toni-Lee M.
Author URI: 
Version: 1.05
*/

/** Ajax calls */
// $argument = $_POST['Google_Search_Form'];
// $url = `https://news.google.com/search?q={$argument}&amp;output=rss&hl=en-US&gl=US&ceid=US:en`;

$url = $_GET['url']; 
$content = file_get_contents($url); 
header('Access-Control-Allow-Origin: *'); 
echo $content; 

function GoogleSearch_plugin()
{   
   wp_enqueue_script( 'jquery' );
   wp_register_script('search', plugin_dir_url( __FILE__ ) . 'assets/js/search.js', true);
   wp_enqueue_script('search', plugin_dir_url( __FILE__ ) . 'assets/js/search.js', array('jQuery'), true);
   wp_enqueue_style('style', plugin_dir_url( __FILE__ ) . 'assets/css/styles.css');
}

// wp_enqueue_script( 'search', plugin_dir_url( __FILE__ ) . 'assets/js/search.js', array(), true );

add_action( 'wp_footer', 'GoogleSearch_plugin' ); // Write our JS below here


// Same handler function...


function loadSearch() {
	global $wpdb; // this is how you get access to the database
	
	$whatever = intval( $_POST['whatever'] );
	
	$whatever += 10;
	
	echo $whatever;
	
	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_loadSearch', 'loadSearch' );



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
		__('Google Search Widget', 'searchForm_widget_domain'), 
			 
		// Widget description
		array( 'description' => __( 'Widget that allows user to search using the Google API on a WordPress site', 'searchForm_load_widget' ), ) 
		);
	}
	
	// Creating widget front-end
	 
	public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        if ( isset( $_SERVER[ 'HTTPS' ]) && $_SERVER[ 'HTTPS' ] === 'on' )  
             $link = "https";
        else
             $link = "http";
             $link .= "://";
             $link .= $_SERVER['HTTP_HOST'];
             $link .= $_SERVER['REQUEST_URI'];
		
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		 
		// This is where you run the code and display the output
		// echo __( 'Hello, World!', 'tl_widget_domain' );
		?>
		<form role="search" class="api-search-form" id="api-search-form" >
            <label for="api-search-form" /> 
            <div class="hold-search">
                <input type="text" id="search-input" name="Google_Search_Form" placeholder="Search..." />
                <input type="submit" id="search-submit-btn" /> 
			</div> 
			<div id="display_info"></div>  
        </form>
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


?>