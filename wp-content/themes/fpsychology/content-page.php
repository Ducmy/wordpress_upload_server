<?php
/**
 * The template used for displaying page content
 *
 * @subpackage fPsychology
 * @author tishonator
 * @since fPsychology 1.0.0
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="page-content">
		<?php echo '<h1 class="entry-title">'.get_the_title().'</h1>'; ?>
		<?php fpsychology_the_content_single(); ?>
	</div><!-- .page-content -->

	<div class="page-after-content">
		
		<?php if ( ! post_password_required() ) : ?>

			<?php if ('open' == $post->comment_status) : ?>

				<span class="icon comments-icon">
					<?php comments_popup_link(__( 'No Comments', 'fpsychology' ), __( '1 Comment', 'fpsychology' ), __( '% Comments', 'fpsychology' ), '', __( 'Comments are closed.', 'fpsychology' )); ?>
				</span>

			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'fpsychology' ), '<span class="edit-icon">', '</span>' ); ?>
		<?php endif; ?>

	</div><!-- .page-after-content -->
</article><!-- #post-## -->

