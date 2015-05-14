<?php
if( ! empty( $_POST['Submit'] ) && $_POST['Submit'] == 'Export all subscribers' ) {

    header("Location: ".WP_GREAT_NEWSLETTER_URL."admin/includes/export-subscribers-xls.php");
	 
}
?>

<div class="container">
    <div id="block">
        <div class="wgc-box">
            <div class="header medium">
                <?php _e('<h4>Subscribers List</h4>', 'wp-great-newsletter'); ?>
            </div>
            <div class="wgc-box-body">
                <form method="POST">
                    <input type="submit" name="Submit" id="Submit" class="button-primary" value="Export all subscribers" />
                </form>
                <form name="wp_great_newsletter_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                    <?php wp_great_newsletter_subscribers_list(); ?>
                </form>
            </div>
        </div>
    </div>
</div>