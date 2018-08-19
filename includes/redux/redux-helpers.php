<?php
function ciyashop_social_media_lists($custom = true){
	$social_media_lists = array(
		'facebook'  => esc_html__('Facebook', 'ciyashop' ),
		'twitter'   => esc_html__('Twitter', 'ciyashop' ),
		'googleplus'=> esc_html__('Google+', 'ciyashop' ),
		'dribbble'  => esc_html__('Dribbble', 'ciyashop' ),
		'vimeo'     => esc_html__('Vimeo', 'ciyashop' ),
		'pinterest' => esc_html__('Pinterest', 'ciyashop' ),
		'linkedin'  => esc_html__('LinkedIn', 'ciyashop' ),
		'youtube'   => esc_html__('Youtube', 'ciyashop' ),
		'instagram' => esc_html__('Instagram', 'ciyashop' ),
		'behance'   => esc_html__('Behance', 'ciyashop' ),
	);
	
	if ( $custom ) {
		$social_media_lists['custom'] = esc_html__('Custom', 'ciyashop' );
	}
	
	return apply_filters( 'ciyashop_social_media_lists', $social_media_lists );
}

/*
 * Return Redux typography backup font family
 */
function ciyashop_redux_typography_font_backup(){
	$fonts = array(
		'sans-serif'                                          => 'sans-serif',
		"Arial, Helvetica"                                    => "Arial, Helvetica, sans-serif",
		"'Arial Black', Gadget, sans-serif"                   => "'Arial Black', Gadget, sans-serif",
		"'Bookman Old Style', serif"                          => "'Bookman Old Style', serif",
		"'Comic Sans MS', cursive"                            => "'Comic Sans MS', cursive",
		"Courier, monospace"                                  => "Courier, monospace",
		"Garamond, serif"                                     => "Garamond, serif",
		"Georgia, serif"                                      => "Georgia, serif",
		"Impact, Charcoal, sans-serif"                        => "Impact, Charcoal, sans-serif",
		"'Lucida Console', Monaco, monospace"                 => "'Lucida Console', Monaco, monospace",
		"'Lucida Sans Unicode', 'Lucida Grande', sans-serif"  => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
		"'MS Sans Serif', Geneva, sans-serif"                 => "'MS Sans Serif', Geneva, sans-serif",
		"'MS Serif', 'New York', sans-serif"                  => "'MS Serif', 'New York', sans-serif",
		"'Palatino Linotype', 'Book Antiqua', Palatino, serif"=> "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
		"Tahoma,Geneva, sans-serif"                           => "Tahoma, Geneva, sans-serif",
		"'Times New Roman', Times,serif"                      => "'Times New Roman', Times, serif",
		"'Trebuchet MS', Helvetica, sans-serif"               => "'Trebuchet MS', Helvetica, sans-serif",
		"Verdana, Geneva, sans-serif"                         => "Verdana, Geneva, sans-serif",
	);
	return apply_filters( 'ciyashop_redux_typography_font_backup', $fonts );
}