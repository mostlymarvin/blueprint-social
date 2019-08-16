<?php 
/** 
 * Social Media Link Display - set values in Customizer
 *  
 * @author    Memphis McKay
 * @package   Blueprint Social
 * @since     1.0.1
 */


$links = get_option('blueprint_social_links');

$markup = '';
$list = '';

if( $links ) {
	
	$links = explode(',', $links);
        	
	foreach($links as $link) {
		
		$link = explode( '|', $link );
              
            if( $link[0] && $link[1]) {

				$network = $link[0];
				$url = esc_url( $link[1] );

				if( $network === 'email' ) {
					$url = sanitize_email( $link[1] );
				}

				$list .= sprintf(
					'<li><a href="%1$s" class="%2$s icon-%2$s" target="_blank"><span>%2$s</span></a></li>',
					$url,
					esc_attr($network)
				);

			}
		}


	$markup = sprintf(
		'<ul class="blueprint-social">%1$s</ul>',
		$list
	);

	}

	echo $markup;