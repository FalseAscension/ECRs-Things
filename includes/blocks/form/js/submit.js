function formToJSON(form) {
    var result = {};
    jQuery.each(form.serializeArray(), function(){
        result[this.name] = this.value;
    });

    return result;
}

function validateEmail(email) 
{
  var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
  return re.test(email);
}

function validateFormData(data) {
    var errors = [];
    var numeric = /^[0-9]+$/i;

    if( data['name'] === "" || data['email'] === "" ) errors.push("Please fill out all required fields.");
    if( data['email'] !== "" && !validateEmail(data['email'])) errors.push("Please enter a valid email address");

    if( !('gdpr-consent' in data) ) errors.push("You must consent to receiving communications from us.");

    if(errors.length === 0) return true;
    else return errors;
}

jQuery(document).ready(function($) {
    $('.ecr-form').each(function(){
        var $wrap = $(this);
        var $form = $(this).find('form');
        var $btn = $form.find('input[type=submit]');

        $form.on('submit', function(e) {
            e.preventDefault();

            $form.addClass('loading');
            $btn.addClass('btn--loading');
            $(this).find('.notice ul').empty();

            var data = formToJSON($form);
            console.log(data);
            
            var valid = validateFormData(data);
            if(valid !== true) {
                $(this).find('.notice').removeClass('is-hidden');
                $.each(valid, function(key, value){
                    $(this).find('.notice ul').append($('<li>').append(value));
                });
                return;
            }

            $.ajax({
                url:ajax_url,
                type: 'POST',
                data: {
                    action: 'ecr_signup_form',
                    data: data
                },
                success: function(response){
                    if(response['success']) {
                        $form.find('.form-wrap').addClass('grayed-out');
                        $.each($form.find('input'), function(){
                            this.disabled = true;
                        }); 
                        $wrap.append($('<h2>').addClass('success').append("Success!"));
                    } else {
                        $(this).find('.notice').removeClass('is-hidden');
                        $.each(response['data']['errors'], function(key, value){
                            $(this).find('.notice ul').append($('<li>').append(value));
                        });
                    }
                },
                error: function(response){
                    console.error(response);
                    $(this).find('.notice').removeClass('is-hidden');
                    $(this).find('.notice ul').append($('<li>').append("Sorry, something went wrong. Please try again or contact us."));
                }
            });
        });

    });
});
