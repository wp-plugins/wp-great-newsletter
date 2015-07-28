jQuery( "form.wp_great_newsletter_suscribe_form" ).submit( function( event ) {
    event.preventDefault();
    var formData = new FormData( jQuery(this)[0] );
    var name = jQuery( this ).attr( 'name' );
    var form = 'wp_great_newsletter_suscribe_form_'+name;
    var box_suscribe = '#wp-great-newsletter-suscribe-'+name;
    jQuery( box_suscribe+' #wp-great-newsletter-result' ).html( '' );
    jQuery( box_suscribe+' #wp-great-newsletter-result' ).removeClass( "wp-great-newsletter-display-block" );
    jQuery( box_suscribe+' #wp-great-newsletter-result' ).addClass( "wp-great-newsletter-display-none" );
    jQuery( box_suscribe+' #wp_great_newsletter_email' ).removeClass( "wp-great-newsletter-input-error" );
    jQuery( box_suscribe+' #wp_great_newsletter_privacy_policy' ).removeClass( "wp-great-newsletter-input-error" );
    var msj = '';
    var ok = true;
    var email = document.getElementById( form ).wp_great_newsletter_email.value;
    var privacy_policy = document.getElementById( form ).wp_great_newsletter_privacy_policy;
    if ( email == "" || ! ( /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/.test( email ) ) ) {
        jQuery( box_suscribe+ ' #wp_great_newsletter_email' ).addClass( "wp-great-newsletter-input-error" );   
        msj = '<div class="wp-great-newsletter-result-false">Invalid email.</div>';
        ok = false;
    }
    if ( privacy_policy.checked==0) {
        jQuery( box_suscribe+ ' #wp_great_newsletter_privacy_policy' ).addClass( "wp-great-newsletter-input-error" );   
        msj += '<div class="wp-great-newsletter-result-false">Privacy policy is an obligatory field</div>';
        ok = false;
    }
    if ( !ok ) {
        jQuery( box_suscribe+ ' #wp-great-newsletter-result' ).removeClass( "wp-great-newsletter-display-none" );
        jQuery( box_suscribe+ ' #wp-great-newsletter-result' ).addClass( "wp-great-newsletter-display-block" );
        jQuery( box_suscribe+ ' #wp-great-newsletter-result' ).html( msj );
    } else {
        formData.append('action', 'wp_great_newsletter_suscribe_process');
        jQuery.ajax({
            url: wpgreatnewsletterajax.wpgreatnewsletterajaxurl,
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function ( data ) {
                data = JSON.parse( data );
                jQuery( box_suscribe+ ' #wp-great-newsletter-result' ).removeClass( "wp-great-newsletter-display-none" );
                jQuery( box_suscribe+ ' #wp-great-newsletter-result' ).addClass( "wp-great-newsletter-display-block" );
                if( data["result"] == 'wpgn_email_false' ) {
                    jQuery( box_suscribe+ ' #wp_great_newsletter_email' ).addClass( "wp-great-newsletter-input-error" ); 
                    jQuery( box_suscribe+ ' #wp-great-newsletter-result' ).html( '<div class="wp-great-newsletter-result-false">Invalid email.</div>' );
                }
                if( data["result"] == 'wpgn_email_exist' ) {
                    jQuery( box_suscribe+ ' #wp_great_newsletter_email' ).addClass( "wp-great-newsletter-input-error" ); 
                    jQuery( box_suscribe+ ' #wp-great-newsletter-result' ).html( '<div class="wp-great-newsletter-result-false">Email already exist.</div>' );
                }
                if( data["result"] == 'wpgn_true' ) {
                    document.getElementById( form ).reset();
                    jQuery( box_suscribe+ ' #wp-great-newsletter-result' ).html( '<div class="wp-great-newsletter-result-true">You have been subscribed successfully</div>' ); 
                }
                if( data["result"] == 'wpgn_false' ) {
                    jQuery( box_suscribe+ ' #wp-great-newsletter-result' ).html( '<div class="wp-great-newsletter-result-false">Something is wrong. Try later.</div>' );
                }
            }
        });
    }
   return false; 
}); 


jQuery( "form.wp_great_newsletter_unsuscribe_form" ).submit( function( event ) {
    event.preventDefault();
    var formData = new FormData( jQuery( this )[0] );
    var name = jQuery( this ).attr( 'name' );
    var form = 'wp_great_newsletter_unsuscribe_form_'+name;
    var box_unsuscribe = '#wp-great-newsletter-unsuscribe-'+name;
    jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).html( '' );
    jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).removeClass( "wp-great-newsletter-display-block" );
    jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).addClass( "wp-great-newsletter-display-none" );
    jQuery( box_unsuscribe+ ' #wp_great_newsletter_email' ).removeClass( "wp-great-newsletter-input-error" );
    var msj = '';
    var ok = true;
    var email = document.getElementById( form ).wp_great_newsletter_email.value;
    if ( email == "" || ! ( /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/.test( email ) ) ) {
        jQuery( box_unsuscribe+ ' #wp_great_newsletter_email' ).addClass( "wp-great-newsletter-input-error" );   
        msj = '<div class="wp-great-newsletter-result-false">Invalid email.</div>';
        ok = false;
    }
    if ( !ok ) {
        jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).removeClass( "wp-great-newsletter-display-none" );
        jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).addClass( "wp-great-newsletter-display-block" );
        jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).html( msj );
    } else {
        formData.append('action', 'wp_great_newsletter_unsuscribe_process');
        jQuery.ajax({
            url: wpgreatnewsletterajax.wpgreatnewsletterajaxurl,
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function ( data ) {
                data = JSON.parse( data );
                jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).removeClass( "wp-great-newsletter-display-none" );
                jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).addClass( "wp-great-newsletter-display-block" );
                if( data["result"] == 'wpgn_email_false' ) {
                    jQuery( box_unsuscribe+ ' #wp_great_newsletter_email' ).addClass( "wp-great-newsletter-input-error" ); 
                    jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).html( '<div class="wp-great-newsletter-result-false">Invalid email.</div>' );
                }
                if( data["result"] == 'wpgn_false' ) {
                    jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).html( '<div class="wp-great-newsletter-result-false">Something is wrong. Try later.</div>' );
                }
                if( data["result"] == 'wpgn_unsb_true' ) {
                    document.getElementById( form ).reset();
                    jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).html( '<div class="wp-great-newsletter-result-true">You have been unsubscribed successfully</div>' );
                }
                if( data["result"] == 'wpgn_email_unsb_exist' ) {
                    jQuery( box_unsuscribe+ ' #wp-great-newsletter-result' ).html( '<div class="wp-great-newsletter-result-false">Email dont exist</div>' );
                }
            }
        });
    }
   return false; 
}); 


jQuery( document ).ready( function() {
    
    jQuery( 'body .wp-great-newsletter-suscribe' ).css( {display:'block'} );
    jQuery( 'body .wp-great-newsletter-unsuscribe' ).css( {display:'none'} );

});

function wp_great_newsletter_action_unsubscribe( idsuscribe, idunsuscribe ) {
    var form = 'wp_great_newsletter_suscribe_form_'+idsuscribe;
    var box_suscribe = '#wp-great-newsletter-suscribe-'+idsuscribe;
    var box_unsuscribe = '#wp-great-newsletter-unsuscribe-'+idunsuscribe;
    
    jQuery( 'body '+box_suscribe ).css( {display:'none'} );
    jQuery( 'body '+box_unsuscribe ).css( {display:'block'} );
    
    document.getElementById( form ).reset();
    
    jQuery( 'body '+box_suscribe+' #wp_great_newsletter_email' ).removeClass( "wp-great-newsletter-input-error" ); 
    jQuery( 'body '+box_suscribe+' #wp-great-newsletter-result' ).removeClass( "wp-great-newsletter-display-block" );
    jQuery( 'body '+box_suscribe+' #wp-great-newsletter-result' ).addClass( "wp-great-newsletter-display-none" ); 
};

function wp_great_newsletter_action_subscribe( idunsuscribe, idsuscribe ) {
    var form = 'wp_great_newsletter_unsuscribe_form_'+idunsuscribe;
    var box_suscribe = '#wp-great-newsletter-suscribe-'+idsuscribe;
    var box_unsuscribe = '#wp-great-newsletter-unsuscribe-'+idunsuscribe;

    jQuery( 'body '+box_suscribe ).css( {display:'block'} );
    jQuery( 'body '+box_unsuscribe ).css( {display:'none'} );
    
    document.getElementById( form ).reset();
    
    jQuery( 'body '+box_unsuscribe+' #wp_great_newsletter_email' ).removeClass( "wp-great-newsletter-input-error" ); 
    jQuery( 'body '+box_unsuscribe+' #wp-great-newsletter-result' ).removeClass( "wp-great-newsletter-display-block" );
    jQuery( 'body '+box_unsuscribe+' #wp-great-newsletter-result' ).addClass( "wp-great-newsletter-display-none" );
};


