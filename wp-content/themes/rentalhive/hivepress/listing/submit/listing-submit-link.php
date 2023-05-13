<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( get_option( 'hp_listing_enable_submission' ) ) :
	?>
	<button type="button" class="hp-menu__item hp-menu__item--listing-submit button button--primary" data-component="link" data-url="<?php echo esc_url( hivepress()->router->get_url( 'listing_submit_page' ) ); ?>"><i class="hp-icon fas fa-plus"></i><span><?php esc_html_e( 'List a Property', 'rentalhive' ); ?></span></button>
	<?php
endif;
