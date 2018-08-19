(function($){
	"use strict";
	
	jQuery(document).ready(function($) {
		if( $("#redux-form-wrapper").length != 0 ) {
			
			var instagram_api_url    = 'https://instagram.com/oauth/authorize/';
			var client_id            = '';
			var scope                = 'basic+public_content+comments';
			var redirect_uri         = ciyashop_admin.theme_options_url;
			var response_type        = 'token';
			
			var access_token_url     = '';
			
			var at_received_status   = false;
			var at_received_data     = '';
			var at_received_token    = '';
			
			// Fetch hash key
			var url_hash = location.hash.substring(1);
			if( url_hash != '' ){
				var at_received_data = JSON.parse('{"' + decodeURI(url_hash.replace(/&/g, "\",\"").replace(/=/g,"\":\"")) + '"}');
				if( at_received_data.access_token != '' ){
					at_received_status = true;
					at_received_token  = at_received_data.access_token;
				}
			}
			
			if( at_received_status && at_received_token != '' ){
				jQuery('#ciyashop_options-instagram_access_token #instagram_access_token').val(at_received_token);
				jQuery("#redux-sticky #redux_save").trigger("click");
			}
			
			$("#generate_access_token-buttonsetgenerate_access_token").on( "click", function() {
				client_id = jQuery('#instagram_client_id').val();
				access_token = jQuery('#instagram_access_token').val();
				
				if( client_id == '' ){
					alert('Please enter Client ID to proceed.');
				}else{
					access_token_url = instagram_api_url+"?"+"client_id="+client_id+"&"+"scope="+scope+"&"+"redirect_uri="+redirect_uri+"&"+"response_type="+response_type;
					
					window.onbeforeunload = null;
					
					// similar behavior as an HTTP redirect
					window.location.replace(access_token_url);
				}
			});
			
		}
		
		var instagram_redirect_uris_clipboard = new ClipboardJS('.instagram_redirect_uris-clipboard', {
			target: function() {
				// return $('#instagram_redirect_uris');
				return document.querySelector('#instagram_redirect_uris');
			}
		});
		
		instagram_redirect_uris_clipboard.on('success', function(e) {
			e.clearSelection();
			$('#instagram_redirect_uris').removeClass("clipboard-copied");
			setTimeout(function() {
				$('#instagram_redirect_uris').addClass("clipboard-copied");
			}, 1);
		});
		
		$('.system-status-content .cs-status-tooltip').tooltip({
			'container': '.ciyashop-welcome .system-status-content',
			'placement': 'bottom',
		});
		
	});
	
})(jQuery);