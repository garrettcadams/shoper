<?php
// customize CPT Team Members field sets.
add_filter( 'team_details_group_575eac21bbfd0', 'ciyashop_team_details_group_fields' );
function ciyashop_team_details_group_fields( $fields ){
	unset( $fields['fields'][2] ); // Disable "Phone Number"
	unset( $fields['fields'][3] ); // Disable "Email"
	unset( $fields['fields'][4] ); // Disable "Short Description"
	unset( $fields['fields'][5] ); // Disable "Skills & Expertise Background"
	unset( $fields['fields'][8] ); // Disable "Skills" tab
	unset( $fields['fields'][9] ); // Disable "Skills Title"
	unset( $fields['fields'][10] ); // Disable "Skills"
	unset( $fields['fields'][11] ); // Disable "Expertise" tab
	unset( $fields['fields'][12] ); // Disable "Expertise Title"
	unset( $fields['fields'][13] ); // Disable "Expertises"
	
	return $fields;
}