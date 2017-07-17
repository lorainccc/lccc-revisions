<?php

 class lc_contentdrafts {

  // Change publish/update button label
 // Filter for pages,
 // badges - post type: badges,
 // lccc-announcement- post type: lccc_announcement,
 // lccc-events- post type: lccc_events

 
  
  function lc_contentdrafts(){
  
   
			// Admin head
			add_action('admin_head-post.php', array($this, 'adminHead'));
   add_action( 'pre_post_update', array($this, 'lc_pre_post_update') );
   
  }
  

  
  // Already published pages, remove update button and replace with Save Draft button.
  
  function adminHead () {
			global $post;

			// Only show on published pages
			if (in_array($post->post_type, array('post', 'page', 'badges', 'lccc_announcement', 'lccc_events')) && $post->post_status == 'publish') {
				?>
				<script type="text/javascript">

					// Add save draft button to live pages
					jQuery(function($) {

						$('<input type="submit" class="button button-primary button-large" tabindex="4" value="Save as Draft" id="save-post" name="save" style="float:right; width:115px;">').prependTo('#publishing-action');
      $("input[id=publish]").hide();
					});

				</script>
				<?php
			} elseif (in_array($post->post_type, array('post', 'page', 'badges', 'lccc_announcement', 'lccc_events')) && $post->post_status == 'draft' ){
				?>
				<script type="text/javascript">

					// Add save draft button to live pages
					jQuery(function($) {
      $("input[id=save-post]").addClass('lc-draft');
     });

				</script>
				<?php
			}
  }


 function lc_pre_post_update($id){
  if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
   return $id;

  if( !in_array( $_POST['post_type'], array('post', 'page', 'badges', 'lccc_announcement', 'lccc_events') ) ){
   return $id;
  }

  
  // If a post is previously published, but now an lccc editor or lccc advanced editor is looking to update it
  // we grab the post and duplicate it and set it to pending.
  
  if( $_REQUEST['save'] == 'Save as Draft' && $_REQUEST['post_status'] == 'publish' ) {
   $lc_draftPost = array(
     'menu_order' => $_REQUEST['menu_order'],
     'comment_status' => ($_REQUEST['comment_status'] == 'open' ? 'open' : 'closed'),
				 'ping_status' => ($_REQUEST['ping_status'] == 'open' ? 'open' : 'closed'),
				 'post_author' => $_REQUEST['post_author'],
				 'post_category' => (isset($_REQUEST['post_category']) ? $_REQUEST['post_category'] : array()),
				 'post_content' => $_REQUEST['content'],
				 'post_excerpt' => $_REQUEST['excerpt'],
				 'post_parent' => $_REQUEST['parent_id'],
				 'post_password' => $_REQUEST['post_password'],
				 'post_status' => 'draft',
				 'post_title' => $_REQUEST['post_title'],
				 'post_type' => $_REQUEST['post_type'],
				 'tags_input' => (isset($_REQUEST['tax_input']['post_tag']) ? $_REQUEST['tax_input']['post_tag'] : ''),
     'page_template' => $_REQUEST['page_template']    
   );
   
   // Insert Post into Database (Creating a new draft post)
   $newId = wp_insert_post($lc_draftPost);
   
   // Add Post Meta from REQUEST object
   if( isset($_REQUEST['meta']) ){
    foreach ( $_REQUEST['meta'] as $key => $value ){
     if ($key != '_edit_lock' && $key != '_edit_last'){
      foreach ($value as $newvalue){
       add_post_meta($newId, $key, $newvalue, true);
      }
     }
    }
   }
   
   // Add Post Meta Field to new post to indicate this is a draft of a live page
   update_post_meta($newId, '_lc_publishedId', $id);
   
   // Add Post Meta Field to previously published post to indicate there is a draft of it.
   update_post_meta($id, '_lc_draftId', $newId);
   
   // Send user to new edit page
   wp_redirect(admin_url('post.php?action=edit&post=' . $newId));
   exit();
  }

 }
  
 }

add_action('init', create_function('', 'global $lc_contentdrafts; $lc_contentdrafts = new lc_contentdrafts();'));

?>