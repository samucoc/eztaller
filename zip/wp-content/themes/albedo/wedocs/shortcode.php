<?php if ( $docs ) : ?>

<article class="wedocs-single-article">
	<div class="wedocs-shortcode-wrap">
		<ul class="wedocs-docs-list margins-medium">

			<?php foreach ($docs as $main_doc) : ?>
				<li class="wedocs-docs-single">
					<h4><a href="<?php echo get_permalink( $main_doc['doc']->ID ); ?>"><?php echo wp_kses_post( $main_doc['doc']->post_title ); ?></a></h4>

					<?php if ( $main_doc['sections'] ) : ?>

						<div class="inside">
							<table class="wedocs-doc-sections">
								<?php foreach ($main_doc['sections'] as $section) : ?>
									<tr>
										<td><a href="<?php echo get_permalink( $section->ID ); ?>"><?php echo $section->post_title; ?></a></td>
									</tr>
								<?php endforeach; ?>
							</table>
						</div>

					<?php endif; ?>

				</li>
			<?php endforeach; ?>

		</ul>
	</div>
</article>
<?php endif;
