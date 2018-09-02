<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

<form id="contact-form">
  <input type="hidden" name="action" value="contact_send" />
  <input type="text" name="name" placeholder="Your name..." />
  <input type="email" name="email" placeholder="Your email..." />
  <textarea name="message" placeholder="Your message..."></textarea>
  <input type="submit" value="Send Message" />
</form>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->
<link rel
<?php
wp_enqueue_script( 'contact-form', get_template_directory_uri() . '-child/js/contact-form.js', array ( 'jquery' ));

get_footer();
