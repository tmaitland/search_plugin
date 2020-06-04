<?php// Creating widget front-end
	 
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
         <form role="search" method="get" class="api-search-form" id="api-search-form" action="<?php echo $link?>">
             <label for="api-search-form" /> 
             <div class="hold-search">
                 <input type="text" id="search-input" name="Google_Search_Form" value="Search for..." />
                 <input type="submit" id="search-submit-btn" /> 
             </div>    
         </form>
         <?php 
         
 
 
         echo $args['after_widget'];
     } ?>