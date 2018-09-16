jQuery(document).ready(function ($) {

    //contact form insert record for airtable Contact Submits
    $('#contact-form').submit(function (e) {

      e.preventDefault();

      //return to form is input validations fails
      if (!validateInputs()) {
        return false;
      }

      //declare form data and create array
      var $this = $(this);
      $data = $(this).serializeArray();

      //JSON object to send for ajax params
      var jsonObj = new Object();

      //create object based off of form input names and values
      for($i = 0; $i < $data.length; $i++){
        var inputName = $data[$i]['name'];
        var inputValue = $data[$i]['value'];
        if(inputName !== "submit"){
              jsonObj[inputName] = inputValue;
        }
      }

      //send post to insert airtable record through Aipress WP Plugin
      $.ajax({
        type: 'POST',
        url: ContactFormAjax.ajaxurl,
        dataType: 'json',
        data: jsonObj,
        success: function (data) {
          if (data.status === 'success') {
          var submitData = data.contactFormId[0];
          //loop through sumbitted data and rename key names to form names to keep consistent, match on values
          $.each(submitData, function(submitKey, submitValue){
            $.each(jsonObj, function(formKey, formValue){
                if(submitValue == formValue){
                  delete submitData[submitKey];
                  submitData[formKey] = submitValue;
                }
            });
          });
          //redirect to Thank You submission page with submitData params
           window.location.href = "/thank-you/?"+$.param(submitData);
          } else {
            alert("error inserting records");
            handleFormError();
          }
        },
        error: function(MLHttpRequest, textStatus, errorThrown){
        alert("There was an error: " + errorThrown);
     },
      });
    });

    //validate parameters with jQuery to provide incase HTML5 is not available
    function validateInputs () {

      //return value
      var submitForm = true;

      //inpue values to check for specifics
      var firstName = $('#contact-form > input[name="firstName"]'),
          lastName = $('#contact-form > input[name="lastName"]'),
          email = $('#contact-form > input[name="email"]'),
          phoneNumber = $('#contact-form > input[name="tel"]'),
          zipcode = $('#contact-form > input[name="zip"]');

      if (!firstName.val()) {
          $(firstName).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Please enter first name</div>").focus();
          submitForm = false;
      }
      if (!lastName.val()) {
          $(lastName).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Please enter last name</div>").focus();
          submitForm = false;
      }
      if (!isEmailAddressValid(email.val())) {
          $(email).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Please enter valid email address</div>").focus();
          submitForm = false;
      }

      if (!isPhoneNumberValid(phoneNumber.val())) {
          $(phoneNumber).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Please enter valid phone number (123-456-7890)</div>").focus();
          submitForm = false;
      }

      if (!isZipCodeValid(zipcode.val()) && zipcode.val()) {
          $(zipcode).after("<div class='validation' style='color:red;margin-bottom: 20px;'>Please enter valid zip code (66044)</div>").focus();
          submitForm = false;
      }

      return submitForm; // true or false
    }

//check field pattern validation methods below
    function isZipCodeValid(zipcode){
      var pattern = /[0-9]{5}/;
      return pattern.test(zipcode);
    }

    function isPhoneNumberValid(phoneNumber){
      var pattern = /[0-9]{3}-[0-9]{3}-[0-9]{4}/;
      return pattern.test(phoneNumber);
    }

    function isEmailAddressValid(email){
      var pattern = /[\w.]+@[a-zA-Z_-]+?(?:\.[a-zA-Z]{2,6})+/gim;
      return pattern.test(email);
    }

});
