<?php



 function lc_notify_admins_pending_post( $new_status, $old_status, $post ){
  
   // Alert admins when posts are submitted for review
  if ($new_status == 'pending' || $old_status == 'draft' ){
   $emailto = get_option( 'admin_email' );
   
   $subject = 'Pending Revision Submitted: ' . get_the_title($post->ID);
   
   $message = 'A pending revision to the ' . $post_type->labels->singular_name . ' "' . get_the_title($post->ID) . '" has been submitted.';
   
   $author_id = $post->post_author;
   $author_name = the_author_meta('user_nicename', $author_id );
   
   $message .= 'It was submitted by ' . $author_name . '.';
   $message .= 'Review it here: ' . get_edit_post_link( $post->ID );
   
   wp_mail( $emailto, $subject, $message);
  }
  
  //Notify the author the pending item was published.
  
  if ($new_status == 'publish' || $old_status == 'pending' ){
      
   $author_id = $post->post_author;
   $author_email = the_author_meta('user_email', $author_id );
   
   $emailto = $author_email;
   
   $subject = 'Published ' . get_the_title($post->ID);
   
   $message = 'Your ' . $post_type->labels->singular_name . ' titled "' . get_the_title($post->ID) . '" has been published.';

   $message .= 'View it here: ' . get_permalink( $post->ID );
   
   wp_mail( $emailto, $subject, $message);
  }
 }

add_action( 'transition_post_status', 'lc_notify_admins_pending_post', 10, 3);
?>