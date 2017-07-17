<?php

// Display admin specific messages throughout the publishing workflow.

// notice-error (red)
// notice-warning (yellow)
// notice-success (green)
// notice-info (blue)

function lc_admin_admin_notice(){
  $postId = get_the_ID();
  global $pagenow;
 
if (in_array(get_post_type($postId), array('post', 'page', 'badges', 'lccc_announcement', 'lccc_events'))){ 
 
 if ( $pagenow == 'post.php' ){

   // Check if content is a draft of currently published page.
   $lc_publishedId = get_post_meta( $postId, '_lc_publishedId', true);
   if ( $lc_publishedId != '' ){

    echo '<div class="notice notice-info">';
    echo ' <p><strong>Notice:</strong> This is a draft of a published post.  Publishing this post will replace the published page and make the currently published version a revision.  You can view the currently published <a href="' . get_permalink($lc_publishedId) . '" target="_blank">version here</a>.';
    echo '</div>';
   }

   // Check if content currently has a draft created.
   $lc_draftId = get_post_meta( $postId, '_lc_draftId', true);
     if ( $lc_draftId != '' ){

    echo '<div class="notice notice-error">';
    echo ' <p><strong>Warning:</strong> This post currently has a draft/pending revision created.  Editing this post may cause issues with versioning of the content.  You may edit/publish the draft/pending revision of this <a href="post.php?action=edit&post=' . $lc_draftId . '">content here</a>.';
    echo '</div>';
   }
   
  }
 }
}
add_action( 'admin_notices', 'lc_admin_admin_notice' );

?>