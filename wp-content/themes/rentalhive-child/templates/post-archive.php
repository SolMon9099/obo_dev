<article <?php post_class( 'post--archive' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<header class="post__header">
			<div class="post__image">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'ht_landscape_small' ); ?></a>
			</div>
			<?php get_template_part( 'templates/post/post-categories' ); ?>
		</header>
	<?php endif; ?>
	<div class="post__content">
		<?php
		if ( ! has_post_thumbnail() ) :
			get_template_part( 'templates/post/post-categories' );
		endif;

		if ( get_the_title() ) :
			?>
			<h4 class="post__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h4>
			<?php
		endif;

		get_template_part( 'templates/post/post-details' );
		?>
	</div>
</article>
