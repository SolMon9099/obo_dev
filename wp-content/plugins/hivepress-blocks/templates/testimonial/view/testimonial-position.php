<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( $testimonial->get_position() ) :
	?>
	<div class="hp-testimonial__position hp-meta"><?php echo esc_html( $testimonial->get_position() ); ?></div>
	<?php
endif;
