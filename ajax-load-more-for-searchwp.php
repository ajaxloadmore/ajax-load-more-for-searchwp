<?php
/*
Plugin Name: Ajax Load More for SearchWP
Plugin URI: http://connekthq.com/plugins/ajax-load-more/extensions/searchwp/
Description: An Ajax Load More extension that adds compatibility with SearchWP
Text Domain: ajax-load-more-for-searchwp
Author: Darren Cooney
Twitter: @KaptonKaos
Author URI: https://connekthq.com
Version: 1.0.1
License: GPL
Copyright: Darren Cooney & Connekt Media
*/


if(!class_exists('ALM_SearchWP')) :   
   
   class ALM_SearchWP{	   
      
   	function __construct(){	
         add_filter('alm_searchwp', array(&$this, 'alm_searchwp_get_posts'), 10, 2);	
      }
      
      
      
      /*
   	*  alm_searchwp_get_posts
   	*  Get searchwp search results and return post ids in post__in wp_query param
   	*
   	*  @return $args
   	*  @since 1.0
   	*/
      function alm_searchwp_get_posts($args, $engine){
      	
      	if(class_exists('SWP_Query')){
      		
      		if(empty($engine) || !isset($engine)){
      			$engine = 'default'; // set search engine
      		}
      		
      		$swp_query = new SWP_Query(
      			array(
      				'engine' 			=> $engine, // SWP Search Engine
      				's' 					=> sanitize_text_field($args['s']), // search query
                  'fields'          => 'ids',
      				'posts_per_page' 	=> -1, // posts_per_page
      			)
      		);
      		
      		if ( ! empty( $swp_query->posts ) ) {
         		      			      			
      			$args['post__in'] = $swp_query->posts; // $swp_query->posts array
      			$args['orderby'] = 'post__in'; // override orderby to relevance
      			$args['s'] = ''; // Reset 's' term value
      			    			
      		}  
      		    			
      		return $args;	
      	}
      	
      }
   }
   
   
   
   /*
   *  ALM_SearchWP
   *  The main function responsible for returning the one true ALM_SearchWP Instance.
   *
   *  @since 2.0.0
   */
   function ALM_SearchWP(){
      global $alm_searchwp;
      
      if( !isset($alm_searchwp) ){
         $alm_searchwp = new ALM_SearchWP();
      }
      
      return $alm_searchwp;
   }      
   ALM_SearchWP(); // initialize
   
endif;