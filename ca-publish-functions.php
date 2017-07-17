<?php

 /*
  *
  *
  */

 

 // Filter wp_insert_post to status to pending review.
 // Filter for pages, badges, lccc-announcement, lccc-events
 // Add Email notification for new and updated posts

 function lc_dup_wp_insert_post($data, $postarr){

/*  if($data['post_type'] == 'post' || $data['post_type'] == 'page'){
   $postarr['post_status'] = 'pending';
   $data['post_status'] = 'pending';
   return $data;
  }*/

/*  if( ('lccc-event' == get_post_type() ) ){
  echo "------ Postarr -------\n\n";
  var_dump($postarr);
  echo "\n\n";
  echo "------ data -------\n\n";
  var_dump($data);
  echo "\n\n";
   }*/
 }

 //add_action('wp_insert_post_data', 'lc_dup_wp_insert_post', 15, 2);



 /*function newpage_admin_notice(){

  global $pagenow;
  if ( $pagenow == 'post-new.php' ){
   echo '<div class="notice notice-info">';
   echo '  <p>Click save draft to continue working on this page.  Clicking Submit for Review will notify the Admins to review the page and approve it.</p>';
   echo '</div>';
  }

  if ( $pagenow == 'post.php' ){
   if ( get_post_meta($_GET["post"]->ID, 'lc_publishedID') != '' ){
    echo '<div class="notice notice-info">';
    echo ' <p>Click save draft to continue working on this page.  Clicking Submit for Review will notify the Admins to review the page and approve it.</p>';
    echo '</div>';
   } else {
    echo '<div class="notice notice-info">';
    echo ' <p><strong>Editing this page will result in creating a duplicate for review.</strong>  When approved the page content will be added to the published post, and this copy will be deleted.</p>';
    echo '</div>';
   }
  }

 }

add_action( 'admin_notices', 'newpage_admin_notice' );*/

?>