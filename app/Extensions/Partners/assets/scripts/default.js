// Page Partners
(function($){
    // Move item up
    $('#page-partners [data-action="move-up"]').click(function(){
        var partner_id = $(this).attr('data-id');
        var tr = $(this).closest('tr');
        $.getJSON(settings.base_url + '/administrator/partners/json/move/up/' + partner_id, function(response){
            if(response.status === 'ok'){
                window.location.reload();
            }
        });
        return false;
    });

    // Move item down
    $('#page-partners [data-action="move-down"]').click(function(){
        var partner_id = $(this).attr('data-id');
        var tr = $(this).closest('tr');
        $.getJSON(settings.base_url + '/administrator/partners/json/move/down/' + partner_id, function(response){
            if(response.status === 'ok'){
                window.location.reload();
            }
        });
        return false;
    });

    // Remove partner
    $('#page-partners [data-action="partner-remove"]').click(function(){
        var partner_id = $(this).attr('data-id');

        swal({
                title: "",
                text: PartnersTranslations.js_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/partners/json/remove/' + partner_id, function(response){
                    if(response.status === 'ok'){
                        window.location.href = settings.base_url + '/administrator/partners';
                    }
                });
            });
    });
})(jQuery);

// Page Partner Edit
(function($){
    // Upload partner image
    $('#page-partner-edit .partner-image').fileupload({
        dataType: 'json',
        done: function (e, data) {
            if(data.result.status === 'ok'){
                $('#page-partner-edit .partner-image-preview').html('<img src="' + settings.base_url + '/upload/partners/' + data.result.filename + '" alt="">').removeClass('d-none');
                $('#page-partner-edit .upload-partner-image').addClass('d-none');
                $('#page-partner-edit .remove-partner-image').removeClass('d-none');
            }
        }
    });

    // Remove partner image
    $(document).on('click', '#page-partner-edit .remove-partner-image', function(){
        var image_id = $(this).attr('data-id');

        swal({
                title: "",
                text: "Are you sure you want to remove image?",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: true
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/partners/json/image-remove/' + image_id, function(response){
                    if(response.status === 'ok'){
                        $('#page-partner-edit .partner-image-preview').html('').addClass('d-none');
                        $('#page-partner-edit .upload-partner-image').removeClass('d-none');
                        $('#page-partner-edit .remove-partner-image').addClass('d-none');
                    }
                });
            });


        return false;
    });
})(jQuery);