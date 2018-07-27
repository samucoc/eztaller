<?php
	/**
	 * Gallery post format template part
	 **/

	get_template_part('template-parts/blog/single-wide/post-data');
?>
<div class="fw-page-builder-content">
	<div id="wplab-albedo-post-single-gallery" class="pb-section stretch_row_content_no_paddings">
		<div class="row-single-post-gallery">
			<?php
				echo wplab_albedo_media::gallery_shortcode( array(
					'slides_num' => 2,
					'slides_medium_num' => 2,
					'slides_small_num' => 1,
					'initial_slide' => 1
				));
			?>
		</div>
	</div>
	<div class="row-full-width"></div>
</div>
