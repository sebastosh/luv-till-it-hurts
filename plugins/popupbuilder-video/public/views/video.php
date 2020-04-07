<div class="sgpb-wrapper">
	<div class="row">
		<div class="col-md-8">
			<div class="row form-group">
				<label for="sgpb-video-url" class="col-md-5 control-label sgpb-static-padding-top">
					<?php _e('Enter video URL or Custom video', SG_POPUP_TEXT_DOMAIN);?>:
				</label>
				<div class="col-md-5">
					<input class="sgpb-video-url-input sgpb-full-width-events form-control" id="sgpb-video-url" placeholder='https://...' type="text" name="sgpb-video-url" value="<?php echo esc_attr($popupTypeObj->getOptionValue('sgpb-video-url')); ?>" required>
				</div>
				<div class="col-md-2">
					<input id="js-upload-video-button" class="button" type="button" value="Select Video">
				</div>
			</div>
			<?php
				$videoInvalidURL = $popupTypeObj->getOptionValue('sgpb-video-invalid-url');
				$notSupportedUrl = $popupTypeObj->getOptionValue('sgpb-video-not-supported-url');
			?>
			<div class="alert alert-warning sgpb-hide sgpb-video-warnings sgpb-same-origin-warning"
			     data-invalid-url="<?php echo $videoInvalidURL; ?>"
			     data-not-supported="<?php echo $notSupportedUrl; ?>"
			>
			</div>
		</div>
	</div>
</div>
