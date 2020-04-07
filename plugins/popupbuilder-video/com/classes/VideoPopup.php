<?php
namespace sgpb;
require_once(SG_POPUP_CLASSES_POPUPS_PATH.'/SGPopup.php');

class VideoPopup extends SGPopup
{
	public function __construct()
	{
		add_filter('sgpbPopupDefaultOptions', array($this, 'filterPopupDefaultOptions'));
	}

	public function adminJsInit()
	{
		add_filter('sgpbAdminJsFiles', array($this, 'adminJsFilter'), 1, 1);
	}

	private function frontendFilters()
	{
		add_filter('sgpbVideoJsFilter', array($this, 'popupFrontJsFilter'), 1, 1);
		add_filter('sgpbVideoCssFiles', array($this, 'popupFrontCssFilter'), 1, 1);
	}

	public function adminJsFilter($jsFiles)
	{
		$jsFiles[] = array('folderUrl' => SGPB_VIDEO_JS_URL, 'filename' => 'Video.js');

		return $jsFiles;
	}

	public function filterPopupDefaultOptions($defaultOptions)
	{
		$changingOptions = array(
			'sgpb-width' => array('name' => 'sgpb-width', 'type' => 'text', 'defaultValue' => '60%'),
			'sgpb-height' => array('name' => 'sgpb-height', 'type' => 'text', 'defaultValue' => '60%')
		);

		$defaultOptions = $this->changeDefaultOptionsByNames($defaultOptions, $changingOptions);

		$defaultOptions[] = array('name' => 'sgpb-video-autoplay', 'type' => 'checkbox', 'defaultValue' => '');
		$defaultOptions[] = array('name' => 'sgpb-video-invalid-url', 'type' => 'text', 'defaultValue' => __('Invalid URL', SG_POPUP_TEXT_DOMAIN).'.');
		$defaultOptions[] = array('name' => 'sgpb-video-not-supported-url', 'type' => 'text', 'defaultValue' => __('This video URL is not supported', SG_POPUP_TEXT_DOMAIN).'.');

		return $defaultOptions;
	}

	public function popupFrontJsFilter($jsFiles)
	{
		$jsFiles['jsFiles'][] = array('folderUrl'=> SGPB_VIDEO_JS_URL, 'filename' => 'Player.js');
		$jsFiles['jsFiles'][] = array('folderUrl'=> SGPB_VIDEO_JS_URL, 'filename' => 'Video.js', 'dep' => array('PopupBuilder.js'));
		$options = $this->getOptions();
		$id = $this->getId();
		$jsFiles['localizeData'][] = array(
			'handle' => 'Video.js',
			'name' => 'SGPBVideoParams'.$id,
			'data' => $options
		);

		return $jsFiles;
	}

	public function popupFrontCssFilter($cssFiles)
	{
		$cssFiles[] = array(
			'folderUrl'=> SGPB_VIDEO_CSS_URL,
			'filename' => 'Player.css',
			'inFooter' => false
		);

		return $cssFiles;
	}

	public function getOptionValue($optionName, $forceDefaultValue = false)
	{
		return parent::getOptionValue($optionName, $forceDefaultValue);
	}

	public function getRemoveOptions()
	{
		// Where 1 mean this options must not show for this popup type
		$removeOptions = array(
			'sgpb-content-click' => 1,
			'sgpb-popup-dimension-mode' => 1,
			'sgpb-force-rtl' => 1
		);
		$parentOptions = parent::getRemoveOptions();

		return $removeOptions + $parentOptions;
	}

	public function getPopupTypeOptionsView()
	{
		return array(
			'filePath' => SGPB_VIDEO_VIEWS_PATH.'additional.php',
			'metaboxTitle' => 'Video Popup Additional Options'
		);
	}

	public function getPopupTypeMainView()
	{
		$this->adminJsInit();
		return array(
			'filePath' => SGPB_VIDEO_VIEWS_PATH.'video.php',
			'metaboxTitle' => 'Video Popup Main Options'
		);
	}

	/**
	 * It's return current post what's support ex( title, editor, ...)
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function getPopupTypeSupports()
	{
		return array('title');
	}

	private function prepareVideoIframe($videoUrl = '')
	{
		$id = $this->getId();
		$videoIframe = '<div class="sgpb-video-iframe-wrapper">';
		$videoIframe .= '<iframe allowfullscreen="true" src="" data-attr-src="'.$videoUrl.'" class="sgpb-iframe-spiner sgpb-iframe-'.$id.'" width="100%" height="100%"></iframe>';
		$videoIframe .= '</div>';

		return $videoIframe;
	}

	private function customVideoHtml($videoUrl = '')
	{
		$id = $this->getId();
		$videoIframe = '
			<video id="sgpb-video-'.$id.'" class="video-js vjs-default-skin" controls preload="auto" data-setup="{}">
				<source src="'.$videoUrl.'" type="video/mp4">
			</video>
		';

		return $videoIframe;
	}

	private function getVideoUrl()
	{
		$options = $this->getOptions();
		$videoUrlArgs = array();
		$videoParam = '';
		$isAutoplay = '';

		if (empty($options['sgpb-video-url'])) {
			return $this->getInvalidVideoErrorMessage();
		}
		$data = $options['sgpb-video-url'];

		$protocol = parse_url($data);
		if (empty($protocol['scheme'])) {
			//if no setted protocol, add 'https'
			//our supported video formats works (supportes) https
			$data = 'https://'.$data;
		}

		$parsed = parse_url($data);
		if (empty($parsed['host'])) {
			return $this->getInvalidVideoErrorMessage();
		}
		$videoHost = $parsed['host'];

		$supportedDailyHosts = array(
			'www.dailymotion.com',
			'dailymotion.com',
			'www.dai.ly',
			'dai.ly'
		);

		$supportedYoutubeHosts = array(
			'www.youtube.com',
			'youtube.com',
			'www.youtube-nocookie.com',
			'youtube-nocookie.com',
			'youtu.be',
			'www.youtu.be'
		);

		$supportedVimeoHosts = array(
			'www.vimeo.com',
			'vimeo.com',
			'player.vimeo.com',
			'www.player.vimeo.com'
		);

		if (!empty($parsed['query'])) {
			parse_str($parsed['query'], $output);
			if (!empty($output['v'])) {
				$videoParam = $output['v'];
				$array1 = explode('?', @$output['v']);
				$isAutoplay = in_array('autoplay=1', $array1);
			}
		}

		preg_match('/www.dailymotion.com/', $data, $getDailyHost);

		if (!$isAutoplay && !empty($options['sgpb-video-autoplay']) && $options['sgpb-video-autoplay'] == 'on') {
			$videoUrlArgs['autoplay'] = 1;
			$videoUrlArgs['iv_load_policy'] = 3;
			$videoUrlArgs['mute'] = 1;
			$videoUrlArgs['muted'] = 1;
		}

		if (in_array($videoHost, $supportedYoutubeHosts)) {//youtube
			$videoUrl = $this->prepareYoutubeVideo($data, $videoParam);
		}
		else if (in_array($videoHost, $supportedVimeoHosts)) {//vimeo
			$videoUrl = $this->prepareVimeoVideo($data);
		}
		else if (in_array($videoHost, $supportedDailyHosts) || in_array(@$getDailyHost[0], $supportedDailyHosts)) {//dailymotion
			$videoUrl = $this->prepareDailymotionVideo($data);
		}
		else {
			return $this->customVideoHtml($data);
		}

		if (empty($videoUrl)) {
			return $this->getInvalidVideoErrorMessage();
		}

		$parsedUrl = parse_url($videoUrl);

		if (empty($parsedUrl['path'])) {
			$videoUrl .= '/';
		}

		$videoUrlArgs['enablejsapi'] = 1;
		$videoUrl = add_query_arg($videoUrlArgs, $videoUrl);

		return $this->prepareVideoIframe($videoUrl);
	}

	public function getPopupTypeContent()
	{
		$this->frontendFilters();
		$popupContent = $this->getContent();

		$videoIframe = $this->getVideoUrl();
		$popupContent .= $videoIframe;
		$popupContent .= '<style>';
		$popupContent .= '.sgpb-popup-builder-content-html {';
		$popupContent .= 'width: 100%;';
		$popupContent .= 'height: 100%;';
		$popupContent .= 'overflow: auto';
		$popupContent .= '}';
		$popupContent .= '</style>';

		return $popupContent;
	}

	public function getExtraRenderOptions()
	{
		$options = $this->getOptions();

		return $options;
	}

	private function getInvalidVideoErrorMessage()
	{
		$errorMessage = '<div class="sgpb-video-error-message-wrapper">';
		$errorMessage .= '<h1 style="text-align: center;">'.__('Your video format is not supported', SG_POPUP_TEXT_DOMAIN).'!</h1>';
		$errorMessage .= '<h3>'.__('Our Video popup supports the following video streams and video formats: YouTube, Vimeo, Daily Motion, Mp4, OGV/OGG, WebM, MOV', SG_POPUP_TEXT_DOMAIN).'.</h3>';
		$errorMessage .= '<h3>'.__('Please, make sure your video is in one of those formats', SG_POPUP_TEXT_DOMAIN).'.</h3>';
		$errorMessage .= '</div>';

		return $errorMessage;
	}

	private function prepareYoutubeVideo($data, $videoParam = '')
	{
		if ($videoParam) {
			$videoUrl = 'https://www.youtube.com/embed/'.$videoParam;
		}
		else {
			$videoUrl = '';
			$videoUrlArray = explode('/', $data);
			if (empty($videoUrlArray)) {
				return $videoUrl;
			}
			$videoUrl = 'https://www.youtube.com/embed/'.$videoUrlArray[count($videoUrlArray)-1];
		}
		return $videoUrl;
	}

	private function prepareVimeoVideo($data)
	{
		$videoUrl = '';
		$videoUrlArray = explode('/', $data);
		if (empty($videoUrlArray)) {
			return $videoUrl;
		}

		$videoUrl = 'https://player.vimeo.com/video/'.$videoUrlArray[count($videoUrlArray)-1];

		return $videoUrl;
	}

	private function prepareDailymotionVideo($data)
	{
		$videoUrl = '';
		$videoUrlArray = explode('/', $data);
		if (empty($videoUrlArray)) {
			return $videoUrl;
		}

		$dailymotionId = $videoUrlArray[count($videoUrlArray)-1];
		$videoUrl = '//www.dailymotion.com/embed/video/'.$dailymotionId;

		return $videoUrl;
	}
}
