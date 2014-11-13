<?php


if ( ! defined('ABSPATH')) exit; // if direct access 

add_action('init', 'related_post_register');
 
function related_post_register() {
 
        $labels = array(
                'name' => _x('Related Post Ads', 'post type general name'),
                'singular_name' => _x('Related Post Ads', 'post type singular name'),
                'add_new' => _x('New Related Post', 'related_post'),
                'add_new_item' => __('New Related Post'),
                'edit_item' => __('Edit Related Post'),
                'new_item' => __('New Related Post'),
                'view_item' => __('View Related Post'),
                'search_items' => __('Search Related Post'),
                'not_found' =>  __('Nothing found'),
                'not_found_in_trash' => __('Nothing found in Trash'),
                'parent_item_colon' => ''
        );
 
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'menu_icon' => null,
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title','editor','thumbnail'),
				'menu_icon' => 'dashicons-images-alt',
				'taxonomies' => array('post_tag')
				

          );
 
        register_post_type( 'related_post' , $args );

}



// Custom Taxonomy
 
function add_related_post_taxonomies() {
 
        register_taxonomy('related_post_cat', 'related_post', array(
                // Hierarchical taxonomy (like categories)
                'hierarchical' => true,
                'show_admin_column' => true,
                // This array of options controls the labels displayed in the WordPress Admin UI
                'labels' => array(
                        'name' => _x( 'Category', 'taxonomy general name' ),
                        'singular_name' => _x( 'Category', 'taxonomy singular name' ),
                        'search_items' =>  __( 'Search Categories' ),
                        'all_items' => __( 'All Categories' ),
                        'parent_item' => __( 'Parent Category' ),
                        'parent_item_colon' => __( 'Parent Category:' ),
                        'edit_item' => __( 'Edit Category' ),
                        'update_item' => __( 'Update Category' ),
                        'add_new_item' => __( 'Add New Category' ),
                        'new_item_name' => __( 'New Category Name' ),
                        'menu_name' => __( 'Categories' ),

                ),
                // Control the slugs used for this taxonomy
                'rewrite' => array(
                        'slug' => 'related_post_cat', // This controls the base slug that will display before each term
                        'with_front' => false, // Don't display the category base before "/locations/"
                        'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
                ),
        ));
}
add_action( 'init', 'add_related_post_taxonomies', 0 );









/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function meta_boxes_related_post()
	{
		$screens = array( 'related_post' );
		foreach ( $screens as $screen )
			{
				add_meta_box('related_post_metabox',__( 'Related Post Options','related_post' ),'meta_boxes_related_post_input', $screen);
			}
	}
add_action( 'add_meta_boxes', 'meta_boxes_related_post' );


function meta_boxes_related_post_input( $post ) {
	
	global $post;
	wp_nonce_field( 'meta_boxes_related_post_input', 'meta_boxes_related_post_input_nonce' );
	


	$related_post_url = get_post_meta( $post->ID, 'related_post_url', true );








?>


    <div class="para-settings">
		<div class="option-box">
			<p class="option-title">Target URL</p>
 			<p class="option-info"></p>
			<input type="text" size="30" placeholder="http://example.com/landing-page/"   name="related_post_url" value="<?php if(!empty($related_post_url)) echo $related_post_url; ?>" />
		</div>
        

	</div> <!-- para-settings -->



<?php


	
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function meta_boxes_related_post_save( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['meta_boxes_related_post_input_nonce'] ) )
    return $post_id;

  $nonce = $_POST['meta_boxes_related_post_input_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'meta_boxes_related_post_input' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;



  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
  
 	$related_post_url = sanitize_text_field( $_POST['related_post_url'] );
 	update_post_meta( $post_id, 'related_post_url', $related_post_url );




}
add_action( 'save_post', 'meta_boxes_related_post_save' );






































?>