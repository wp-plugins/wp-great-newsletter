<?php	
$wp_great_newsletter_name = sanitize_text_field( isset( $_POST['wp_great_newsletter_name'] ) ? esc_html( trim( $_POST['wp_great_newsletter_name'] ) ) : null );
$wp_great_newsletter_email = sanitize_email( isset( $_POST['wp_great_newsletter_email'] ) ? esc_html( trim( $_POST['wp_great_newsletter_email'] ) ) : null );
$wp_great_newsletter_telephone = sanitize_text_field( isset( $_POST['wp_great_newsletter_telephone'] ) ? esc_html( trim( $_POST['wp_great_newsletter_telephone'] ) ) : null );

if( is_email( $wp_great_newsletter_email ) ) {
	
	global $wpdb;
        
	$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM wp_great_newsletter WHERE email='" . $wp_great_newsletter_email . "'" );
	
        if ($user_count > 0){
            
	  $result = "wpgn_email_exist";
          
	}else{
		$wpdb->insert( 
			'wp_great_newsletter', 
			array( 
				'date'  => date( "Y-m-d" ),
				'name'  => $wp_great_newsletter_name ,
				'email' => $wp_great_newsletter_email,
				'telephone' => $wp_great_newsletter_telephone,
			), 
			array( 
				'%s',
				'%s',
				'%s',
				'%s',
			) 
		);
                
		if ( $wpdb == true ) {

		  $result = "wpgn_true";

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
