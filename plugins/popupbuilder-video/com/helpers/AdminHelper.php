<?php
namespace sgpbvideo;


class AdminHelper
{
	public static function oldPluginDetected()
	{
		$hasOldPlugin = false;
		$message = '';

		$pbEarlyVersions = array(
			'popup-builder-silver',
			'popup-builder-gold',
			'popup-builder-platinum',
			'sg-popup-builder-silver',
			'sg-popup-builder-gold',
			'sg-popup-builder-platinum'
		);
		foreach ($pbEarlyVersions as $pbEarlyVersion) {
			$file = WP_PLUGIN_DIR.'/'.$pbEarlyVersion;
			if (file_exists($file)) {
				$pluginKey = $pbEarlyVersion.'/popup-builderPro.php';
				include_once(ABSPATH.'wp-admin/includes/plugin.php');
				if (is_plugin_active($pluginKey)) {
					$hasOldPlugin = true;
					break;
				}
			}
		}

		if ($hasOldPlugin) {
			$message = __("You're using an old version of Popup Builder plugin. We have a brand-new version that you can download from your popup-builder.com account. Please, install the new version of Popup Builder plugin to be able to use it with the new extensions.", 'popupBuilder').'.';
		}

		$result = array(
			'status' => $hasOldPlugin,
			'message' => $message
		);

		return $result;
	}

	/*
	 * check allow to install current extension
	 */
	public static function isSatisfyParameters()
	{
		$hasOldPlugin = AdminHelper::oldPluginDetected();

		if (@$hasOldPlugin['status'] == true) {
			return array('status' => false, 'message' => @$hasOldPlugin['message']);
		}

		return array('status' => true, 'message' => '');
	}

	public static function getJsLocalizedData()
	{
		$translatedData = array(
			'videoSupportAlertMessage' => __('This video format is not supported', SG_POPUP_TEXT_DOMAIN).'.'
		);

		return $translatedData;
	}

}
