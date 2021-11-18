/*==============================================================*/
// Complete Dentistry Appointment Request Form JS
/*==============================================================*/
(function ($) {
    "use strict"; // Start of use strict
    $("#appointmentRequestForm").validator().on("submit", function (event) {
        if (event.isDefaultPrevented()) {
            formError();
            submitMSG(false, "There was an issue submitting the form.");
        }
        else {
            event.preventDefault();
            submitForm();
        }
    });

    function submitForm(){
        if ($("#new_patient").val() == "yes"){
            var patient_status = "New Patient";
        } else {
            var patient_status = "Existing Patient";
        }

        var form = $("#appointmentRequestForm")[0];
        var form_data = new FormData(form);
        form_data.append("patient_status", patient_status);

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            url: "assets/php/process_form.php",
            data: form_data,
            success : function(text){
                if (text == "success"){
                    formSuccess();
                } else {
                    formError();
                    submitMSG(false,text);
                }
            },
            error : function(){
                submitMSG(false, "Sorry, something is wrong on our end. Please contact our office by phone or email.");
            }
        });
    }
    function formSuccess(){
        $("#appointmentRequestForm")[0].reset();
        submitMSG(true, "Your appointment request has been received. We will be in touch with you shortly!")
    }
    function formError(){
        submitMSG(false, "There was an issue submitting the form.")
    }
    function submitMSG(valid, msg){
        if(valid){
            var msgClasses = "h6 tada text-success";
        } else {
            var msgClasses = "h6 text-danger";
        }
        $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
    }
}(jQuery)); // End of use strict