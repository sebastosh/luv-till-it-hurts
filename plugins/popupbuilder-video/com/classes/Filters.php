<?php
namespace sgpbvideo;

class Filters
{
	public function __construct()
	{
		add_filter('sgpbAddPopupTypePath', array($this, 'typePaths'), 10, 1);
		if (isset($_GET['post_type']) && $_GET['post_type'] == SG_POPUP_POST_TYPE) {
			add_filter('sgpbAddPopupType', array($this, 'popupType'), 10, 1);
			add_filter('sgpbAddPopupTypeLabels', array($this, 'addPopupTypeLabels'), 11, 1);
		}
		add_filter('sgpbHidePageBuilderEditButtons', array($this, 'hidePageBuilderEditButtons'), 10, 1);
	}

	public function typePaths($typePaths)
	{
		$typePaths[SGPB_POPUP_TYPE_VIDEO] = SGPB_VIDEO_CLASSES_PATH;

		return $typePaths;
	}

	public function addPopupTypeLabels($labels)
	{
		$labels[SGPB_POPUP_TYPE_VIDEO] = __(SGPB_POPUP_TYPE_VIDEO_DISPLAY_NAME, SG_POPUP_TEXT_DOMAIN);

		return $labels;
	}

	public function popupType($popupType)
	{
		$popupType[SGPB_POPUP_TYPE_VIDEO] = SGPB_VIDEO_AVALIABLE_VERSION;

		return $popupType;
	}

	public function hidePageBuilderEditButtons($popupTypes = array())
	{
		$popupTypes[] = SGPB_POPUP_TYPE_VIDEO;

		return $popupTypes;
	}
}
