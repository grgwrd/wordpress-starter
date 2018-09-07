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


		//record_id for Airtable record from Contact Form Submission
	  $airtableRecordId = $_GET['record_id'];

		$query = new AirpressQuery();
		$query->setConfig("default");
		$query->table("Contact Submits")->view("Contact Submits");
		$contacts = new AirpressCollection($query);

		$recordId = $contacts[0]->record_id();
		if($recordId == $airtableRecordId){
			//create record vars
			$firstName = $contacts[0]["First Name"]."<br>";
			$lastName = $contacts[0]["Last Name"]."<br>";
			$email = $contacts[0]["Email"]."<br>";
			$tel = $contacts[0]["Phone Number"]."<br>";
			$address = $contacts[0]["Address"]."<br>";
			$city = $contacts[0]["City"]."<br>";
			$state = $contacts[0]["State"]."<br>";
			$zip = $contacts[0]["Zip"]."<br>";
			$comments = $contacts[0]["Comments"]."<br>";

			?>
			<div>
				<p id="contact-form">
					<label>First Name:</label>
					<span> <?php echo $firstName; ?> </span>
					<label>Last Name:</label>
					<span> <?php echo $lastName; ?>
					<label>Email Address:</label>
					<span> <?php echo $email; ?> </span>
					<label>Phone Number:</label>
					<span> <?php echo $tel; ?> </span>
					<label>Street Address:</label>
					<span> <?php echo $address; ?> </span>
					<label>City:</label>
					<span> <?php echo $city; ?> </span>
					<label>State:</label>
					<span> <?php echo $state; ?> </span>
					<label>Zip Code:</label>
					<span> <?php echo $zip; ?> </span>
					<label>Comments:</label>
					<span> <?php echo $comments; ?> </span>
				</p>

			</div>
		<?php } //end if airtable contact form ?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
