<?php

 // If uninstall is not called from WordPress, exit
  if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
  }
  else {
    delete_option('tg_facebook_comments_options');
	delete_post_meta_by_key( '_disable_tg_facebook_comments' );
  }
  
?>