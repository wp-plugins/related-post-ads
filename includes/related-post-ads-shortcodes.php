<?php

if ( ! defined('ABSPATH')) exit; // if direct access 



function related_post_ads_display($atts) {
	
		$atts = shortcode_atts(
			array(
				'themes' => "flat", //themes				

				), $atts);


			$themes = $atts['themes'];

			$html = '';

			if($themes== "flat")
				{
					$html.= related_post_ads_theme_flat();
				}			

			return $html;



		}

add_shortcode('related_post_ads', 'related_post_ads_display');



