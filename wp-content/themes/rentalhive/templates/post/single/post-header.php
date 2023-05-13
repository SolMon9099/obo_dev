<div class="row">
	<div class="col-sm-8 col-sm-offset-2 col-xs-12">
		<div class="post__header">
			<?php
			get_template_part( 'templates/post/post-categories' );

			if ( get_the_title() ) :
				?>
				<h1 class="post__title"><?php the_title(); ?></h1>
				<?php
			endif;

			get_template_part( 'templates/post/post-details' );
			?>
		</div>
	</div>
</div>
