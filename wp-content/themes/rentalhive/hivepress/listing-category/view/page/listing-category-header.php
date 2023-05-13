<div class="hp-listing-category__header">
	<div class="hp-row">
		<div class="hp-col-sm-6 hp-col-xs-12">
			<?php
			echo ( new \HivePress\Blocks\Part(
				[
					'path'    => 'listing-category/view/listing-category-item-count',
					'context' => [ 'listing_category' => $listing_category ],
				]
			) )->render();
			?>
			<h1 class="hp-listing-category__name"><?php echo esc_html( $listing_category->get_name() ); ?></h1>
			<?php if ( $listing_category->get_description() ) : ?>
				<div class="hp-listing-category__description has-medium-font-size"><?php echo esc_html( $listing_category->get_description() ); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>
