<?php
/**
 * All data retrieval and saving happens from this file.
 *
 * @package WPPluginBlueprint
 */

namespace Blueprint;

/**
 * \Blueprint\Data
 * This class does not have a constructor to get instantiated, just static methods.
 */
final class Data {

	/**
	 * Data loaded onto window.NewfoldRuntime
	 *
	 * @return array
	 */
	public static function runtime() {
		global $blueprint_module_container;

		$runtime = array(
			'url'     => BLUEPRINT_BUILD_URL,
			'version' => BLUEPRINT_PLUGIN_VERSION,
			'assets'  => BLUEPRINT_PLUGIN_URL . 'assets/',
			'brand'   => $blueprint_module_container->plugin()->brand,
		);

		return $runtime;
	}

}
