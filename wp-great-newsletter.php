<?php
/*
Plugin Name: WP Great Newsletter
Plugin URI: http://www.studiosweb.es/
Description: With this plugin you can create and customize a subscription form on your website where visitors can leave their details so that you can then export them freely and use them all the time for sending newsletter with external postmaster programs.
Version: 1.0
Author: Alberto Pérez
Author URI: http://www.studiosweb.es
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=R3XEYFJ22BUTG
License: A "Slug" license name e.g. GPL2
*/

define( 'WP_GREAT_NEWSLETTER_VERSION', '1.0' );
define( 'WP_GREAT_NEWSLETTER_DIR', plugin_dir_path(__FILE__) );
define( 'WP_GREAT_NEWSLETTER_URL', plugin_dir_url(__FILE__) );

add_action( 'admin_enqueue_scripts', 'wp_great_newsletter_admin_resources' );

function wp_great_newsletter_admin_resources() {
    
    wp_register_style( 'wp_great_newsletter_css', WP_GREAT_NEWSLETTER_URL . 'admin/css/styles.css' );
    wp_enqueue_style( 'wp_great_newsletter_css' );
    
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-great-newsletter', plugins_url('admin/js/jscolor/jscolor.js', __FILE__ ), array( 'wp-color-picker' ), false, true );


}

add_action( 'wp_enqueue_scripts', 'wp_great_newsletter_frontend_resources' );

function wp_great_newsletter_frontend_resources() {
    
    wp_register_style( 'wp_great_newsletter_css', WP_GREAT_NEWSLETTER_URL . 'css/styles.css' );
    wp_enqueue_style( 'wp_great_newsletter_css' );
    
    wp_register_script( 'wp_great_newsletter_script', WP_GREAT_NEWSLETTER_URL . 'js/wp-great-newsletter.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'wp_great_newsletter_script' );
    
    wp_localize_script( 'wp_great_newsletter_script', 'wpgreatnewsletterajax', array( 'wpgreatnewsletterajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	
    
}

add_filter( 'plugin_row_meta', 'wp_great_newsletter_row_meta', 10, 2 );

function wp_great_newsletter_row_meta( $links, $file ) {
    
    if ( strpos( $file, 'wp-great-newsletter.php') !== false ) {
        $new_links = 
        array(
        '<a href="admin.php?page=wp_great_newsletter_options_page">Settings</a>',
        '<a href="admin.php?page=wp_great_newsletter_information_page">Documentation</a>',
        '<b><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=G5RPQ9B7K7X9L">Donate</a></b>'
        );	
        $links = array_merge( $links, $new_links );
    }
    return $links;
    
}

register_activation_hook(__FILE__, 'wp_great_newsletter_activation');

function wp_great_newsletter_activation() {
    
    global $wpdb;
    $table = $wpdb->prefix . "great_newsletter";
    $sql = "CREATE TABLE $table (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    date date DEFAULT '0000-00-00' NOT NULL,
    name VARCHAR(255) DEFAULT '' NULL,
    telephone VARCHAR(55) DEFAULT '' NULL,
    email VARCHAR(55) DEFAULT '' NOT NULL,
    UNIQUE KEY id (id)
    );";
	
    require_once( ABSPATH.'wp-admin/includes/upgrade.php' );
        
    dbDelta( $sql );

    update_option( 'wp_great_newsletter_text_color_button', 'ffffff' );
    update_option( 'wp_great_newsletter_text_color_field', '999999' );
    update_option( 'wp_great_newsletter_color_button', '000000' );
    update_option( 'wp_great_newsletter_color_field', 'f7f7f2' );
    update_option( 'wp_great_newsletter_name', '1' );
    update_option( 'wp_great_newsletter_telephone', '1' );
    update_option( 'wp_great_newsletter_type', '1' );
    update_option( 'wp_great_newsletter_unsubscribe_option', '1' );

}

register_deactivation_hook( __FILE__, 'wp_great_newsletter_deactivation' );

function wp_great_newsletter_deactivation() {
    
    flush_rewrite_rules();
    
}


add_action( 'admin_menu', 'wp_great_newsletter_menu' );

function wp_great_newsletter_menu() {
    
    add_menu_page( 'WP Great Newsletter', 'WP Great Newsletter', 'manage_options', 'wp_great_newsletter_options_page', 'wp_great_newsletter_import_options_page', WP_GREAT_NEWSLETTER_URL . 'admin/images/wp-great-newsletter-icon.png', 102 );
    $hook = add_submenu_page( 'wp_great_newsletter_options_page', 'Subscribers List', 'Subscribers List', 'manage_options', 'wp_great_newsletter_subscribers_page', 'wp_great_newsletter_import_subscribers_page' );
    add_submenu_page( 'wp_great_newsletter_options_page', 'Documentation', 'Documentation', 'manage_options', 'wp_great_newsletter_information_page', 'wp_great_newsletter_import_information_page' );
    add_action( "load-$hook", 'wp_great_newsletter_add_options' );
}

function wp_great_newsletter_import_options_page() {
    
  require_once(WP_GREAT_NEWSLETTER_DIR . "admin/options_admin_page.php");
  
}

function wp_great_newsletter_import_subscribers_page() {
    
  require_once(WP_GREAT_NEWSLETTER_DIR . "admin/subscribers_admin_page.php");
  
}

function wp_great_newsletter_import_information_page() {
    
  require_once(WP_GREAT_NEWSLETTER_DIR . "admin/information_admin_page.php");
  
}


add_action( 'init', 'wp_great_newsletter_do_output_buffer' );

function wp_great_newsletter_do_output_buffer() {
    
    ob_start();
    
}

add_shortcode( 'wp-great-newsletter', 'wp_great_newsletter_render_shortcode' );

add_filter( 'widget_text', 'do_shortcode' );

function wp_great_newsletter_render_shortcode() {
    
    $wp_great_newsletter_name = get_option( 'wp_great_newsletter_name' );
    $wp_great_newsletter_telephone = get_option( 'wp_great_newsletter_telephone' );
    $wp_great_newsletter_type = get_option( 'wp_great_newsletter_type' );
    $wp_great_newsletter_color_button = get_option( 'wp_great_newsletter_color_button' );
    $wp_great_newsletter_text_color_button = get_option( 'wp_great_newsletter_text_color_button' );
    $wp_great_newsletter_color_field = get_option( 'wp_great_newsletter_color_field' );
    $wp_great_newsletter_text_color_field = get_option( 'wp_great_newsletter_text_color_field' );
    $wp_great_newsletter_unsubscribe_option = get_option( 'wp_great_newsletter_unsubscribe_option' );

    $protocol = isset( $_SERVER['HTTPS'] ) == 'on' ? 'https' : 'http';
    
    $rand_suscribe = md5( rand (1, 9999) . time() );
    $rand_unsuscribe = md5( rand (10000, 99999) . time() );
     
    $shortcode = '<div id="wp-great-newsletter" class="wp-great-newsletter-' . $wp_great_newsletter_type . '">' . "\n";
        $shortcode .= '<div id="wp-great-newsletter-suscribe-' . $rand_suscribe . '" class="wp-great-newsletter-suscribe">' . "\n";
            $shortcode .= '<div id="wp-great-newsletter-result" class="wp-great-newsletter-result"></div>' . "\n";
            $shortcode .= '<form id="wp_great_newsletter_suscribe_form_' . $rand_suscribe . '" class="wp_great_newsletter_suscribe_form" name="' . $rand_suscribe . '" method="post">' . "\n";
                $shortcode .= '<span class="form-part">'; 
                    $shortcode .= '<label for="wp_great_newsletter_email">Email:</label>'."\n";
                    $shortcode .= '<input style="background-color:#' . $wp_great_newsletter_color_field . '; color:#' . $wp_great_newsletter_text_color_field . '" type="text" name="wp_great_newsletter_email" id="wp_great_newsletter_email" value="" />' . "\n";
                $shortcode .= '</span>';
                if ( $wp_great_newsletter_name > 0 ) {
                    $shortcode .= '<span class="form-part">';        
                        $shortcode .= '<label for="wp_great_newsletter_name">Name:</label>'."\n";
                        $shortcode .= '<input style="background-color:#' . $wp_great_newsletter_color_field . '; color:#' . $wp_great_newsletter_text_color_field . '" type="text" name="wp_great_newsletter_name" id="wp_great_newsletter_name" value="" />' . "\n";
                    $shortcode .= '</span>';
                }
                if ( $wp_great_newsletter_telephone > 0 ) {
                    $shortcode .= '<span class="form-part">';    
                        $shortcode .= '<label for="wp_great_newsletter_telephone">Telephone:</label>'."\n";
                        $shortcode .= '<input style="background-color:#'.$wp_great_newsletter_color_field.'; color:#'.$wp_great_newsletter_text_color_field.'" type="text" name="wp_great_newsletter_telephone" id="wp_great_newsletter_telephone" value="" />' . "\n";
                    $shortcode .= '</span>';
                }
                $shortcode .= '<span class="form-part">';
                    $shortcode .= '<button type="submit" style="background-color:#'.$wp_great_newsletter_color_button.'; color:#'.$wp_great_newsletter_text_color_button.'">Subscribe now</button>' . "\n";
                    if ( $wp_great_newsletter_unsubscribe_option > 0 ) {
                        $shortcode .= '<a onclick="wp_great_newsletter_action_unsubscribe(\'' . $rand_suscribe . '\', \'' . $rand_unsuscribe . '\');">Unsubscribe</a>' . "\n";
                    }
                $shortcode .= '</span>';
            $shortcode .= '</form>' . "\n";
        $shortcode .= '</div>' . "\n";
        $shortcode .= '<div id="wp-great-newsletter-unsuscribe-' . $rand_unsuscribe . '" class="wp-great-newsletter-unsuscribe">' . "\n";
            $shortcode .= '<div id="wp-great-newsletter-result" class="wp-great-newsletter-result"></div>' . "\n";
            $shortcode .= '<form id="wp_great_newsletter_unsuscribe_form_' . $rand_unsuscribe . '" class="wp_great_newsletter_unsuscribe_form" name="' . $rand_unsuscribe . '" method="post">' . "\n";
                $shortcode .= '<span class="form-part">'; 
                    $shortcode .= '<label for="wp_great_newsletter_email">Email:</label>'."\n";
                    $shortcode .= '<input style="background-color:#' . $wp_great_newsletter_color_field . '; color:#' . $wp_great_newsletter_text_color_field . '" type="text" name="wp_great_newsletter_email" id="wp_great_newsletter_email" value="" />' . "\n";
                $shortcode .= '</span>';
                $shortcode .= '<span class="form-part">';
                    $shortcode .= '<button type="submit" style="background-color:#' . $wp_great_newsletter_color_button . '; color:#' . $wp_great_newsletter_text_color_button . '">Unsubscribe</button>' . "\n";
                    if ( $wp_great_newsletter_unsubscribe_option > 0 ) {
                        $shortcode .= '<a onclick="wp_great_newsletter_action_subscribe(\'' . $rand_unsuscribe . '\', \'' . $rand_suscribe . '\');">Subscribe</a>' . "\n";
                    }
                $shortcode .= '</span>';
            $shortcode .= '</form>' . "\n";
        $shortcode .= '</div>' . "\n";
    $shortcode .= '</div>' . "\n";
  
    return $shortcode;
    
}


function wp_great_newsletter_add_options() {
  $option = 'per_page';
  $args = array(
         'label' => 'Subscribers',
         'default' => 20,
         'option' => 'subscribers_per_page'
         );
  add_screen_option( $option, $args );
}

add_filter('set-screen-option', 'wp_great_newsletter_set_option', 10, 3);
function wp_great_newsletter_set_option($status, $option, $value) {
     if ( 'subscribers_per_page' == $option ) {
         return $value;
     } 
    return $status;
}

function wp_great_newsletter_subscribers_list() {
    
    if( is_admin() ) {
        
        global $wpdb;
        if( ! class_exists( 'WP_List_Table' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
        }
        
        $subscriberstable = new wp_great_newsletter_list_table();
        if( isset( $_POST['s'] ) && $_POST['page'] == 'wp_great_newsletter_subscribers_page' ) {
            $search = " WHERE date LIKE '%" . $_POST['s'] . "%' ";
            $search .= " OR name LIKE '%" . $_POST['s'] . "%' ";
            $search .= " OR telephone LIKE '%" . $_POST['s'] . "%' ";
            $search .= " OR email LIKE '%" . $_POST['s'] . "%' ";
            $search .= " OR id LIKE '%" . $_POST['s'] . "%' ";
        }else{
            $search = '';
        }
        $subscribers = $wpdb->get_results( "SELECT * FROM wp_great_newsletter " . $search . " ORDER BY id DESC" );
        $subscriberstable->wp_great_newsletter_prepare_items( $subscribers );
        print '<input type="hidden" name="page" value="wp_great_newsletter_subscribers_page" />';
        $subscriberstable->search_box( 'search', 'search_id' );
        $subscriberstable->display();
        
    }
    
}

class wp_great_newsletter_list_table extends WP_List_Table {
    
    function wp_great_newsletter_prepare_items( $subscribers ) {
        $columns = $this->wp_great_newsletter_get_columns();
        $hidden = $this->wp_great_newsletter_get_hidden_columns();
        $sortable = $this->wp_great_newsletter_get_sortable_columns();
        $data = $this->wp_great_newsletter_table_data( $subscribers );   
        usort( $data, array( &$this, 'wp_great_newsletter_sort_data' ) );
        $perPage = $this->get_items_per_page('subscribers_per_page', 20);
        $currentPage = $this->get_pagenum();
        $totalItems = count( $data );
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
            )
        );
        $data = array_slice( $data,( ( $currentPage - 1 ) * $perPage ), $perPage );
        $this->_column_headers = array( $columns, $hidden, $sortable );
        $this->items = $data;
        $this->wp_great_newsletter_process_bulk_action();
    }
    
    function wp_great_newsletter_get_columns() {

        $columns = array(
            'cb'    => '<input type="checkbox" />',
            'id'    => __( 'ID', 'wp-great-newsletter' ),
            'date'  => __( 'Date', 'wp-great-newsletter' ),
            'name'  => __( 'Name', 'wp-great-newsletter' ),
            'email' => __( 'Email', 'wp-great-newsletter' ),
            'telephone' => __( 'Telephone', 'wp-great-newsletter' ),
        );
        
        return $columns;
        
    }

    function wp_great_newsletter_get_hidden_columns() {
        
        return array();
        
    }

    function wp_great_newsletter_get_sortable_columns() {
        
        return array(
            'id' => array( 'id', false ),
            'email' => array( 'email', false ),
            'date' => array( 'date', false ),
        );
        
    }
  
    function wp_great_newsletter_table_data( $subscribers ) {

        $data = array();
        $i = 1;
        foreach( $subscribers as $subscriber ) {
            $data[] = array(
                    'id'    => $subscriber->id,
                    'date'  => $subscriber->date,
                    'name'  => $subscriber->name,
                    'email' => $subscriber->email,
                    'telephone' => $subscriber->telephone,
                    );
            $i++;
        }
        
        return $data;
   
    }
    
    function get_bulk_actions() {
        $actions = array(
          'delete'    => 'Delete'
        );
        return $actions;
    }
    
    function wp_great_newsletter_process_bulk_action() {

        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {

            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Nope! Security check failed!' );

        }

        $action = $this->current_action();
        
        if( isset ( $_POST['id'] ) ) {
            
            global $wpdb;
            
            $deleteids = $_POST['id'];
            
            switch ( $action ) {
                case 'delete':
                    $ids = array();
                    foreach ( $deleteids as $id ) {
                        $id = (int) $id;
                        if ( $id ) {
                            $ids[] = $id;
                        }
                    }
                    $limit = count( $ids );
                    if ( $limit ) {
                        $ids = join( ',', $ids );
                        $deleterows = $wpdb->query( "DELETE FROM " . $wpdb->prefix . "great_newsletter WHERE id IN ($ids)" );
                        if( $deleterows == true ) {
                            wp_redirect( esc_url( add_query_arg() ) );
                        }  
                    }
                    break;
                default:
                    return;
                    break;
            }
        }

        return;
        
    }

    function column_cb( $item ) {
        return sprintf( '<input type="checkbox" name="id[]" value="%s" />', $item['id'] );
    }

    function column_default( $item, $column_name ) {
        switch( $column_name ) {
            case 'id':
            case 'date':
            case 'name':
            case 'email':
            case 'telephone':     
                return $item[$column_name];
            default:
                return print_r( $item, true ) ;
        }
        
    }

    function wp_great_newsletter_sort_data( $a, $b ) {
        
        $orderby = 'date';
        $order = 'asc';
        
        if( ! empty( $_GET['orderby'] ) ) {
            
            $orderby = $_GET['orderby'];
            
        }
        
        if( ! empty( $_GET['order'] ) ) {
            
            $order = $_GET['order'];
            
        }
        
        $result = strcmp( $a[$orderby], $b[$orderby] );
        
        if( $order === 'asc' ) {
            return $result;
        }
        
        return -$result;
        
    }
}

add_action( 'wp_ajax_wp_great_newsletter_suscribe_process', 'wp_great_newsletter_suscribe_process' );
add_action( 'wp_ajax_nopriv_wp_great_newsletter_suscribe_process', 'wp_great_newsletter_suscribe_process' );

function wp_great_newsletter_suscribe_process() {

    require_once( WP_GREAT_NEWSLETTER_DIR . 'includes/process-suscribe-form.php' );
    
    die;
}



add_action( "wp_ajax_wp_great_newsletter_unsuscribe_process", "wp_great_newsletter_unsuscribe_process" );
add_action( 'wp_ajax_nopriv_wp_great_newsletter_unsuscribe_process', 'wp_great_newsletter_unsuscribe_process' );

function wp_great_newsletter_unsuscribe_process() {

    require_once( WP_GREAT_NEWSLETTER_DIR . 'includes/process-unsuscribe-form.php' );

    die;
    
}

?>
