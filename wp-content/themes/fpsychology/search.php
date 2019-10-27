<?php
/**
 * The template for displaying search results pages.
 *
 * @subpackage fPsychology
 * @author tishonator
 * @since fPsychology 1.0.0
 *
 */

 get_header(); ?>



<div id="main-content-wrapper">

	<div id="main-content">

		<div id="infoTxt">
			<?php printf( esc_html__( 'You searched for "%s". Here are the results:', 'fpsychology' ),
						get_search_query() );
			?>
		</div><!-- #infoTxt -->

	<?php if ( have_posts() ) :

				// starts the loop
				while ( have_posts() ) :

					the_post();

					/*
					 * include the post format-specific template for the content.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;
	
				the_posts_pagination( array(
		                        'prev_next' => '',
		                    ) );

		else :

				// if no content is loaded, show the 'no found' template
				get_template_part( 'content', 'none' );
			
		  endif;
	?>

	</div><!-- #main-content -->

	<?php get_sidebar(); ?>

</div><!-- #main-content-wrapper -->

<?php get_footer(); ?>