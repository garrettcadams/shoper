<?php
global $pgscore_shortcodes;
extract($pgscore_shortcodes['pgscore_team_members']['atts']);

if( function_exists('get_field') ){
	$designation = get_field('designation');
}
?>
<div class="team">
	<div class="team-images">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'ciyashop-team-member-thumbnail-v', array(
				'class' => "img-fluid",
			) );
		}else{
			$member_img = array();
			$member_img[] = get_parent_theme_file_uri('/images/placeholder/team_members/259x482.png');
			$member_img[] = 259;
			$member_img[] = 482;
			?>
			<img class="img-fluid" src="<?php echo esc_url($member_img[0]);?>" width="<?php echo esc_attr($member_img[1]);?>" height="<?php echo esc_attr($member_img[2]);?>" alt="<?php echo esc_attr(get_the_title());?>">
			<?php
		}
		?>
	</div>
	<div class="team-description">
		<h4><?php echo esc_html(get_the_title());?></h4>
		<?php
		if( isset($designation) && $designation ){
			?>
			<span><?php echo esc_html($designation);?></span>
			<?php
		}
		?>
	</div>
	<?php pgscore_get_shortcode_templates('team_members/social-profiles/'.$style );?>
</div>