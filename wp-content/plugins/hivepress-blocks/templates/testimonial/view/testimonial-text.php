<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( $testimonial->get_text() ) :
	?>
	<div class="hp-testimonial__text"><?php echo $testimonial->display_text(); ?></div>
	<?php
endif;
