<?php
$sidebar = is_active_sidebar( 'blog_sidebar' );

get_header();
?>
<div class="row">
	<main class="col-xs-12 <?php if ( $sidebar ) : ?>col-sm-8<?php endif; ?>">
		<?php if ( have_posts() ) : ?>
			<div class="posts">
				<div class="row">
					<?php
					while ( have_posts() ) :
						the_post();
						?>
						<div class="col-sm-<?php if ( $sidebar ) : ?>6<?php else : ?>4<?php endif; ?> col-xs-12">
							<?php get_template_part( 'templates/post-archive' ); ?>
						</div>
						<?php
					endwhile;
					?>
				</div>
			</div>
			<?php
			the_posts_pagination();
		else :
			?>
			<h2><?php esc_html_e( 'Nothing found', 'rentalhive' ); ?></h2>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'rentalhive' ); ?></p>
		<?php endif; ?>
	</main>
	<?php get_sidebar(); ?>
</div>
<?php
get_footer();
