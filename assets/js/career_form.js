/*==============================================================*/
// Complete Dentistry Career Form JS
/*==============================================================*/
(function ($) {
    "use strict"; // Start of use strict
    $("#careerForm").validator().on("submit", function (event) {
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
        var form = $("#careerForm")[0];
        var form_data = new FormData(form);

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
        $("#careerForm")[0].reset();
        submitMSG(true, "Your submission has been received. We will be in touch with you shortly!")
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