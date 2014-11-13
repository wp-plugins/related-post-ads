<?php




if ( ! defined('ABSPATH')) exit; // if direct access 



function related_post_ads_merge_post_list($post_id)
	{
	
		$all_post_list = array_replace_recursive(related_post_ads_get_ads_list_by_tags($post_id),related_post_ads_get_ads_list_by_categories($post_id));
		
		return $all_post_list;
	
	}







function related_post_ads_get_ads_list_by_categories($post_id)
	{
		$related_post_ads_id = array();

		$cat = get_the_category($post_id);
		$category = $cat[0]->cat_name;
		
		
		
		
				$nextloop = new WP_Query(
					array (
						'post_type' => 'related_post',							
						'posts_per_page' => 5,
						
						'tax_query' => array(
							array(
								   'taxonomy' => 'related_post_cat',
								   'field' => 'name',
								   'terms' => $category,
							)
						)
						
						) );
		
		
		
		
		
		
		
	if ($nextloop->have_posts())
		{
			$i = 0;
			while ($nextloop->have_posts()) : $nextloop->the_post();
				{

					$related_post_ads_id[$i] =  get_the_ID();
					$i++;	
				}
			endwhile; 
			wp_reset_query(); 
		}

				
	return $related_post_ads_id;		
	
	
	}

function related_post_ads_get_ads_list_by_tags($post_id)
	{
		$related_post_ads_id = array();
		$tags = wp_get_post_tags($post_id);
		$tagIDs = array();
		if ($tags)
		{

			$tagcount = count($tags);
			for ($i = 0; $i < $tagcount; $i++) {
				
				$tagIDs[$i] = $tags[$i]->term_id;
				}
				
				$args = array('post_type' => 'related_post','tag__in' => $tagIDs, 'showposts' => 5);
				$my_query = new WP_Query($args);
				
				if ($my_query->have_posts())
					{
						
						$j = 0;
						while ($my_query->have_posts()) : $my_query->the_post();
							
							$related_post_ads_id[$j] =  get_the_ID();

							$j++;
						endwhile; 
						wp_reset_postdata();
					}


					
				}

				
		return $related_post_ads_id;
				
				
				
	}