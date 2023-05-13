<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( $listing->get_images__id() ) :
	$image_urls = [];

	if ( get_option( 'hp_listing_enable_image_zoom' ) ) :
		$image_urls = $listing->get_images__url( 'large' );
	endif;

	$images = $listing->get_images();
	?>
	<div class="hp-listing__images content-slider hp-grid<?php if ( count( $images ) > 1 ) : ?> alignfull" data-component="slider" data-type="carousel" data-width="800"<?php else : ?>"<?php endif; ?>>
		<div class="hp-row">
			<?php foreach ( $images as $image_index => $image ) : ?>
				<div class="hp-grid__item hp-col-xs-12">
					<?php
					$image_url = hivepress()->helper->get_array_value( $image_urls, $image_index );

					if ( strpos( $image->get_mime_type(), 'video' ) === 0 ) :
						?>
						<video data-src="<?php echo esc_url( $image_url ); ?>" controls>
							<source src="<?php echo esc_url( $image->get_url() ); ?>" type="<?php echo esc_attr( $image->get_mime_type() ); ?>">
						</video>
					<?php else : ?>
						<img src="<?php echo esc_url( $image->get_url( 'hp_landscape_large' ) ); ?>" data-src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $listing->get_title() ); ?>" loading="lazy">
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
endif;
