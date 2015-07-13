<?php	
$wp_great_newsletter_email = sanitize_email( isset( $_POST['wp_great_newsletter_email'] ) ? esc_html( trim( $_POST['wp_great_newsletter_email'] ) ) : null );

if( is_email ( $wp_great_newsletter_email ) ) {
	
	global $wpdb;
        
	$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM '.$wpdb->prefix.'_great_newsletter WHERE email='".$wp_great_newsletter_email."'" );
	
        if ( $user_count == 0 ){
            
	  $result = "wpgn_email_unsb_exist";
          
	}else{
		$wpdb->delete( $wpdb->prefix."_great_newsletter", array( 
                    "email" => $wp_great_newsletter_email 
                        ) 
                    );
		
		if ( $wpdb==true ) {
                    
		  $result = "wpgn_unsb_true";
                  
		}else{
                    
		  $result = "wpgn_false";
                  
		}
	}
        
}else{
    
	$result = "wpgn_email_false";
        
}

$result_ajax = array(
    "result" => $result
);

print json_encode( $result_ajax );

?>
