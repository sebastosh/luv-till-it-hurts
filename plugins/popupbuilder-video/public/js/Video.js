function SGPBVideo()
{

}

SGPBVideo.prototype.sgpbInit = function()
{
	if (!jQuery('#title').length) {
		this.eventListeners();
	}
	this.videoUpload();
}

SGPBVideo.prototype.iframeCreator = function(args)
{
	var popupId = parseInt(args['sgpb-post-id']);
	if (!jQuery('.sgpb-iframe-'+popupId).length) {
		return false;
	}

	var currentSrc = jQuery('.sgpb-iframe-'+popupId).attr('data-attr-src');
	if (typeof currentSrc == 'undefined' || !currentSrc.length) {
		return false;
	}

	var currentSrc = currentSrc.replace('muted=1', '');
	var currentSrc = currentSrc.replace('mute=1', '');
	var classes = jQuery('.sgpb-iframe-'+popupId).attr('class');

	setTimeout(function () {
		var iframe = document.createElement('iframe');
		iframe.setAttribute('src', currentSrc);
		iframe.setAttribute('allow', 'autoplay');
		iframe.setAttribute('allow', 'autoplay');
		iframe.setAttribute('allowfullscreen', true);
		iframe.style.width = '100%';
		iframe.style.height = '100%';

		var iframeParent = jQuery('.sgpb-iframe-'+popupId).parent();
		jQuery('.sgpb-iframe-'+popupId).remove();
		iframeParent.append(iframe);
	}, 0);
};


SGPBVideo.prototype.eventListeners = function()
{
	var that = this;
	sgAddEvent(window, 'sgpbDidOpen', function(e) {
		var id = e.detail.popupId;
		videoParam = eval('SGPBVideoParams'+id);
		dataAutoplay = videoParam['sgpb-video-autoplay'];
		if (jQuery('#sgpb-video-'+id).length) {
			videojs('#sgpb-video-'+id).muted(false);
			if (typeof dataAutoplay != 'undefined') {
				setTimeout(function() {
					videojs('#sgpb-video-'+id).autoplay('muted');
				}, 200);
			}
		}
	});

	sgAddEvent(window, 'sgpbDidClose', function(e) {
		var id = e.detail.popupId;
		if (jQuery('#sgpb-video-'+id).length) {
			setTimeout(function() {
				videojs('#sgpb-video-'+id).muted(true);
			}, 200);
		}
	});

	jQuery(window).bind('sgpbClickEvent', function (e, args) {
		that.iframeCreator(args);
	});
};


SGPBVideo.prototype.videoUpload = function()
{
	var supportedVideoTypes = ['video/mp4', 'video/quicktime', 'video/ogv', 'video/ogg', 'video/webm'];
	var custom_uploader;
	jQuery('#js-upload-video-button').click(function(e) {
		e.preventDefault();
		/* If the uploader object has already been created, reopen the dialog */
		if (custom_uploader) {
			custom_uploader.open();
			return;
		}
		/* Extend the wp.media object */
		custom_uploader = wp.media.frames.file_frame = wp.media({
			titleFF: 'Choose Video',
			button: {
				text: 'Choose Video'
			},
			multiple: false,
			library: {
				type: 'video'
			}
		});
		/* When a file is selected, grab the URL and set it as the text field's value */
		custom_uploader.on('select', function() {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			if (supportedVideoTypes.indexOf(attachment.mime) === -1) {
				alert(SGPB_VIDEO_JS_LOCALIZATION['videoSupportAlertMessage']);
				return;
			}
			jQuery('#sgpb-video-url').val(attachment.url);
		});
		/* Open the uploader dialog */
		custom_uploader.open();
	});
};

jQuery(document).ready(function() {
	var videoObj = new SGPBVideo();
	videoObj.sgpbInit();
});

