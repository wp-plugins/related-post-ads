<?php

if ( ! defined('ABSPATH')) exit; // if direct access 

function related_post_ads_theme_flat()
	{
		$post_id = get_the_ID();
	

			
		$html = '';
		$all_ads_ids = related_post_ads_merge_post_list($post_id);
		
		if(!empty($all_ads_ids))
			{
				
			$html .= '<div  class="related-post-ads flat" >';	
			$html .= '<div  class="related-post-ads-head" >Related Post Ads</div>';	
			$html .= '<ul class="post-list">';
			
			
	
					
				$args = array('post_type' => 'related_post', 'post__in' => $all_ads_ids ,'showposts' => 5);
				
				$my_query = new WP_Query($args);
				
				if ($my_query->have_posts())
					{
						
						while ($my_query->have_posts()) : $my_query->the_post();
						
							$related_post_url = get_post_meta( get_the_ID(), 'related_post_url', true );
						
						
							$thumb_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
							
							
							
							$html .= '<li class="related-post-single">';
							$html.= '<a href="'.$related_post_url.'" >';
							$html .= '<div class="related-post-ads-thumb"><img src="'.$thumb_url.'" /></div>';
							$html .= get_the_title('', '', true, '40');
							$html .= '</a>';
							$html .= '</li>';
						
						endwhile; 
						wp_reset_postdata(); 
					}
				else
					{
							$html .= '<li class="related-post-single">No Post Found';
							$html .= '</li>';
					
					
					}	
				
				
				
				
	
							
			$html .= '</ul  >';
			$html .= '</div>'; // end 
			
		}
		
		
		return $html;

		
		
	}