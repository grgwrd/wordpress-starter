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

//Contact Form submit post. Creates Airtable record
function contactFormAirtable (){

//check for form action
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

    //table column header names
    $new_contact_form = array("First Name" => $firstName, "Last Name" => $lastName, "Email" => $email, "Phone Number" => $tel,
                              "Address" => $address, "City" => $city, "State" => $state, "Zip" => $zip,
                              "Comments" => $comments);

    //airpress record array
    $contact_form_data = AirpressConnect::create(CONFIG_ID, "Contact Submits", $new_contact_form);
    //airpress prepare query
    $query = new AirpressQuery("Contact Submits", CONFIG_ID);
    //call query and set records from new contact form data
    $collection = new AirpressCollection($query, false);
    $collection->setRecords(array($contact_form_data));

    //airpress record data inserted
    $contact_form_record = $collection;

    //Record is success if we get data returned. 
    if($contact_form_record <> NULL){
        $results = array("status"=>"success", "contactFormId"=>$contact_form_record);
    }else{
        $results = array("status"=>"error");
    }

    //return results from post
    echo json_encode($results);

  } // end if post

  die(); //exit post

} // end contactFormAirtable


//use ajax hooks for contact form submission
add_action('wp_ajax_contact_form_airtable', 'contactFormAirtable');
add_action('wp_ajax_nopriv_contact_form_airtable', 'contactFormAirtable');
