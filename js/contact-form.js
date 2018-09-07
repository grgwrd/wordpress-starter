jQuery(document).ready(function ($) {

    //airtable record contact form
    $('#contact-form').submit(function (e) {

      if (!validateInputs()) {
        return false;
      }
      
      e.preventDefault();

      var $this = $(this);
      $data = $(this).serializeArray();
      var dataObj = new Object();
      for($i = 0; $i < $data.length; $i++){

        var inputName = $data[$i]['name'];
        var inputValue = $data[$i]['value'];

        if(inputName === "action" || inputName === "email" ||
          inputName === "firstName" || inputName === "lastName" ||
          inputName === "tel" || inputName === "address"||
          inputName === "city" || inputName === "state" ||
          inputName === "zip" || inputName === "comments"){
              dataObj[inputName] = inputValue;
        }
      }

      var jsonObj = JSON.stringify(dataObj);

      $.ajax({
        type: 'POST',
        url: ContactFormAjax.ajaxurl,
        dataType: 'json',
        data: JSON.parse(jsonObj),
        success: function (data) {
          if (data.status === 'success') {
            window.location.href = "/thank-you-submit/?record_id="+data.record_id;
          } else {
            alert("error");
            handleFormError();
          }
        },
        error: function(MLHttpRequest, textStatus, errorThrown){
        alert("There was an error: " + errorThrown);
     },
      });
    });

    function validateInputs () {

      var submitForm = true;
      var firstName = $('#contact-form > input[name="firstName"]'),
          lastName = $('#contact-form > input[name="lastName"]'),
          email = $('#contact-form > input[name="email"]'),
          phoneNumber = $('#contact-form > input[name="tel"]');
          zipcode = $('#contact-form > input[name="zip"]');

          $message = $('#contact-form > textarea').val();
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

      return submitForm;
    }

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
