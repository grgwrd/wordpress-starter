<?php

// This is 'twentysixteen-style' for the Twenty Sixteen theme.
function my_theme_enqueue_styles() {
    $parent_style = 'twentysixteen-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );

}
//twentysixteen theme hook
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

// embed the javascript file that makes the AJAX request
wp_enqueue_script( 'contact_form_airtable','/wp-content/themes/custom/twentysixteen-child/js/contact-form.js', array( 'jquery' ) );
// declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
wp_localize_script( 'contact_form_airtable', 'ContactFormAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

add_action('wp_ajax_contact_form_airtable', 'contactFormAirtable');
add_action('wp_ajax_nopriv_contact_form_airtable', 'contactFormAirtable');

//Contact Form submit post. Creates Airtable record and send email
function contactFormAirtable (){

  if($_POST['action'] == 'contact_form_airtable'){

    //post vars
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $comments = $_POST['comments'];

    //insert records for airtable
    define("CONFIG_ID", 0);
    define("CONFIG_NAME", "Default");

    $new_contact_form = array("First Name" => $firstName, "Last Name" => $lastName, "Email" => $email, "Phone Number" => $tel,
                              "Address" => $address, "City" => $city, "State" => $state, "Zip" => $zip,
                              "Comments" => $comments);

    $contact_form_data = AirpressConnect::create(CONFIG_ID, "Contact Submits", $new_contact_form);

    $query = new AirpressQuery("Contact Submits", CONFIG_ID);
    $collection = new AirpressCollection($query, false);
    $collection->setRecords(array($contact_form_data));

    $contact_form_record = $collection[0];

    $contact_form_id = $contact_form_recrod->record_id();

    if($contact_form_id > 0){
      //email airtable users to notify record has been created
      $subject = 'Contact Form: '.$reason.' - '.$_POST['name'];
      $headers = 'From: My Blog Contact Form <contact@me.com>';
      $send_to = "airtableContact@airtabletest.com";
      $subject = "Airtable Record Created Contact Form";
      $message = "A record has been created in the Contact Form Submits Tables for Airtable";

      //send email to notify airtable users
      try {
        if (wp_mail($send_to, $subject, $message, $headers)) {
          echo json_encode(array('status' => 'success', 'message' => 'Contact message sent.'));
          exit;
        } else {
          throw new Exception('Failed to send email.');
        }
      } catch (Exception $e) {
        echo json_encode(array('status' => 'error', 'message' => $e->getMessage()));
        exit;
      }

      //send results back to JS
      $results = array("status"=>"success", "contactFormId"=>$contact_form_id);

      //return results from post
      echo json_encode($results);
    } // end if record

  } // end if post

  die(); //exit post

} // end contactFormAirtable


//use ajax hooks for contact form submission
add_action('wp_ajax_contact_form_airtable', 'contactFormAirtable');
add_action('wp_ajax_nopriv_contact_form_airtable', 'contactFormAirtable');
