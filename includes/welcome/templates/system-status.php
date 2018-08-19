<?php
$system_status    = $this->system_status;
$environment      = $system_status->get_environment_info();
$post_type_counts = $system_status->get_post_type_counts();
$active_plugins   = $system_status->get_active_plugins();
$theme            = $system_status->get_theme_info();

$recommendations = array(
	'wp_memory_limit'    => '128M',
	'mysql_version'      => '5.6',
	'max_execution_time' => '180',
	'max_input_time'     => '600',
	'upload_max_filesize'=> '32M',
	'post_max_size'      => '128M',
);
?>
<table class="cs_status_table table table-striped table-hover" cellspacing="0">
	<thead>
		<tr>
			<th colspan="3" data-export-label="WordPress Environment"><h2><?php esc_html_e( 'WordPress environment', 'ciyashop' ); ?></h2></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td data-export-label="Home URL"><?php esc_html_e( 'Home URL', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The homepage URL of your site.', 'ciyashop' );?>">[?]</a></td>
			<td><?php echo esc_html( $environment['home_url'] ); ?></td>
		</tr>
		<tr>
			<td data-export-label="Site URL"><?php esc_html_e( 'Site URL', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The root URL of your site.', 'ciyashop' );?>">[?]</a></td>
			<td><?php echo esc_html( $environment['site_url'] ); ?></td>
		</tr>
		
		<tr>
			<td data-export-label="WP Version"><?php esc_html_e( 'WordPress version', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The version of WordPress installed on your site.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				$latest_version = get_transient( 'woocommerce_system_status_wp_version_check' );

				if ( false === $latest_version ) {
					$version_check = wp_remote_get( 'https://api.wordpress.org/core/version-check/1.7/' );
					$api_response  = json_decode( wp_remote_retrieve_body( $version_check ), true );

					if ( $api_response && isset( $api_response['offers'], $api_response['offers'][0], $api_response['offers'][0]['version'] ) ) {
						$latest_version = $api_response['offers'][0]['version'];
					} else {
						$latest_version = $environment['wp_version'];
					}
					set_transient( 'woocommerce_system_status_wp_version_check', $latest_version, DAY_IN_SECONDS );
				}

				if ( version_compare( $environment['wp_version'], $latest_version, '<' ) ) {
					/* Translators: %1$s: Current version, %2$s: New version */
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> '
					. sprintf( esc_html__( '%1$s - There is a newer version of WordPress available (%2$s)', 'ciyashop' ),
						esc_html( $environment['wp_version'] ),
						esc_html( $latest_version )
					)
					. '</mark>';
				} else {
					echo '<mark class="yes">' . esc_html( $environment['wp_version'] ) . '</mark>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="WP Multisite"><?php esc_html_e( 'WordPress multisite', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Whether or not you have WordPress Multisite enabled.', 'ciyashop' );?>">[?]</a></td>
			<td><?php
			if ( $environment['wp_multisite'] ) {
				?><span class="dashicons dashicons-yes"></span><?php
			}else{
				?>&ndash;<?php
			}
			?></td>
		</tr>
		<tr>
			<td data-export-label="WP Memory Limit"><?php esc_html_e( 'WordPress memory limit', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The maximum amount of memory (RAM) that your site can use at one time.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( $environment['wp_memory_limit'] < $system_status->size_to_num($recommendations['wp_memory_limit']) ) {
					/* Translators: %1$s: Memory limit, %2$s: Docs link, %3$s: Recommended Memory. */
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' .
					sprintf( esc_html__( '%1$s - We recommend setting memory to at least %3$s. See: %2$s', 'ciyashop' ),
						esc_html( size_format( $environment['wp_memory_limit'] ) ),
						'<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" rel="noopener" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', 'ciyashop' ) . '</a>',
						$recommendations['wp_memory_limit']
					)
					. '</mark>';
				} else {
					echo '<mark class="yes">' . esc_html( size_format( $environment['wp_memory_limit'] ) ) . '</mark>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="WP Debug Mode"><?php esc_html_e( 'WordPress debug mode', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Displays whether or not WordPress is in Debug Mode.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php if ( $environment['wp_debug_mode'] ) : ?>
					<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
				<?php else : ?>
					<mark class="no">&ndash;</mark>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td data-export-label="WP Cron"><?php esc_html_e( 'WordPress cron', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Displays whether or not WP Cron Jobs are enabled.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php if ( $environment['wp_cron'] ) : ?>
					<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
				<?php else : ?>
					<mark class="no">&ndash;</mark>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td data-export-label="Language"><?php esc_html_e( 'Language', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The current language used by WordPress. Default = English', 'ciyashop' );?>">[?]</a></td>
			<td><?php echo esc_html( $environment['language'] ); ?></td>
		</tr>
		<tr>
			<td data-export-label="External object cache"><?php esc_html_e( 'External object cache', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Displays whether or not WordPress is using an external object cache.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php if ( $environment['external_object_cache'] ) : ?>
					<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>
				<?php else : ?>
					<mark class="no">&ndash;</mark>
				<?php endif; ?>
			</td>
		</tr>
	</tbody>
</table>
<table class="cs_status_table table table-striped table-hover" cellspacing="0">
	<thead>
		<tr>
			<th colspan="3" data-export-label="Server Environment"><h2><?php esc_html_e( 'Server environment', 'ciyashop' ); ?></h2></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td data-export-label="Server Info"><?php esc_html_e( 'Server info', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Information about the web server that is currently hosting your site.', 'ciyashop' );?>">[?]</a></td>
			<td><?php echo esc_html( $environment['server_info'] ); ?></td>
		</tr>
		<tr>
			<td data-export-label="PHP Version"><?php esc_html_e( 'PHP version', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The version of PHP installed on your hosting server.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( version_compare( $environment['php_version'], '7.2', '>=' ) ) {
					echo '<mark class="yes">' . esc_html( $environment['php_version'] ) . '</mark>';
				} else {
					$update_link = ' <a href="https://docs.woocommerce.com/document/how-to-update-your-php-version/" rel="noopener" target="_blank">' . esc_html__( 'How to update your PHP version', 'ciyashop' ) . '</a>';
					$class       = 'error';

					if ( version_compare( $environment['php_version'], '5.4', '<' ) ) {
						$notice = '<span class="dashicons dashicons-warning"></span> ' . __( 'WooCommerce will run under this version of PHP, however, some features such as geolocation are not compatible. Support for this version will be dropped in the next major release. We recommend using PHP version 7.2 or above for greater performance and security.', 'ciyashop' ) . $update_link;
					} elseif ( version_compare( $environment['php_version'], '5.6', '<' ) ) {
						$notice = '<span class="dashicons dashicons-warning"></span> ' . __( 'WooCommerce will run under this version of PHP, however, it has reached end of life. We recommend using PHP version 7.2 or above for greater performance and security.', 'ciyashop' ) . $update_link;
					} elseif ( version_compare( $environment['php_version'], '7.2', '<' ) ) {
						$notice = __( 'We recommend using PHP version 7.2 or above for greater performance and security.', 'ciyashop' ) . $update_link;
						$class  = 'recommendation';
					}

					echo '<mark class="' . esc_attr( $class ) . '">' . esc_html( $environment['php_version'] ) . ' - ' . wp_kses_post( $notice ) . '</mark>';
				}
				?>
			</td>
		</tr>
		<?php if ( function_exists( 'ini_get' ) ) : ?>
			<tr>
				<td data-export-label="PHP Post Max Size"><?php esc_html_e( 'PHP post max size', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Maximum size of POST data contained in one post. To upload large files, this value must be larger than upload_max_filesize.', 'ciyashop' );?>">[?]</a></td>
				<td>
					<?php
					if ( $environment['php_post_max_size'] < $system_status->size_to_num($recommendations['post_max_size']) ) {
						/* Translators: %1$s: Memory limit, %2$s: Docs link, %3$s: Recommended Memory. */
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' .
						sprintf( esc_html__( '%1$s - We recommend setting maxium post size to at least %3$s. See: %2$s', 'ciyashop' ),
							esc_html( size_format( $environment['php_post_max_size'] ) ),
							'<a href="http://www.wpbeginner.com/wp-tutorials/how-to-increase-the-maximum-file-upload-size-in-wordpress/" rel="noopener" target="_blank">' . esc_html__( 'Increase the Maximum Post Size', 'ciyashop' ) . '</a>',
							$recommendations['post_max_size']
						)
						. '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( size_format( $environment['php_post_max_size'] ) ) . '</mark>';
					}
					?>
				</td>
			</tr>
			<tr>
				<td data-export-label="PHP Max Upload Size"><?php esc_html_e( 'PHP Max Upload Size', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The largest filesize that can be contained in one post.', 'ciyashop' );?>">[?]</a></td>
				<td>
					<?php
					if ( $environment['php_upload_max_filesize'] < $system_status->size_to_num($recommendations['upload_max_filesize']) ) {
						/* Translators: %1$s: Memory limit, %2$s: Docs link, %3$s: Recommended Memory. */
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' .
						sprintf( esc_html__( '%1$s - We recommend setting maxium upload filesize to at least %3$s. See: %2$s', 'ciyashop' ),
							esc_html( size_format( $environment['php_upload_max_filesize'] ) ),
							'<a href="http://www.wpbeginner.com/wp-tutorials/how-to-increase-the-maximum-file-upload-size-in-wordpress/" rel="noopener" target="_blank">' . esc_html__( 'Increase the Maximum File Upload Size', 'ciyashop' ) . '</a>',
							$recommendations['upload_max_filesize']
						)
						. '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( size_format( $environment['php_upload_max_filesize'] ) ) . '</mark>';
					}
					?>
				</td>
			</tr>
			<tr>
				<td data-export-label="PHP Time Limit"><?php esc_html_e( 'PHP time limit', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups)', 'ciyashop' );?>">[?]</a></td>
				<td>
					<?php
					if ( $environment['php_max_execution_time'] < $recommendations['max_execution_time'] ) {
						/* Translators: %1$s: Maxium Execution Time, %2$s: Recommended Maxium Execution Time, %3$s: Docs link. */
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' .
						sprintf( esc_html__( '%1$s - We recommend setting maxium execution time to at least %2$s. See: %3$s', 'ciyashop' ),
							esc_html( $environment['php_max_execution_time'] ),
							$recommendations['max_execution_time'],
							'<a href="https://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded" rel="noopener" target="_blank">' . esc_html__( 'Increase the Maximum Execution Time', 'ciyashop' ) . '</a>'
						)
						. '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( $environment['php_max_execution_time'] ) . '</mark>';
					}
					?>
				</td>
			</tr>
			<tr>
				<td data-export-label="PHP Max Input Vars"><?php esc_html_e( 'PHP max input vars', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The maximum number of GET/POST/COOKIE input variables your server can accept in a single request to avoid overloads.', 'ciyashop' );?>">[?]</a></td>
				<td>
					<?php
					if ( $environment['php_max_input_vars'] < $recommendations['max_input_vars'] ) {
						/* Translators: %1$s: Maxium Execution Time, %2$s: Recommended Maxium Execution Time, %3$s: Docs link. */
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' .
						sprintf( esc_html__( '%1$s - We recommend setting maxium execution time to at least %2$s. See: %3$s', 'ciyashop' ),
							esc_html( $environment['php_max_input_vars'] ),
							$recommendations['max_input_vars'],
							'<a href="https://codex.wordpress.org/Common_WordPress_Errors#Maximum_execution_time_exceeded" rel="noopener" target="_blank">' . esc_html__( 'Increase the Maximum Input Variables', 'ciyashop' ) . '</a>'
						)
						. '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( $environment['php_max_input_vars'] ) . '</mark>';
					}
					?>
				</td>
			</tr>
			<tr>
				<td data-export-label="PHP Input Time"><?php esc_html_e( 'PHP input time', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Maximum time in seconds a script is allowed to parse input data, like POST and GET.', 'ciyashop' );?>">[?]</a></td>
				<td>
					<?php
					if ( $environment['php_max_input_time'] < $recommendations['max_input_time'] ) {
						/* Translators: %1$s: Maxium Input Time, %2$s: Recommended Maxium Input Time, %3$s: Docs link. */
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' .
						sprintf( esc_html__( '%1$s - We recommend setting maximum input time to at least %2$s. See: %3$s', 'ciyashop' ),
							esc_html( $environment['php_max_input_time'] ),
							$recommendations['max_input_time'],
							'<a href="http://www.wpbeginner.com/wp-tutorials/how-to-increase-the-maximum-file-upload-size-in-wordpress/" rel="noopener" target="_blank">' . esc_html__( 'Increase the Maximum Input Time', 'ciyashop' ) . '</a>'
						)
						. '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( $environment['php_max_input_time'] ) . '</mark>';
					}
					?>
				</td>
			</tr>
			<tr>
				<td data-export-label="cURL Version"><?php esc_html_e( 'cURL version', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The version of cURL installed on your server.', 'ciyashop' );?>">[?]</a></td>
				<td><?php echo esc_html( $environment['curl_version'] ); ?></td>
			</tr>
			<tr>
				<td data-export-label="SUHOSIN Installed"><?php esc_html_e( 'SUHOSIN installed', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Suhosin is an advanced protection system for PHP installations. It was designed to protect your servers on the one hand against a number of well known problems in PHP applications and on the other hand against potential unknown vulnerabilities within these applications or the PHP core itself. If enabled on your server, Suhosin may need to be configured to increase its data submission limits.', 'ciyashop' );?>">[?]</a></td>
				<td><?php
				if ($environment['suhosin_installed']) {
					?><span class="dashicons dashicons-yes"></span><?php
				}else{
					?>&ndash;<?php
				}?></td>
			</tr>
		<?php endif; ?>

		<?php

		if ( $environment['mysql_version'] ) :
			?>
			<tr>
				<td data-export-label="MySQL Version"><?php esc_html_e( 'MySQL version', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The version of MySQL installed on your hosting server.', 'ciyashop' );?>">[?]</a></td>
				<td>
					<?php
					if ( version_compare( $environment['mysql_version'], $recommendations['mysql_version'], '<' ) && ! strstr( $environment['mysql_version_string'], 'MariaDB' ) ) {
						/* Translators: %1$s: MySQL version, %2$s: Recommended MySQL version, %3$s: Docs link. */
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> '
						. sprintf( esc_html__( '%1$s - We recommend a minimum MySQL version of %2$s. See: %3$s', 'ciyashop' ),
							esc_html( $environment['mysql_version_string'] ),
							$recommendations['mysql_version'],
							'<a href="https://wordpress.org/about/requirements/" rel="noopener" target="_blank">' . esc_html__( 'WordPress requirements', 'ciyashop' ) . '</a>'
						)
						. '</mark>';
					} else {
						echo '<mark class="yes">' . esc_html( $environment['mysql_version_string'] ) . '</mark>';
					}
					?>
				</td>
			</tr>
		<?php endif; ?>
		<tr>
			<td data-export-label="Max Upload Size"><?php esc_html_e( 'Max upload size', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The largest filesize that can be uploaded to your WordPress installation.', 'ciyashop' );?>">[?]</a></td>
			<td><?php echo esc_html( size_format( $environment['max_upload_size'] ) ); ?></td>
		</tr>
		<tr>
			<td data-export-label="Default Timezone is UTC"><?php esc_html_e( 'Default timezone is UTC', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The default timezone for your server.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( 'UTC' !== $environment['default_timezone'] ) {
					/* Translators: %s: default timezone.. */
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( 'Default timezone is %s - it should be UTC', 'ciyashop' ), esc_html( $environment['default_timezone'] ) ) . '</mark>';
				} else {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="fsockopen/cURL"><?php esc_html_e( 'fsockopen/cURL', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Payment gateways can use cURL to communicate with remote servers to authorize payments, other plugins may also use it when communicating with remote services.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( $environment['fsockopen_or_curl_enabled'] ) {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				} else {
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__( 'Your server does not have fsockopen or cURL enabled - PayPal IPN and other scripts which communicate with other servers will not work. Contact your hosting provider.', 'ciyashop' ) . '</mark>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="SoapClient"><?php esc_html_e( 'SoapClient', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Some webservices like shipping use SOAP to get information from remote servers, for example, live shipping quotes from FedEx require SOAP to be installed.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( $environment['soapclient_enabled'] ) {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				} else {
					/* Translators: %s classname and link. */
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> '
					. sprintf( esc_html__( 'Your server does not have the %s class enabled - some gateway plugins which use SOAP may not work as expected.', 'ciyashop' ),
						'<a href="https://php.net/manual/en/class.soapclient.php">'.esc_html__( 'SoapClient', 'ciyashop' ).'</a>'
					)
					. '</mark>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="DOMDocument"><?php esc_html_e( 'DOMDocument', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'HTML/Multipart emails use DOMDocument to generate inline CSS in templates.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( $environment['domdocument_enabled'] ) {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				} else {
					/* Translators: %s: classname and link. */
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> '
					. sprintf( esc_html__( 'Your server does not have the %s class enabled - HTML/Multipart emails, and also some extensions, will not work without DOMDocument.', 'ciyashop' ),
						'<a href="https://php.net/manual/en/class.domdocument.php">DOMDocument</a>'
					)
					. '</mark>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="GZip"><?php esc_html_e( 'GZip', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'GZip (gzopen) is used to open the GEOIP database from MaxMind.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( $environment['gzip_enabled'] ) {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				} else {
					/* Translators: %s: classname and link. */
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> '
					. sprintf( esc_html__( 'Your server does not support the %s function - this is required to use the GeoIP database from MaxMind.', 'ciyashop' ),
						'<a href="https://php.net/manual/en/zlib.installation.php">gzopen</a>'
					)
					. '</mark>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="Multibyte String"><?php esc_html_e( 'Multibyte string', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Multibyte String (mbstring) is used to convert character encoding, like for emails or converting characters to lowercase.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( $environment['mbstring_enabled'] ) {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				} else {
					/* Translators: %s: classname and link. */
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> '
					. sprintf( esc_html__( 'Your server does not support the %s functions - this is required for better character encoding. Some fallbacks will be used instead for it.', 'ciyashop' ),
						'<a href="https://php.net/manual/en/mbstring.installation.php">mbstring</a>'
					)
					. '</mark>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="Remote Post"><?php esc_html_e( 'Remote post', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'PayPal uses this method of communicating when sending back transaction information.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( $environment['remote_post_successful'] ) {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				} else {
					/* Translators: %s: function name. */
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%s failed. Contact your hosting provider.', 'ciyashop' ), 'wp_remote_post()' ) . ' ' . esc_html( $environment['remote_post_response'] ) . '</mark>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="Remote Get"><?php esc_html_e( 'Remote get', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'WooCommerce plugins may use this method of communication when checking for plugin updates.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( $environment['remote_get_successful'] ) {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				} else {
					/* Translators: %s: function name. */
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%s failed. Contact your hosting provider.', 'ciyashop' ), 'wp_remote_get()' ) . ' ' . esc_html( $environment['remote_get_response'] ) . '</mark>';
				}
				?>
			</td>
		</tr>
		<?php
		$rows = apply_filters( 'woocommerce_system_status_environment_rows', array() );
		foreach ( $rows as $row ) {
			if ( ! empty( $row['success'] ) ) {
				$css_class = 'yes';
				$icon      = '<span class="dashicons dashicons-yes"></span>';
			} else {
				$css_class = 'error';
				$icon      = '<span class="dashicons dashicons-no-alt"></span>';
			}
			?>
			<tr>
				<td data-export-label="<?php echo esc_attr( $row['name'] ); ?>"><?php echo esc_html( $row['name'] ); ?>:</td>
				<td class="help"><?php echo esc_html( isset( $row['help'] ) ? $row['help'] : '' ); ?></td>
				<td>
					<mark class="<?php echo esc_attr( $css_class ); ?>">
						<?php echo wp_kses_post( $icon ); ?> <?php echo wp_kses_data( ! empty( $row['note'] ) ? $row['note'] : '' ); ?>
					</mark>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
<table class="cs_status_table table table-striped table-hover" cellspacing="0">
	<thead>
		<tr>
			<th colspan="3" data-export-label="Active Plugins (<?php echo count( $active_plugins ); ?>)"><h2><?php esc_html_e( 'Active plugins', 'ciyashop' ); ?> (<?php echo count( $active_plugins ); ?>)</h2></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ( $active_plugins as $plugin ) {
			if ( ! empty( $plugin['name'] ) ) {
				$dirname = dirname( $plugin['plugin'] );

				// Link the plugin name to the plugin url if available.
				$plugin_name = esc_html( $plugin['name'] );
				if ( ! empty( $plugin['url'] ) ) {
					$plugin_name = '<a href="' . esc_url( $plugin['url'] ) . '" aria-label="' . esc_attr__( 'Visit plugin homepage', 'ciyashop' ) . '" rel="noopener" target="_blank">' . $plugin_name . '</a>';
				}

				$version_string = '';
				$network_string = '';
				if ( strstr( $plugin['url'], 'woothemes.com' ) || strstr( $plugin['url'], 'woocommerce.com' ) ) {
					if ( ! empty( $plugin['version_latest'] ) && version_compare( $plugin['version_latest'], $plugin['version'], '>' ) ) {
						/* translators: %s: plugin latest version */
						$version_string = ' &ndash; <strong class="ciyashop-red">' . sprintf( esc_html__( '%s is available', 'ciyashop' ), $plugin['version_latest'] ) . '</strong>';
					}

					if ( false !== $plugin['network_activated'] ) {
						$network_string = ' &ndash; <strong class="ciyashop-black">' . esc_html__( 'Network enabled', 'ciyashop' ) . '</strong>';
					}
				}
				$untested_string = '';
				?>
				<tr>
					<td><?php echo wp_kses_post( $plugin_name ); ?></td>
					<td class="help">&nbsp;</td>
					<td>
					<?php
						/* translators: %s: plugin author */
						printf( esc_html__( 'by %s', 'ciyashop' ), esc_html( $plugin['author_name'] ) );
						echo ' &ndash; ' . esc_html( $plugin['version'] ) . $version_string . $untested_string . $network_string; // WPCS: XSS ok.
					?>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</tbody>
</table>
<table class="cs_status_table table table-striped table-hover" cellspacing="0">
	<thead>
		<tr>
			<th colspan="3" data-export-label="Theme"><h2><?php esc_html_e( 'Theme', 'ciyashop' ); ?></h2></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td data-export-label="Name"><?php esc_html_e( 'Name', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The name of the current active theme.', 'ciyashop' );?>">[?]</a></td>
			<td><?php echo esc_html( $theme['name'] ); ?></td>
		</tr>
		<tr>
			<td data-export-label="Version"><?php esc_html_e( 'Version', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The installed version of the current active theme.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				echo esc_html( $theme['version'] );
				if ( version_compare( $theme['version'], $theme['version_latest'], '<' ) ) {
					/* translators: %s: theme latest version */
					echo ' &ndash; <strong class="ciyashop-red">' . sprintf( esc_html__( '%s is available', 'ciyashop' ), esc_html( $theme['version_latest'] ) ) . '</strong>';
				}
				?>
			</td>
		</tr>
		<tr>
			<td data-export-label="Author URL"><?php esc_html_e( 'Author URL', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The theme developers URL.', 'ciyashop' );?>">[?]</a></td>
			<td><?php echo esc_html( $theme['author_url'] ); ?></td>
		</tr>
		<tr>
			<td data-export-label="Child Theme"><?php esc_html_e( 'Child theme', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Displays whether or not the current theme is a child theme.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( $theme['is_child_theme'] ) {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				} else {
					/* Translators: %s docs link. */
					echo '<span class="dashicons dashicons-no-alt"></span> &ndash; ' . wp_kses_post( sprintf( __( 'If you are modifying WooCommerce on a parent theme that you did not build personally we recommend using a child theme. See: <a href="%s" rel="noopener" target="_blank">How to create a child theme</a>', 'ciyashop' ), 'https://codex.wordpress.org/Child_Themes' ) );
				}
				?>
				</td>
		</tr>
		<?php if ( $theme['is_child_theme'] ) : ?>
			<tr>
				<td data-export-label="Parent Theme Name"><?php esc_html_e( 'Parent theme name', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The name of the parent theme.', 'ciyashop' );?>">[?]</a></td>
				<td><?php echo esc_html( $theme['parent_name'] ); ?></td>
			</tr>
			<tr>
				<td data-export-label="Parent Theme Version"><?php esc_html_e( 'Parent theme version', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The installed version of the parent theme.', 'ciyashop' );?>">[?]</a></td>
				<td>
					<?php
					echo esc_html( $theme['parent_version'] );
					if ( version_compare( $theme['parent_version'], $theme['parent_version_latest'], '<' ) ) {
						/* translators: %s: parent theme latest version */
						echo ' &ndash; <strong class="ciyashop-red">' . sprintf( esc_html__( '%s is available', 'ciyashop' ), esc_html( $theme['parent_version_latest'] ) ) . '</strong>';
					}
					?>
				</td>
			</tr>
			<tr>
				<td data-export-label="Parent Theme Author URL"><?php esc_html_e( 'Parent theme author URL', 'ciyashop' ); ?>:</td>
				<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'The parent theme developers URL.', 'ciyashop' );?>">[?]</a></td>
				<td><?php echo esc_html( $theme['parent_author_url'] ); ?></td>
			</tr>
		<?php endif ?>
		<tr>
			<td data-export-label="WooCommerce Support"><?php esc_html_e( 'WooCommerce support', 'ciyashop' ); ?>:</td>
			<td class="help"><a class="cs-status-tooltip" title="<?php echo esc_attr__( 'Displays whether or not the current active theme declares WooCommerce support.', 'ciyashop' );?>">[?]</a></td>
			<td>
				<?php
				if ( ! $theme['has_woocommerce_support'] ) {
					echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . esc_html__( 'Not declared', 'ciyashop' ) . '</mark>';
				} else {
					echo '<mark class="yes"><span class="dashicons dashicons-yes"></span></mark>';
				}
				?>
			</td>
		</tr>
	</tbody>
</table>
