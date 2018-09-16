<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;

			$firstName = $_GET['firstName'];
			$lastName = $_GET['lastName'];
			$tel = $_GET['tel'];
			$email = $_GET['email'];
			$address = $_GET['address'];
			$city = $_GET['city'];
			$state = $_GET['state'];
			$zip = $_GET['zip'];
			$comments = $_GET['comments'];
			
			?>
			<div>
				<p id="contact-form">
					<p>
					<label>First Name:</label>
					<strong> <?php echo $firstName; ?> </strong></p>
					<p>
					<label>Last Name:</label>
					<strong> <?php echo $lastName; ?></strong>
					<p>
					<label>Email Address:</label>
					<strong> <?php echo $email; ?> </strong></p>
						<p>
					<label>Phone Number:</label>
					<strong> <?php echo $tel; ?> </strong></p>
						<p>
					<label>Street Address:</label>
					<strong> <?php echo $address; ?> </strong></p>
						<p>
					<label>City:</label>
					<strong> <?php echo $city; ?> </strong></p>
						<p>
					<label>State:</label>
					<strong> <?php echo $state; ?> </strong></p>
						<p>
					<label>Zip Code:</label>
					<strong> <?php echo $zip; ?> </strong></p>
						<p>
					<label>Comments:</label>
					<strong> <?php echo $comments; ?> </strong></p>
				</p>
			</div>
	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
