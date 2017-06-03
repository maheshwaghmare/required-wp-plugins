<?php

/**
 * Plugin Name: Required WP Plugins
 * Plugin URI: https://github.com/maheshwaghmare/required-wp-plugins
 * Description: WP Required Plugins.
 * Version: 1.0.0
 * Author: Mahesh M. Waghmare
 * Author URI: https://maheshwaghmare.wordpress.com/
 * Copyright: (c) 2017 Mahesh M. Waghmare
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-required-plugins
 */

/**
 * Create admin Page to list unsubscribed emails.
 */
 // Hook for adding admin menus
 add_action('admin_menu', 'rwpp_add_pages');
 
 // action function for above hook
 
/**
 * Adds a new top-level page to the administration menu.
 */
function rwpp_add_pages() {

	add_theme_page(
		'themes.php',
		__( 'Unsub List', 'textdomain' ),
		'manage_options',
		'unsub',
		'rwpp_page_callback'
	);
}
 
/**
 * Disply callback for the Unsub page.
 */
 function rwpp_page_callback() {

 	?>
 	<div class="wrap about-wrap">
 		<h1> Welcome </h1>
 		<p> Function that crates the action link for install/activate/deactivate. </p>
 		<a href="#" target="_blank" class="wp-badge"></a>
 		<h3 class="wp-clearfix">Recommended Plguins</h3>
 		<hr/>
		<?php rwpp_show_plugin_list(); ?>
	</div>
	<?php
     
 }


// 


/**
 * Function that crates the action link for install/activate/deactivate.
 *
 * @param Plugin-state $state the plugin state (uninstalled/active/inactive).
 * @param Plugin-slug  $slug the plugin slug.
 *
 * @return string
 */
function my_slug_plugin_actions( $state, $slug ) {

	switch ( $state ) {
		case 'install':
			return wp_nonce_url(
				add_query_arg(
					array(
						'action' => 'install-plugin',
						'plugin' => $slug,
					),
					network_admin_url( 'update.php' )
				),
				'install-plugin_' . $slug
			);
			break;
		case 'deactivate':
			return add_query_arg( array(
				'action'        => 'deactivate',
				'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
				'plugin_status' => 'all',
				'paged'         => '1',
				'_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $slug . '/' . $slug . '.php' ),
			), network_admin_url( 'plugins.php' ) );
			break;

		case 'activate':
			return add_query_arg( array(
				'action'        => 'activate',
				'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
				'plugin_status' => 'all',
				'paged'         => '1',
				'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $slug . '/' . $slug . '.php' ),
			), network_admin_url( 'plugins.php' ) );
			break;

		case 'delete':
			return add_query_arg( array(
				'checked'		=> rawurlencode( $slug . '/' . $slug . '.php' ),
				'action'        => 'delete-selected',
				'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
				'plugin_status' => 'all',
				'paged'         => '1',
				'_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $slug . '/' . $slug . '.php' ),
			), network_admin_url( 'plugins.php' ) );
			break;
	}
}

/**
 * Check if plugin is installed/activated
 *
 * @param plugin-slug $slug the plugin slug.
 *
 * @return array
 */
function rwpp_check_active( $slug ) {
	if ( file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/' . $slug . '.php' ) ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		$needs = is_plugin_active( $slug . '/' . $slug . '.php' ) ? 'deactivate' : 'activate';

		return array(
			'status' => is_plugin_active( $slug . '/' . $slug . '.php' ),
			'needs' => $needs,
		);
	}

	return array(
		'status' => false,
		'needs' => 'install',
	);
}


function rwpp_plugin_list() {

	$plugins_list = array(
		array(
			'title' => 'ACF to WP-API',
			'slug' => 'acf-to-wp-api',
			'url' => 'https://wordpress.org/plugins/acf-to-wp-api/',
		),
		array(
			'title' => 'Advanced Custom Fields',
			'slug' => 'advanced-custom-fields',
			'url' => 'https://wordpress.org/plugins/advanced-custom-fields/',
		),
		array(
			'title' => 'Advanced Custom Fields: Font Awesome',
			'slug' => 'advanced-custom-fields-font-awesome',
			'url' => 'https://wordpress.org/plugins/advanced-custom-fields-font-awesome/',
		),
		array(
			'title' => 'Advanced Custom Fields: Nav Menu Field',
			'slug' => 'advanced-custom-fields-nav-menu-field',
			'url' => 'https://wordpress.org/plugins/advanced-custom-fields-nav-menu-field/',
		),
		array(
			'title' => 'All In One Schema.org Rich Snippets',
			'slug' => 'all-in-one-schemaorg-rich-snippets',
			'url' => 'https://wordpress.org/plugins/all-in-one-schemaorg-rich-snippets/',
		),
		array(
			'title' => 'Application Passwords',
			'slug' => 'application-passwords',
			'url' => 'https://wordpress.org/plugins/application-passwords/',
		),
		array(
			'title' => 'BackUpWordPress',
			'slug' => 'backupwordpress',
			'url' => 'https://wordpress.org/plugins/backupwordpress/',
		),
		array(
			'title' => 'Better WordPress Minify',
			'slug' => 'bwp-minify',
			'url' => 'https://wordpress.org/plugins/bwp-minify/',
		),
		array(
			'title' => 'Broken Link Checker',
			'slug' => 'broken-link-checker',
			'url' => 'https://wordpress.org/plugins/broken-link-checker/',
		),
		array(
			'title' => 'BuddyPress',
			'slug' => 'buddypress',
			'url' => 'https://wordpress.org/plugins/buddypress/',
		),
		array(
			'title' => 'Canva – Design beautiful blog graphics',
			'slug' => 'canva',
			'url' => 'https://wordpress.org/plugins/canva/',
		),
		array(
			'title' => 'Contact Form 7',
			'slug' => 'contact-form-7',
			'url' => 'https://wordpress.org/plugins/contact-form-7/',
		),
		array(
			'title' => 'Core Media Widgets',
			'slug' => 'wp-core-media-widgets',
			'url' => 'https://wordpress.org/plugins/wp-core-media-widgets/',
		),
		array(
			'title' => 'Cronjob Scheduler',
			'slug' => 'cronjob-scheduler',
			'url' => 'https://wordpress.org/plugins/cronjob-scheduler/',
		),
	);

	return $plugins_list;
}

function rwpp_show_plugin_list() {

	$all_plugins = rwpp_plugin_list();

	?>
	<table id="plugin-filter">
		<tr>
			<th> Plugin </th>
			<th> Action </th>
		</tr>

		<?php foreach ($all_plugins as $key => $plugin ) { ?>
			<tr>
				<td> <?php echo $plugin['title']; ?> </td>
				<td> <span style="display: inline-block;"> <?php echo rwpp_generate_btn( $plugin['slug'] ); ?> </span> <a href="<?php echo $plugin['url']; ?>" target="_blank">Goto</a> </td>
			</tr>
		<?php }	?>

	</table>

	<?php
}


function rwpp_generate_btn( $plugin_slug ) {
	$plugin      = rwpp_check_active( $plugin_slug );
	$url         = '';
	$class       = 'button';
	$delete_btn = '';

	switch ( $plugin['needs'] ) {

		case 'install':
						$class = 'install-now button';
						$label = esc_html__( 'Install and Activate', 'hestia' );
						$url   = my_slug_plugin_actions( $plugin['needs'], $plugin_slug );
			break;
		case 'activate':
						$class = 'activate-now button button-primary';
						$label = esc_html__( 'Activate', 'hestia' );
						$url   = my_slug_plugin_actions( $plugin['needs'], $plugin_slug );
			break;
		case 'deactivate':
						$class      = 'deactivate-now button';
						$label      = esc_html__( 'Deactivate', 'hestia' );
						$url        = my_slug_plugin_actions( $plugin['needs'], $plugin_slug );
			break;
	}

	ob_start();
	?>
	<div id="plugin-filter">
		<p class="plugin-card-<?php echo esc_attr( $plugin_slug ) ?> action_button <?php echo ( $plugin['needs'] !== 'install' && $plugin['status'] ) ? 'active' : '' ?>">
			<a data-slug="<?php echo esc_attr( $plugin_slug ) ?>" class="<?php echo esc_attr( $class ); ?>" href="<?php echo esc_url( $url ) ?>"> <?php echo esc_html( $label ) ?> </a>
		</p>
	</div>
	<?php
	return ob_get_clean();
}
