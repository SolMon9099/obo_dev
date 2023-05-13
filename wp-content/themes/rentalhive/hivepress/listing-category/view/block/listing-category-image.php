<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$image_url = hivepress()->get_url() . '/assets/images/placeholders/image-square.svg';

if ( $listing_category->get_image__url( 'hp_square_small' ) ) :
	$image_url = $listing_category->get_image__url( 'hp_square_small' );
endif;
?>
<a href="<?php echo esc_url( $listing_category_url ); ?>" class="hp-listing-category__image" style="background-image:url(<?php echo esc_url( $image_url ); ?>)"></a>
