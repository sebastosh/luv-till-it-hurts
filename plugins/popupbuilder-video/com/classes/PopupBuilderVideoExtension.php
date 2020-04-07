<?php
require_once(SG_POPUP_EXTENSION_PATH.'SgpbIPopupExtension.php');
use sgpbvideo\AdminHelper;

class SGPBPopupBuilderVideoExtension implements SgpbIPopupExtension
{
	public function getScripts($page, $data)
	{
		if (empty($data['popupType']) || @$data['popupType'] != SGPB_POPUP_TYPE_VIDEO) {
			return false;
		}

		$jsFiles = array();
		$localizeData = array();
		$translatedData = AdminHelper::getJsLocalizedData();
		$jsFiles[] = array('folderUrl'=> SGPB_VIDEO_JS_URL, 'filename' => 'Video.js');
		$localizeData[] = array(
			'handle' => 'Video.js',
			'name' => 'SGPB_VIDEO_JS_LOCALIZATION',
			'data' => $translatedData
		);

		$scriptData = array(
			'jsFiles' => apply_filters('sgpbVideoAdminJsFiles', $jsFiles),
			'localizeData' => apply_filters('sgpbVideoAdminJsLocalizedData', $localizeData)
		);

		$scriptData = apply_filters('sgpbVideoAdminJs', $scriptData);

		return $scriptData;
	}

	public function getStyles($page, $data)
	{
		$cssFiles = array();
		// for current popup type page load and for popup types pages too
		if (@$data['popupType'] == SGPB_POPUP_TYPE_VIDEO || $page == 'popupType') {
			// here we will include current popup type custom styles
		}

		$cssData = array(
			'cssFiles' => apply_filters('sgpbVideoAdminCssFiles', $cssFiles)
		);

		return $cssData;
	}

	public function getFrontendScripts($page, $data)
	{
		$jsFiles = array();
		$localizeData = array();

		$hasVideoPopup = $this->hasConditionFromLoadedPopups($data['popups']);
		if (!$hasVideoPopup) {
			return false;
		}

		$scriptData = array(
			'jsFiles' => apply_filters('sgpbVideoJsFiles', $jsFiles),
			'localizeData' => apply_filters('sgpbVideoJsLocalizedData', $localizeData)
		);

		$scriptData = apply_filters('sgpbVideoJsFilter', $scriptData);

		return $scriptData;
	}

	public function getFrontendStyles($page, $data)
	{
		$cssFiles = array();

		$hasVideoPopup = $this->hasConditionFromLoadedPopups($data['popups']);

		if (!$hasVideoPopup) {
			return false;
		}
		$cssData = array(
			'cssFiles' => apply_filters('sgpbVideoCssFiles', $cssFiles)
		);

		return $cssData;
	}

	protected function hasConditionFromLoadedPopups($popups)
	{
		$hasType = false;

		foreach ($popups as $popup) {
			if (!is_object($popup)) {
				continue;
			}
			if ($popup->getType() == SGPB_POPUP_TYPE_VIDEO) {
				$hasType = true;
				break;
			}
		}

		return $hasType;
	}
}
