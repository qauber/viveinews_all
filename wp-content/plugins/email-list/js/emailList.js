var $ = jQuery;
jQuery(document).ready(function(){
	// jQuery("#afc_button").click(function(){
	// 	jQuery("#afc_form").submit();
	// });

	$('#email_list_widget').on('submit', function(e){
        e.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: ajax_object.ajaxurl,
            timeout: 3600000,
            data: {
                data_form: formData,
                dataType: 'json',
                action: "email_list_add_subscriber"
            },

            beforeSend: function(){
                $('#email_list_ajax-loader').show();
            },
            success: function( response ) {
                var resp = $.parseJSON(response);
                $('#email_list_ajax-loader').hide();

                console.log(resp);



            },


        }).fail(function ( data ) {
//
        });
	});


});