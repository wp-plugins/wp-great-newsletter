<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-config.php' );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-includes/wp-db.php' );

$sql = $wpdb->get_results( "SELECT * FROM wp_great_newsletter ORDER BY id DESC" );
  
$html = '<table>';
    $html .= '<tr>';
        $html .= '<td>ID</td>';
        $html .= '<td>Date</td>';
        $html .= '<td>Name</td>';
        $html .= '<td>Email</td>';
        $html .= '<td>Telephone</td>';
    $html .= '</tr>';
    foreach ( $sql as $envio ) {
        $html .= '<tr>';
            $html .= '<td>' . $envio->id . '</td>';
            $html .= '<td>' . $envio->date . '</td>';
            $html .= '<td>' . utf8_decode( $envio->name ) . '</td>';
            $html .= '<td>' . $envio->email . '</td>';
            $html .= '<td>' . $envio->telephone . '</td>';
        $html .= '</tr>';
    }
$html .= '</table>';

header( 'Content-Type: application/xls' );    
header( 'Content-Disposition: attachment; filename=wp_great_newsletter_my_subscribers.xls' );  
header( 'Pragma: no-cache' ); 
header( 'Expires: 0' );

echo $html;

?>
