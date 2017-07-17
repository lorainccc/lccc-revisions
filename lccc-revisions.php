<?php
/*
Plugin Name: LCCC Revisions
Plugin URI:        http://www.lorainccc.edu
Description: Allows certain user groups to create drafts of published post types, without removing the currently published version.
Version:           1.0.0
Author:            LCCC Web Dev Team
Author URI:        http://www.lorainccc.edu
*/
/* Start Adding Functions Below this Line */

 // Check user roles and

function lc_revisions_wp_admin_scripts() {
 wp_enqueue_style('lc_revisions_admin_styles', plugin_dir_url( __FILE__ ) . 'css/admin.css', 9);

}
add_action( 'admin_enqueue_scripts', 'lc_revisions_wp_admin_scripts' );

 class lc_check_user {

  public function __construct(){
   add_action( 'plugins_loaded', array( $this, 'lc_check_user_can' ) );
  }

  public function lc_check_user_can(){
   
   if(current_user_can('administrator') != true ){
     if(current_user_can_for_blog( get_current_blog_id(), 'lccc_edit') == true || current_user_can_for_blog( get_current_blog_id(), 'lccc_adv_edit') == true ){
      
        add_filter( 'gettext', 'lc_change_publish_button', 10, 2 );

        //require_once( plugin_dir_path( __FILE__ ).'ca-publish-functions.php' );
        require_once( plugin_dir_path( __FILE__ ).'draft-button.php' );
        require_once( plugin_dir_path( __FILE__ ).'lc-post-notifications.php' );
      
        // Custom Messages at the top of the page/post editor. 
        require_once( plugin_dir_path( __FILE__ ).'lc-user-messages.php' );
     } 
    }
   
   if(current_user_can('editor')){
      require_once( plugin_dir_path( __FILE__ ).'ca-admin-publish.php' );
      require_once( plugin_dir_path( __FILE__ ).'lc-admin-messages.php' );
    }
  }

 }

$lc_check_user_plugin = new lc_check_user();

      //Change Publish Buttons

      function lc_change_publish_button( $translation, $text ) {
         if( ( 'post' == get_post_type() || 'page' == get_post_type() || 'lccc_announcement' == get_post_type() ) && $text == 'Update'  ){
          return 'Save as Draft';
         }  else {
          return $translation;
         }
         if ( ( 'post' == get_post_type() || 'page' == get_post_type() ) && $text  == 'Publish' ) {
          return 'Submit for Review';
         } else {
          return $translation;
         }
      }



/* Stop Adding Functions Below this Line */
?>