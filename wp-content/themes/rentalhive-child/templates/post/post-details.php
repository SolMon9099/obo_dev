<div class="post__details">
	<?php if ( ! is_single() && is_sticky() ) : ?>
		<div class="post__sticky"><i class="fas fa-thumbtack"></i><span><?php echo esc_html_x( 'Pinned', 'post', 'rentalhive' ); ?></span></div>
	<?php else : ?>
		<time datetime="<?php echo esc_attr( get_the_time( 'Y-m-d' ) ); ?>" class="post__date"><?php echo esc_html( get_the_date() ); ?></time>
	<?php endif; ?>
	<div class="post__author">
		<?php
		// translators: the post author.
		printf( esc_html__( 'By %s', 'rentalhive' ), get_the_author() );
		?>
	</div>
	<?php if ( comments_open() && ! post_password_required() ) : ?>
		<a href="<?php comments_link(); ?>" class="post__comments"><?php comments_number(); ?></a>
	<?php endif; ?>
</div>
