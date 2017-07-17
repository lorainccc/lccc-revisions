<?php

class lc_contentpublish {

  // Change publish/update button label
 // Filter for pages,
 // badges - post type: badges,
 // lccc-announcement- post type: lccc_announcement,
 // lccc-events- post type: lccc_events

 
  
  function lc_contentpublish(){
  
   
			// Admin head
			add_action('save_post', array($this, 'lc_post_update'), 10);
   add_action( 'publish_future_post', array($this, 'lc_post_update'), 10);
   
  }
 
  // Allowing Admins/Editors to publish pending posts
  function lc_post_update($id){
   if ((isset($_REQUEST['publish']) && $_REQUEST['publish'] !='Schedule') || (defined( 'DOING_CRON' ) && DOING_CRON)) {
    
    // Checking to see if this is a pending revision of a currently published post
    $_lc_publishedId = get_post_meta($id, '_lc_publishedId', true);
    
    // If this post is then update currently published page
    if ($_lc_publishedId != false){
     $lc_updatePost = array(
      'ID' => $_lc_publishedId,
      'menu_order' => $_REQUEST['menu_order'],
      'comment_status' => ($_REQUEST['comment_status'] == 'open' ? 'open' : 'closed'),
      'ping_status' => ($_REQUEST['ping_status'] == 'open' ? 'open' : 'closed'),
      'post_author' => $_REQUEST['post_author'],
      'post_category' => (isset($_REQUEST['post_category']) ? $_REQUEST['post_category'] : array()),
      'post_content' => $_REQUEST['content'],
      'post_excerpt' => $_REQUEST['excerpt'],
      'post_parent' => $_REQUEST['parent_id'],
      'post_password' => $_REQUEST['post_password'],
      'post_status' => 'publish',
      'post_title' => $_REQUEST['post_title'],
      'post_type' => $_REQUEST['post_type'],
      'tags_input' => (isset($_REQUEST['tax_input']['post_tag']) ? $_REQUEST['tax_input']['post_tag'] : ''),
      'page_template' => $_REQUEST['page_template']    
     );
    
     // update currently published page
     wp_update_post($lc_updatePost);
     
     // clear existing meta data (currently published post meta)
     $lc_existing = get_post_custom($_lc_publishedId);
     foreach ($lc_existing as $ekey => $evalue){
      delete_post_meta($_lc_publishedId, $ekey);
     }
     
     // copy meta from pending revision (update post meta)
     $custom = get_post_custom($id);
     foreach ($custom as $ckey => $cvalue) {
      if ($ckey != '_edit_lock' && $ckey != '_edit_last' && $ckey != '_lc_publishedId'){
       foreach ($cvalue as $mvalue){
        add_post_meta($_lc_publishedId, $ckey, $mvalue, true);
       }
      }
     }
     
     // delete draft post, force delete since 2.9, no sending to trash
     wp_delete_post($id, true);
     
     // send user to live edit page
     wp_redirect(admin_url('post.php?action=edit&$post=' . $_lc_publishedId));
     exit();
     
    }
    
    
   }
  }
 
}
add_action('init', create_function('', 'global $lc_contentpublish; $lc_contentpublish = new lc_contentpublish();'));

?>