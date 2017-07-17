# LCCC Revisions

WordPress has the ability to allow for authors, and editors to function with a basic approval process, this process did not suit our needs.

### LCCC needs:
- No distiction between authors and editors.
- All editors need to be able to edit any page on the site.
- Need to create drafts from currently published pages
- Need to retain template setting for page/post
- Require approval process for various post types, built-in/custom post types
- Lightweight code - no slowing down of the site.

### Solution
We adapted code from (Live Drafts)[https://wordpress.org/plugins/live-drafts/] plugin.
The code targets our custom roles so the revisions just effect those user roles.  We also targeted a list of post types (post, page, lccc-events, lccc-announcements, badges).  When the post is new, nothing is done.  We allow WordPress to utilize the save draft and submit for review process.
If a post is currently published, a LCCC Editor has the ability to edit the post and save it as a draft. Custom admin notices instruct the user they can continue to click the, now orange, Save Draft button at the top of the publishing options panel.  If they are ready to submit for review they can do so with the re-labled submit button.  Once the page is in a submit for review status, the admin notice updates to let them know to continue to make changes to this post.  If an editor goes back to the original post the admin notice instructs them to use the current revision post, whether saved as a draft or in review status.

An administrator, who has publishing privileges, will receive an email alerting them that either a new post is ready for review, or a currently published post's new draft is ready for review.  If the post is a draft/revision of a currently published post then during the update function we intercept the post and update the currently publishe post with the post data and meta from the revision and delete the revision from the database.

