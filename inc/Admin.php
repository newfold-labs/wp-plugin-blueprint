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
		$blueprint_icon = 'data:image/svg+xml;base64,data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTIxLjMzNzEgNy41MzkzM0MyMC42OTY2IDcuMTM0ODMgMTkuODUzOSA2LjkzMjU5IDE4LjgwOSA2LjkzMjU5SDE0LjM1OTZMMTAuNjUxNyAxOC45MzI2SDE1LjAzMzdDMTYuMDc4NyAxOC45MzI2IDE3LjA1NjIgMTguNzMwMyAxNy45NjYzIDE4LjM5MzNDMTguODc2NCAxOC4wMjI1IDE5LjY4NTQgMTcuNTE2OSAyMC40MjcgMTYuODQyN0MyMS4xMzQ4IDE2LjIwMjIgMjEuNzA3OSAxNS4zOTMzIDIyLjE3OTggMTQuNTE2OUMyMi42NTE3IDEzLjY0MDUgMjIuODg3NiAxMi42NjI5IDIyLjk4ODggMTEuNTg0M0MyMy4wODk5IDEwLjcwNzkgMjIuOTg4OCA5Ljg5ODg4IDIyLjY4NTQgOS4yMjQ3MkMyMi40NDk0IDguNDgzMTUgMjIuMDExMiA3Ljk0MzgyIDIxLjMzNzEgNy41MzkzM1pNMTkuNjg1NCAxMi4wNTYyQzE5LjY1MTcgMTIuNTk1NSAxOS40ODMxIDEzLjEwMTEgMTkuMzE0NiAxMy42MDY3QzE5LjExMjQgMTQuMDc4NyAxOC44NDI3IDE0LjU1MDYgMTguNTA1NiAxNC44ODc2QzE4LjE2ODUgMTUuMjU4NCAxNy43OTc4IDE1LjU2MTggMTcuMzkzMyAxNS43NjRDMTYuOTU1MSAxNS45NjYzIDE2LjUxNjkgMTYuMTAxMSAxNi4wMTEyIDE2LjEwMTFIMTQuNzY0TDE2Ljc4NjUgOS42MjkyMkgxOEMxOC40MzgyIDkuNjI5MjIgMTguNzc1MyA5LjczMDM0IDE5LjA0NDkgOS45MzI1OUMxOS4zNDgzIDEwLjEzNDggMTkuNTE2OSAxMC40MDQ1IDE5LjY1MTcgMTAuNzc1M0MxOS42ODU0IDExLjE0NjEgMTkuNzE5MSAxMS41ODQzIDE5LjY4NTQgMTIuMDU2MloiIGZpbGw9IndoaXRlIi8+CjxwYXRoIGQ9Ik01Ljg5ODg4IDE0LjIwMjJDNS44NjUxNyAxNC4yMDIyIDUuNzk3NzYgMTQuMjAyMiA1Ljc2NDA1IDE0LjIwMjJDNS4yOTIxNCAxNC4yMDIyIDQuODg3NjQgMTQuMDMzNyA0LjY1MTY5IDEzLjczMDNDNC4xMTIzNiAxMy4wMjI1IDQuMzQ4MzIgMTEuNzQxNiA0LjUxNjg2IDExLjAzMzdDNC42MTc5OCAxMC42OTY2IDUuNDYwNjggNy43OTc3NiA3LjQ0OTQ0IDcuNTYxOEM3LjcxOTEgNy41MjgwOSA3LjkyMTM1IDcuNTk1NTEgOC4wNTYxOCA3Ljc2NDA1QzguMjU4NDMgOC4wMzM3MSA4LjMyNTg1IDguNTM5MzMgOC4xOTEwMSA5LjI4MDlMMTEuMjI0NyA4Ljg3NjQxQzExLjU2MTggNy42OTY2MyAxMS40NjA3IDYuNzUyODEgMTAuOTU1MSA2LjA3ODY1QzEwLjE3OTggNS4wMzM3MSA4LjY5NjYzIDQuOTMyNTkgOC4wODk4OSA0LjkzMjU5QzcuOTIxMzUgNC45MzI1OSA3Ljc1MjgxIDQuOTMyNTkgNy41ODQyNyA0Ljk2NjI5QzQuMzgyMDMgNS4zMDMzNyAxLjU4NDI3IDguMTAxMTMgMC45Nzc1MzEgMTEuNjQwNUMwLjcwNzg2OCAxMy4xMjM2IDEuMDExMjQgMTQuNDcxOSAxLjg1Mzk0IDE1LjQ4MzFDMi42MjkyMiAxNi40MjcgMy44NzY0MSAxNi45NjYzIDUuMjU4NDMgMTYuOTY2M0M1LjQ5NDM5IDE2Ljk2NjMgNS43MzAzNCAxNi45MzI2IDUuOTY2MyAxNi45MzI2QzguNzY0MDUgMTYuNTk1NSAxMC40MTU3IDE1LjI0NzIgMTEuMTIzNiAxMi44MjAyTDcuOTg4NzcgMTIuNjUxN0M3Ljg1Mzk0IDEzLjE1NzMgNy4yODA5IDE0LjEwMTEgNS44OTg4OCAxNC4yMDIyWiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+';

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
