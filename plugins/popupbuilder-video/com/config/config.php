<?php
class SGPBVideoConfig
{
	public static function addDefine($name, $value)
	{
		if (!defined($name)) {
			define($name, $value);
		}
	}

	public static function init()
	{
		self::addDefine('SGPB_VIDEO_PATH', WP_PLUGIN_DIR.'/'.SGPB_VIDEO_FOLDER_NAME.'/');
		self::addDefine('SGPB_VIDEO_DYNAMIC_CLASS_PATH', SGPB_VIDEO_FOLDER_NAME.'/com/classes/');
		self::addDefine('SGPB_VIDEO_PUBLIC_URL', plugins_url().'/'.SGPB_VIDEO_FOLDER_NAME.'/public/');
		self::addDefine('SGPB_VIDEO_COM_PATH', SGPB_VIDEO_PATH.'com/');
		self::addDefine('SGPB_VIDEO_PUBLIC_PATH', SGPB_VIDEO_PATH.'public/');
		self::addDefine('SGPB_VIDEO_VIEWS_PATH', SGPB_VIDEO_PUBLIC_PATH.'views/');
		self::addDefine('SGPB_VIDEO_CLASSES_PATH', SGPB_VIDEO_COM_PATH.'classes/');
		self::addDefine('SGPB_VIDEO_EXTENSION_FILE_NAME', 'PopupBuilderVideoExtension.php');
		self::addDefine('SGPB_VIDEO_EXTENSION_CLASS_NAME', 'SGPBPopupBuilderVideoExtension');
		self::addDefine('SGPB_VIDEO_HELPERS', SGPB_VIDEO_COM_PATH.'helpers/');
		self::addDefine('SGPB_POPUP_TYPE_VIDEO', 'video');
		self::addDefine('SGPB_POPUP_TYPE_VIDEO_DISPLAY_NAME', 'Video');
		self::addDefine('SG_POPUP_POST_TYPE', 'popupbuilder');
		self::addDefine('SG_POPUP_TEXT_DOMAIN', 'popupBuilder');

		self::addDefine('SGPB_VIDEO_URL', plugins_url().'/'.SGPB_VIDEO_FOLDER_NAME.'/');

		self::addDefine('SGPB_VIDEO_PLUGIN_URL', 'https://wordpress.org/plugins/video/');
		self::addDefine('SGPB_VIDEO_JS_URL', SGPB_VIDEO_PUBLIC_URL.'js/');
		self::addDefine('SGPB_VIDEO_CSS_URL', SGPB_VIDEO_PUBLIC_URL.'css/');
		self::addDefine('SGPB_VIDEO_TEXT_DOMAIN', SGPB_VIDEO_FOLDER_NAME);
		self::addDefine('SGPB_VIDEO_PLUGIN_MAIN_FILE', 'PopupBuilderVideo.php');
		self::addDefine('SGPB_VIDEO_AVALIABLE_VERSION', 1);

		self::addDefine('SGPB_VIDEO_ACTION_KEY', 'PopupVideo');
		self::addDefine('SGPB_VIDEO_STORE_URL', 'https://popup-builder.com/');

		self::addDefine('SGPB_VIDEO_ITEM_ID', 106587);
		self::addDefine('SGPB_VIDEO_AUTHOR', 'Sygnoos');
		self::addDefine('SGPB_VIDEO_KEY', 'POPUP_VIDEO');
	}
}

SGPBVideoConfig::init();
