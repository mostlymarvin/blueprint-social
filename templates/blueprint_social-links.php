<?php 
/** 
 * Social Media Link Display - set values in Customizer
 *  
 * @author    Memphis McKay
 * @package   Blueprint Social
 * @since     1.0.1
 */


$links = get_option('blueprint_social_links');
$links = json_decode( $links, true );

$markup = '';
$list = '';

if( $links ) {
        	
	foreach($links as $link) {
		
		$network = $link['network'];
		$url = $link['url'];

            if( $network && $url ) {

				if( $network === 'email' ) {
					$url = sanitize_email( $url );
				} else {
					$url = esc_url( $url );
				}

				$list .= sprintf(
					'<li><a href="%1$s" class="%2$s icon-%2$s" target="_blank"><span>%2$s</span></a></li>',
					$url,
					esc_attr( $network )
				);

			}
		}


	$markup = sprintf(
		'<ul class="blueprint-social">%1$s</ul>',
		$list
	);

	}

	echo $markup;