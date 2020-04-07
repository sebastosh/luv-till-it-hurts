<div class="sgpb-wrapper">
	<div class="row">
		<div class="col-md-8">
			<div class="row form-group">
				<label for="sgpb-autoplay" class="col-md-5 control-label">
					<?php _e('Autoplay', SG_POPUP_TEXT_DOMAIN);?>:
				</label>
				<div class="col-md-6">
					<input id="sgpb-autoplay" name="sgpb-video-autoplay" type="checkbox" <?php echo esc_attr($popupTypeObj->getOptionValue('sgpb-video-autoplay')); ?>>
				</div>
			</div>
		</div>
	</div>
</div>
