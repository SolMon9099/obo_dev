<?php
// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( $testimonial->get_author() ) :
	?>
	<h4 class="hp-testimonial__author">
		<?php
		if ( $testimonial->get_url() ) :
			?>
			<a href="<?php echo esc_url( $testimonial->get_url() ); ?>" target="_blank"><?php echo esc_html( $testimonial->get_author() ); ?></a>
			<?php
		else :
			echo esc_html( $testimonial->get_author() );
		endif;
		?>
	</h4>
	<?php
endif;
