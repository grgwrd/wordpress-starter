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
		?>
<style>
		input,
		textarea {
		background: #f7f7f7;
		background-image: -webkit-linear-gradient(rgba(255, 255, 255, 0), rgba(255, 255, 255, 0));
		border: 1px solid #d1d1d1;
		border-radius: 2px;
		color: #686868;
		padding: 0.625em 0.4375em;
		width: 100%;
		margin: 0 20px 20px 0;
		}
		#contact-form p, select, label{
		margin: 0 20px 20px 0;
}
</style>
		<div>
			<form id="contact-form">
			  <input type="hidden" name="action" value="contact_form_airtable" />
				<label>First Name:</label>
			  <input type="text" name="firstName" required placeholder="Enter first name" />
				<label>Last Name:</label>
				<input type="text" name="lastName" placeholder="Enter last name" />
				<label>Email Address:</label>
  		 <input type="email" name="email" required placeholder="Enter email" pattern="[a-z0-9!#$%&'*+/=?^_`{|}~.-]+@[a-z0-9-]+(\.[a-z0-9-]+)*"
			 		 size="30" required />
				<label>Phone Number:</label>
		    <input type="tel" required name="tel" placeholder="123-456-7890"
		           pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" />
		    <span class="validity"></span>
				<label>Street Address:</label>
				<input type="address" name="address" placeholder="Enter address" />
				<label>City:</label>
				<input type="city" name="city" placeholder="Enter city" />

				<label>Choose your state:</label>
				<select name="state">
					<option value="">Select State</option>
					<option value="AL">Alabama</option>
					<option value="AK">Alaska</option>
					<option value="AZ">Arizona</option>
					<option value="AR">Arkansas</option>
					<option value="CA">California</option>
					<option value="CO">Colorado</option>
					<option value="CT">Connecticut</option>
					<option value="DE">Delaware</option>
					<option value="DC">District of Columbia</option>
					<option value="FL">Florida</option>
					<option value="GA">Georgia</option>
					<option value="HI">Hawaii</option>
					<option value="ID">Idaho</option>
					<option value="IL">Illinois</option>
					<option value="IN">Indiana</option>
					<option value="IA">Iowa</option>
					<option value="KS">Kansas</option>
					<option value="KY">Kentucky</option>
					<option value="LA">Louisiana</option>
					<option value="ME">Maine</option>
					<option value="MD">Maryland</option>
					<option value="MA">Massachusetts</option>
					<option value="MI">Michigan</option>
					<option value="MN">Minnesota</option>
					<option value="MS">Mississippi</option>
					<option value="MO">Missouri</option>
					<option value="MT">Montana</option>
					<option value="NE">Nebraska</option>
					<option value="NV">Nevada</option>
					<option value="NH">New Hampshire</option>
					<option value="NJ">New Jersey</option>
					<option value="NM">New Mexico</option>
					<option value="NY">New York</option>
					<option value="NC">North Carolina</option>
					<option value="ND">North Dakota</option>
					<option value="OH">Ohio</option>
					<option value="OK">Oklahoma</option>
					<option value="OR">Oregon</option>
					<option value="PA">Pennsylvania</option>
					<option value="RI">Rhode Island</option>
					<option value="SC">South Carolina</option>
					<option value="SD">South Dakota</option>
					<option value="TN">Tennessee</option>
					<option value="TX">Texas</option>
					<option value="UT">Utah</option>
					<option value="VT">Vermont</option>
					<option value="VA">Virginia</option>
					<option value="WA">Washington</option>
					<option value="WV">West Virginia</option>
					<option value="WI">Wisconsin</option>
					<option value="WY">Wyoming</option>
				</select>
			<br>
				<label>Zip Code:</label>
				<input type="zip" name="zip" placeholder="Your zip code" />
				<label>Comments:</label>
			  <textarea name="comments" placeholder="Your comments"></textarea>
			  <input type="submit" value="Send Contact" />
			</form>
		</div>



	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php
// embed the javascript file that makes the AJAX request
wp_enqueue_script( 'contact_form_airtable','/wp-content/themes/custom/twentysixteen-child/js/contact-form.js', array( 'jquery' ) );

// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
wp_localize_script( 'contact_form_airtable', 'ContactFormAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

get_footer();

?>
