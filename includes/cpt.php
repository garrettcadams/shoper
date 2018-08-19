<?php
add_filter( 'pgscore_register_cpt_teams', 'ciyashop_extend_pgscore_register_cpt_teams' );
function ciyashop_extend_pgscore_register_cpt_teams( $args ){
	$args['public'] = false;
	$args['publicly_queryable'] = false;
	
	return $args;
}