<?php

 // Display various messages through the publishing workflow.

function lc_user_admin_notice(){
   $postId = get_the_ID();
 if (in_array(get_post_type($postId), array('post', 'page', 'badges', 'lccc_announcement', 'lccc_events'))){
  global $pagenow;
  if ( $pagenow == 'post-new.php' ){
   echo '<div class="notice notice-info">';
   echo '  <p>Click save draft to continue working on this page.  Clicking Submit for Review will notify the Admins to review the page and approve it.</p>';
   echo '</div>';
  }

  if ( $pagenow == 'post.php' ){

   $lc_publishedId = get_post_meta( $postId, '_lc_publishedId', true);
   $lc_draftId = get_post_meta( $postId, '_lc_draftId', true);
   $post_status = get_post_status($postId);
//   echo "Draft: " . $lc_draftId . "<br />";
//   echo "Published: " . $lc_publishedId . "<br />";
//   echo "ID: " . get_the_ID() . "<br />";
   if ( $lc_draftId != '' ){

    echo '<div class="notice notice-error">';
    echo ' <p><strong>Warning:</strong> there is already a draft of this post.  Please update/publish the draft instead of updating this version, and creating another draft.  <a href="post.php?action=edit&post=' . $lc_draftId . '">Click here to edit the draft</a></p>';
    echo '</div>';
   } elseif($lc_publishedId != '' && $post_status == 'pending' ) {
    echo '<div class="notice notice-info">';
     echo ' <p>Click "Submit for Review" to make updates to this page.</p>';
    echo '</div>';
   } elseif($lc_publishedId != '' ) {
    echo '<div class="notice notice-info">';
     echo ' <p>Click "Save Draft" (orange button) to continue working on this page.  Clicking the "Submit for Review" button will notify the Admins to review the page and approve it.</p>';
    echo '</div>';

   } else {
    
    echo '<div class="notice notice-info">';
    echo ' <p><strong>Editing this page will result in creating a duplicate for review.</strong>  When approved the page content will be added to the published post, and this copy will be deleted.</p>';
    echo '</div>';
   }
  }
 }
}

add_action( 'admin_notices', 'lc_user_admin_notice' );

?>