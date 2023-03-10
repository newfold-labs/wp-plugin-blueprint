<?php
/**
 * Register Admin page and features.
 *
 * @package WPPluginBlueprint
 */

namespace Blueprint;

/**
 * \Blueprint\Admin
 */
final class Admin {

	/**
	 * Register functionality using WordPress Actions.
	 */
	public function __construct() {
		/* Add Page to WordPress Admin Menu. */
		\add_action( 'admin_menu', array( __CLASS__, 'page' ) );
		/* Load Page Scripts & Styles. */
		\add_action( 'load-toplevel_page_blueprint', array( __CLASS__, 'assets' ) );
		/* Load i18 files */
		\add_action( 'init', array( __CLASS__, 'load_text_domain' ), 100 );
		/* Add Links to WordPress Plugins list item. */
		\add_filter( 'plugin_action_links_wp-plugin-blueprint/wp-plugin-blueprint.php', array( __CLASS__, 'actions' ) );
		/* Add inline style to hide subnav link */
		\add_action( 'admin_head', array( __CLASS__, 'admin_nav_style' ) );

		if ( isset( $_GET['page'] ) && strpos( filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRING ), 'blueprint' ) >= 0 ) { // phpcs:ignore
			\add_action( 'admin_footer_text', array( __CLASS__, 'add_brand_to_admin_footer' ) );
		}
	}

	/**
	 * Subpages to register with add_submenu_page().
	 *
	 * Order or array items determines menu order.
	 *
	 * @return array
	 */
	public static function subpages() {
		return array(
			'blueprint#/home'        => __( 'Home', 'wp-plugin-blueprint' ),
			'blueprint#/marketplace' => __( 'Marketplace', 'wp-plugin-blueprint' ),
			'blueprint#/performance' => __( 'Performance', 'wp-plugin-blueprint' ),
			'blueprint#/settings'    => __( 'Settings', 'wp-plugin-blueprint' ),
			'blueprint#/help'        => __( 'Help', 'wp-plugin-blueprint' ),
		);
	}

	/**
	 * Add inline script to admin screens
	 *  - hide extra link in subnav
	 */
	public static function admin_nav_style() {
		echo '<style>';
		echo 'li#toplevel_page_blueprint a.toplevel_page_blueprint div.wp-menu-image.svg { transition: fill 0.15s; background-size: 24px auto !important; }';
		echo 'ul#adminmenu a.toplevel_page_blueprint.wp-has-current-submenu:after, ul#adminmenu>li#toplevel_page_blueprint.current>a.current:after { border-right-color: #fff !important; }';
		echo 'li#toplevel_page_blueprint > ul > li.wp-first-item { display: none !important; }';
		echo '#wp-toolbar #wp-admin-bar-blueprint-coming_soon .ab-item { padding: 0; }';
		echo '</style>';
	}

	/**
	 * Add WordPress Page to Appearance submenu.
	 *
	 * @return void
	 */
	public static function page() {
		// get the blueprint-logo.svg and encode for base64 at https://base64.guru/converter/encode/image/svg
		$blueprint_icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGZpbGw9Im5vbmUiIHZpZXdCb3g9IjAgMCAyNCAyMSI+PHBhdGggZmlsbD0id2hpdGUiIGQ9Ik0xMC44NyAxNC45NyA1Ljk4IDkuN2EuMjYuMjYgMCAwIDAtLjI2LS4wOC4yNi4yNiAwIDAgMC0uMTUuMjNsLS4yNiA0Ljk3YS4yNi4yNiAwIDAgMCAuMi4yNmw1LjE1LjMxYS4yNi4yNiAwIDAgMCAuMjYtLjI5LjI0LjI0IDAgMCAwLS4wNS0uMTNabS0yLjE3LS4xM2EuMjYuMjYgMCAxIDEtLjQ3LS4xM2wuMTMtLjUyLTEuMS0uMjktLjE1LjVhLjI2LjI2IDAgMCAxLS40Ny0uMTZsLjE1LS41LS43OC0uMmEuMjYuMjYgMCAwIDEtLjE0LS41Yy4wNC0uMDIuMDgtLjAzLjEzLS4wMmEuMi4yIDAgMCAxIC4xMi4wNWwuNzguMi4zNC0xLjA3YS4yNi4yNiAwIDAgMSAuMjktLjE4Yy4xMy4wNS4yLjE4LjE4LjMxbC0uMzIgMS4xIDEuMTMuMzEuMDItLjE4YS4yNi4yNiAwIDAgMSAuNS4xM2wtLjM0IDEuMTVabTUuMDUtNy4zOC0xLjEyLS4zMS0uMzQgMS4xNSAxLjEyLjMuMzQtMS4xNFptLjQ3LTEuNjYtMS4xLS4zMi0uMzQgMS4xNiAxLjEuMzIuMzQtMS4xNlptLS45MiAzLjI4LTEuMTItLjMxLS4zNCAxLjE1IDEuMTMuMzEuMzQtMS4xNVptLS4yLTUuMzVMMTIgMy40MWwtLjM0IDEuMTYgMS4xLjMyLjM1LTEuMTZabS0uNDcgMS42Ni0xLjEtLjMyLS4zNSAxLjE2IDEuMTEuMzIuMzQtMS4xNlptMi4wNy0xLjIxLTEuMTItLjMxLS4zMyAxLjE1IDEuMTIuMy4zNC0xLjE0Wm0xLjYuNDgtMS4xMi0uMzItLjM0IDEuMTUgMS4xMi4zMi4zNC0xLjE1Wm0tLjQ5IDEuNjItMS4xLS4zMi0uMzQgMS4xNiAxLjEuMzIuMzQtMS4xNlptLS40NyAxLjYyLTEuMTEtLjMyLS4zNCAxLjE2IDEuMS4zMi4zNS0xLjE1Wm0tLjQ0IDEuNjMtMS4xMi0uMzEtLjM0IDEuMTUgMS4xMi4zLjM0LTEuMTRabS0zLjg1LTQuNjJMOS45MiA0LjZsLS4zNCAxLjE1IDEuMTMuMzEuMzQtMS4xNVpNOC4zMyAyLjM3bC0xLjEtLjMzLS4zNCAxLjE2IDEuMS4zMi4zNC0xLjE1Wm0tMS41OS0uNDgtMS4xMS0uMzItLjM0IDEuMTUgMS4xMS4zMi4zNC0xLjE1WiIvPjxwYXRoIGZpbGw9IndoaXRlIiBkPSJNMjEuNy44MmE1LjQ4IDUuNDggMCAwIDAtMi44Ny0uMTguMjYuMjYgMCAwIDAtLjE1LjE1bC0uODcgMi45OEw0LjczLjAxYS4yNi4yNiAwIDAgMC0uMzEuMTZsLS42NSAyLjM1LS43NC0uNzlhLjI2LjI2IDAgMCAwLS4yNi0uMDUuMjYuMjYgMCAwIDAtLjE1LjIxbC0uMzQgNS44TDAgMTUuNTdjLS4wMy4xMy4wNS4yNi4xOC4zMmwxLjU2LjQ0LS4wNyAxLjU3YS4yNi4yNiAwIDAgMCAuMjYuMjZsNy42NS4zOSA2LjQ1IDEuODNjMi44NC44OCAzLjI2LS41OCAzLjQ3LTEuMzNMMjMuMzggNS42bC41Ny0xLjk5Yy4yNi0uOTktLjUtMi4zLTIuMjUtMi44Wm0tMTYuNDcuNDJhLjI2LjI2IDAgMCAxIC4yOC0uMTlsMTEuMTMgMy4xOWMuMTMuMDUuMi4xOC4xNi4zMWwtMi40OSA4LjYyYS4yNi4yNiAwIDAgMS0uMjguMTYuMjYuMjYgMCAwIDEtLjE5LS4yOWwuNTUtMS45LTEuMS0uMzUtLjI4Ljk3YS4yNi4yNiAwIDAgMS0uMzMuMjguMjYuMjYgMCAwIDEtLjE0LS40MWwuMjYtLjk3LTEuMzMtLjM5YS4yNi4yNiAwIDAgMS0uMTgtLjI5bC40MS0xLjM4LTEuMTItLjM0LS4yLjczYS4yNi4yNiAwIDEgMS0uNDgtLjEzbC4yMS0uNjgtMS4zNi0uMzlhLjI2LjI2IDAgMCAxLS4xNS0uMjlsLjM5LTEuMzgtMS4xMy0uMzQtLjEzLjQ0YS4yNi4yNiAwIDEgMS0uNDctLjEzbC42LTIuMDYtMS4xMi0uMzEtLjI5IDEuMWEuMjYuMjYgMCAxIDEtLjQ3LS4xNGwuMzItMS4xMi0xLjMtLjRoLS4wNmEuMjYuMjYgMCAwIDEtLjE2LS4yOGwuNDctMS42NGgtLjAyWk0xLjc1IDE1YS4yNi4yNiAwIDEgMS0uNDctLjEzbC4yNy0uOTJhLjI2LjI2IDAgMCAxIC40Ny4xM2wtLjI3LjkyWm0uNDIgMi42NC44Ni0xNS4xNUw0LjkxIDQuNWwtLjU3LjQ3YS4yNi4yNiAwIDEgMCAuMzQuMzdsLjU1LS41LjYyLjctLjUyLjVhLjI2LjI2IDAgMSAwIC4zMi4zN2wuNTQtLjUzLjYzLjcxLS41NS41YS4yNi4yNiAwIDAgMCAuMzQuMzZsLjU1LS41Mi42My43LS41NS41YS4yNi4yNiAwIDAgMCAuMDguNDJjLjA3IDAgLjE4IDAgLjI2LS4wNWwuNTItLjUzLjcuNzYtLjU3LjVhLjI2LjI2IDAgMCAwIC4xLjQxYy4wOCAwIC4xNiAwIC4yNC0uMDVsLjU3LS41Mi42My43LS41Ny41M2EuMjYuMjYgMCAwIDAgLjM0LjM0bC41Ny0uNTMuNjMuNzEtLjU4LjUyYS4yNi4yNiAwIDAgMCAuMzQuMzRsLjU1LS41Mi42My43LS41OC41M2EuMjYuMjYgMCAwIDAtLjEyLjQzLjI2LjI2IDAgMCAwIC40NC0uMWwuNTctLjUyLjYzLjctLjU4LjUzYS4yNi4yNiAwIDEgMCAuMzQuMzdsLjU4LS41My42Mi42OC0uNTcuNTNhLjI2LjI2IDAgMCAwIC4xLjQxYy4wOCAwIC4xNiAwIC4yNC0uMDVsLjU3LS41Mi42OC43My0uMzQgMS4xOGMtLjAyLjA3IDAgLjE4LjA1LjI2LjA2LjA1LjE2LjA3LjI3LjA1IDAgMCAuNS0uMTMgMS4zNS0uMDVsMS45MSAyLjA5LTE1LjY3LS45di0uMDRabTE3LjE2LjFjLS4zMi0uNjUtMS4wMi0xLjIzLTIuMS0xLjU3YTYuNDIgNi40MiAwIDAgMC0yLjQyLS4yNmw0LjI2LTE0Ljg4Yy4zMS0uMDMgMS4yLS4xMyAyLjQ4LjI2IDEuNTkuNDQgMi4wOSAxLjU0IDEuODggMi4xN2wtNC4wOCAxNC4zLS4wMi0uMDJaIi8+PHBhdGggZmlsbD0id2hpdGUiIGQ9Im05LjQ0IDQuNDMtMS4xLS4zMkw4IDUuMjdsMS4xLjMyLjM0LTEuMTZabS40OS0xLjU5LTEuMTItLjMxLS4zNCAxLjE1IDEuMTIuMzEuMzQtMS4xNVptMS41OS40NS0xLjEyLS4zMi0uMzQgMS4xNSAxLjEyLjMyLjM0LTEuMTVabS42NCAzLjY5LTEuMTItLjMxLS4zNCAxLjE1IDEuMTIuMzEuMzQtMS4xNVptLTEuNi0uNDQtMS4xLS4zMy0uMzUgMS4xNiAxLjExLjMyLjM0LTEuMTVaIi8+PC9zdmc+';

		\add_menu_page(
			__( 'Blueprint', 'wp-plugin-blueprint' ),
			__( 'Blueprint', 'wp-plugin-blueprint' ),
			'manage_options',
			'blueprint',
			array( __CLASS__, 'render' ),
			$blueprint_icon,
			0
		);

		foreach ( self::subpages() as $route => $title ) {
			\add_submenu_page(
				'blueprint',
				$title,
				$title,
				'manage_options',
				$route,
				array( __CLASS__, 'render' )
			);
		}
	}

	/**
	 * Render DOM element for React to load onto.
	 *
	 * @return void
	 */
	public static function render() {
		global $wp_version;

		echo '<!-- Blueprint -->' . PHP_EOL;

		if ( version_compare( $wp_version, '5.4', '>=' ) ) {
			echo '<div id="wppb-app" class="wppb wppb_app"></div>' . PHP_EOL;
		} else {
			// fallback messaging for WordPress older than 5.4
			echo '<div id="wppb-app" class="wppb wppb_app">' . PHP_EOL;
			echo '<header class="wppb-header" style="min-height: 90px; padding: 1rem; margin-bottom: 1.5rem;"><div class="wppb-header-inner"><div class="wppb-logo-wrap">' . PHP_EOL;
			echo '<img src="' . esc_url( BLUEPRINT_PLUGIN_URL . 'assets/svg/blueprint-logo.svg' ) . '" alt="Blueprint logo" />' . PHP_EOL;
			echo '</div></div></header>' . PHP_EOL;
			echo '<div class="wrap">' . PHP_EOL;
			echo '<div class="card" style="margin-left: 20px;"><h2 class="title">' . esc_html__( 'Please update to a newer WordPress version.', 'wp-plugin-blueprint' ) . '</h2>' . PHP_EOL;
			echo '<p>' . esc_html__( 'There are new WordPress components which this plugin requires in order to render the interface.', 'wp-plugin-blueprint' ) . '</p>' . PHP_EOL;
			echo '<p><a href="' . esc_url( admin_url( 'update-core.php' ) ) . '" class="button component-button is-primary button-primary" variant="primary">' . esc_html__( 'Please update now', 'wp-plugin-blueprint' ) . '</a></p>' . PHP_EOL;
			echo '</div></div></div>' . PHP_EOL;
		}

		echo '<!-- /Blueprint -->' . PHP_EOL;
	}

	/**
	 * Load Page Scripts & Styles.
	 *
	 * @return void
	 */
	public static function assets() {
		$asset_file = BLUEPRINT_BUILD_DIR . '/index.asset.php';

		if ( is_readable( $asset_file ) ) {
			$asset = include_once $asset_file;
		} else {
			return;
		}

		\wp_register_script(
			'blueprint-script',
			BLUEPRINT_BUILD_URL . '/index.js',
			array_merge( $asset['dependencies'] ),
			$asset['version'],
			true
		);

		\wp_set_script_translations(
			'blueprint-script',
			'wp-plugin-blueprint',
			BLUEPRINT_PLUGIN_DIR . '/languages'
		);

		include BLUEPRINT_PLUGIN_DIR . '/inc/Data.php';
		\wp_add_inline_script(
			'blueprint-script',
			'var WPPB =' . \wp_json_encode( Data::runtime() ) . ';',
			'before'
		);

		\wp_register_style(
			'blueprint-style',
			BLUEPRINT_BUILD_URL . '/index.css',
			array( 'wp-components' ),
			$asset['version']
		);

		$screen = get_current_screen();
		if ( false !== strpos( $screen->id, 'blueprint' ) ) {
			\wp_enqueue_script( 'blueprint-script' );
			\wp_enqueue_style( 'blueprint-style' );
		}
	}

	/**
	 * Load text domain for plugin
	 *
	 * @return void
	 */
	public static function load_text_domain() {

		\load_plugin_textdomain(
			'wp-plugin-blueprint',
			false,
			BLUEPRINT_PLUGIN_DIR . '/languages'
		);

		\load_script_textdomain(
			'blueprint-script',
			'wp-plugin-blueprint',
			BLUEPRINT_PLUGIN_DIR . '/languages'
		);
	}

	/**
	 * Add Links to WordPress Plugins list item for Blueprint.
	 *
	 * @param  array $actions - array of action links for Plugin row item.
	 * @return array
	 */
	public static function actions( $actions ) {
		return array_merge(
			array(
				'overview' => '<a href="' . \admin_url( 'admin.php?page=blueprint#/home' ) . '">' . __( 'Home', 'wp-plugin-blueprint' ) . '</a>',
				'settings' => '<a href="' . \admin_url( 'admin.php?page=blueprint#/settings' ) . '">' . __( 'Settings', 'wp-plugin-blueprint' ) . '</a>',
			),
			$actions
		);
	}

	/**
	 * Filter WordPress Admin Footer Text "Thank you for creating with..."
	 *
	 * @param string $footer_text footer text
	 * @return string
	 */
	public static function add_brand_to_admin_footer( $footer_text ) {
		$footer_text = \sprintf( \__( 'Thank you for creating with <a href="https://wordpress.org/">WordPress</a> and <a href="https://blueprint.com/about-us">Blueprint</a>.', 'wp-plugin-blueprint' ) );
		return $footer_text;
	}
} // END \Blueprint\Admin
