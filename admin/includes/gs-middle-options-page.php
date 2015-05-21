<?php 
if( ! empty( $_POST['Submit'] ) && $_POST['Submit'] == 'Save options' ) {
    
    $wp_great_newsletter_color_field = sanitize_text_field ( isset( $_POST['wp_great_newsletter_color_field'] ) ? esc_html( trim( $_POST['wp_great_newsletter_color_field'] ) ) : null );
    $wp_great_newsletter_color_button = sanitize_text_field ( isset( $_POST['wp_great_newsletter_color_button'] ) ? esc_html( trim( $_POST['wp_great_newsletter_color_button'] ) ) : null );
    $wp_great_newsletter_text_color_button = sanitize_text_field ( isset( $_POST['wp_great_newsletter_text_color_button'] ) ? esc_html( trim( $_POST['wp_great_newsletter_text_color_button'] ) ) : null );
    $wp_great_newsletter_text_color_field = sanitize_text_field ( isset( $_POST['wp_great_newsletter_text_color_field'] ) ? esc_html( trim( $_POST['wp_great_newsletter_text_color_field'] ) ) : null );
    $wp_great_newsletter_name = isset( $_POST['wp_great_newsletter_name'] ) ? $_POST['wp_great_newsletter_name'] : null;
    $wp_great_newsletter_telephone = isset( $_POST['wp_great_newsletter_telephone'] ) ? $_POST['wp_great_newsletter_telephone'] : null;
    $wp_great_newsletter_type = isset( $_POST['wp_great_newsletter_type'] ) ? $_POST['wp_great_newsletter_type'] : null;
    $wp_great_newsletter_unsubscribe_option = isset( $_POST['wp_great_newsletter_unsubscribe_option'] ) ? $_POST['wp_great_newsletter_unsubscribe_option'] : null;

    update_option('wp_great_newsletter_color_field', $wp_great_newsletter_color_field);
    update_option('wp_great_newsletter_color_button', $wp_great_newsletter_color_button);
    update_option('wp_great_newsletter_text_color_button', $wp_great_newsletter_text_color_button);
    update_option('wp_great_newsletter_text_color_field', $wp_great_newsletter_text_color_field);
    update_option('wp_great_newsletter_name', $wp_great_newsletter_name);
    update_option('wp_great_newsletter_telephone', $wp_great_newsletter_telephone);
    update_option('wp_great_newsletter_type', $wp_great_newsletter_type);
    update_option('wp_great_newsletter_unsubscribe_option', $wp_great_newsletter_unsubscribe_option);

    print '<div class="updated">';
        _e('Options saved.');
    print '</div>';
    
}

    $wp_great_newsletter_color_field = get_option( 'wp_great_newsletter_color_field' );
    $wp_great_newsletter_text_color_field = get_option( 'wp_great_newsletter_text_color_field' );
    $wp_great_newsletter_text_color_button = get_option( 'wp_great_newsletter_text_color_button' );
    $wp_great_newsletter_color_button = get_option( 'wp_great_newsletter_color_button' );
    $wp_great_newsletter_name = get_option( 'wp_great_newsletter_name' );
    $wp_great_newsletter_telephone = get_option( 'wp_great_newsletter_telephone' );
    $wp_great_newsletter_type = get_option( 'wp_great_newsletter_type' );
    $wp_great_newsletter_unsubscribe_option = get_option( 'wp_great_newsletter_unsubscribe_option' );

    if ( $wp_great_newsletter_name > 0 ) {
        
        $checked_name = "checked";
        
    } else {
        
        $checked_name = false;
        
    }
    
    if( $wp_great_newsletter_telephone > 0 ) {
        
        $checked_telephone = "checked";
        
    } else {
        
        $checked_telephone = false;
        
    }
    
    if( $wp_great_newsletter_type == 1 ) {
        
        $selected_type_vertical = "selected";
        $selected_type_horizontal = false;
        
    } else {
        
        $selected_type_horizontal = "selected";
        $selected_type_vertical = false;
        
    }

    if( $wp_great_newsletter_unsubscribe_option == 1 ) {
        
        $checked_unsubscribe_option = "checked";
        
    } else {
        
        $checked_unsubscribe_option = false;
        
    }

?>

<div class="container">
    <form name="wp_great_newsletter_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI'] ); ?>">
        <div class="wgc-box">
            <div class="header medium">
                <?php _e( '<h4>Copy / Paste shortcode:</h4>', 'wp-great-newsletter' ); ?>
            </div>
            <div class="wgc-box-body">
                <div class="shortcode"><?php echo "[wp-great-newsletter]"; ?></div>
            </div>
        </div>
        <div class="wgc-box">
            <div class="header medium">
                <?php _e( '<h4>Create new suscription form to posts and pages</h4>', 'wp-great-newsletter' ); ?>
            </div>
            <div class="wgc-box-body">
                <table>
                    <tr>
                        <td><?php _e( 'Add field name:', 'wp-great-newsletter' ); ?></td>
                        <td><input type="checkbox" name="wp_great_newsletter_name" value="1" <?php echo $checked_name; ?> /></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Add field email:', 'wp-great-newsletter' ); ?></td>
                        <td><input type="checkbox" name="wp_great_newsletter_email" value="1" checked disabled /></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Add field telephone:', 'wp-great-newsletter' ); ?></td>
                        <td><input type="checkbox" name="wp_great_newsletter_telephone" value="1" <?php echo $checked_telephone; ?> /></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Enable unsubscribe link:', 'wp-great-newsletter' ); ?></td>
                        <td><input type="checkbox" name="wp_great_newsletter_unsubscribe_option" value="1" <?php echo $checked_unsubscribe_option; ?> /></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="wgc-box">
            <div class="header medium">
                <?php _e( '<h4>Styles template form:</h4>', 'wp-great-newsletter' ); ?>
            </div>
            <div class="wgc-box-body">
                <table>
                    <tr>
                        <td><?php _e( 'Select design form:', 'wp-great-newsletter' ); ?></td>
                        <td>
                            <select name="wp_great_newsletter_type">
                                <option value="1" <?php echo $selected_type_vertical; ?>>Vertical</option>
                                <option value="2" <?php echo $selected_type_horizontal; ?>>Horizontal</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Background color button:', 'wp-great-newsletter' ); ?></td>
                        <td><input type="text" class="wp-great-newsletter-color" name="wp_great_newsletter_color_button" id="wp_great_newsletter_color_button" value="<?php echo $wp_great_newsletter_color_button; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Text color button:', 'wp-great-newsletter' ); ?></td>
                        <td><input type="text" class="wp-great-newsletter-color" name="wp_great_newsletter_text_color_button" id="wp_great_newsletter_text_color_button" value="<?php echo $wp_great_newsletter_text_color_button; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Background color fields:', 'wp-great-newsletter' ); ?></td>
                        <td><input type="text" class="wp-great-newsletter-color" name="wp_great_newsletter_color_field" id="wp_great_newsletter_color_field" value="<?php echo $wp_great_newsletter_color_field; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php _e( 'Text color fields:', 'wp-great-newsletter' ); ?></td>
                        <td><input type="text" class="wp-great-newsletter-color" name="wp_great_newsletter_text_color_field" id="wp_great_newsletter_text_color_field" value="<?php echo $wp_great_newsletter_text_color_field; ?>"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="block">
            <p class="submit">
                <input type="submit" class="button button-primary" name="Submit" id="Submit" value="<?php _e( 'Save options', 'wp-great-newsletter' ); ?>" />
            </p>
        </div>
    </form>
</div>
