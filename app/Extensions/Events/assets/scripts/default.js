// Page Events Edit
(function($){
    $('#page-events-edit .start-time, #page-events-edit .end-time').datetimepicker({
        format: 'd-m-Y H:i'
    });

    // Remove event image
    $('#page-events-edit [data-action="remove-image"]').on('click', function(){
        var image_id = $(this).attr('data-id');
        $.getJSON(settings.base_url + '/administrator/events/json/image-remove/' + image_id, function(response){
            if(response.status === 'ok'){
                $('#page-events-edit .image .inner').html('');
                $('#page-events-edit .image [data-action="remove-image"]').addClass('d-none');
            }
        });
        return false;
    });

    // Upload event image
    $('#page-events-edit .image .input-cover-image').fileupload({
        dataType: 'json',
        done: function (e, data) {
            if(data.result.status === 'ok'){
                $('#page-events-edit .image .inner').html('<img src="' + settings.base_url + '/upload/events/' + data.result.filename + '" alt="">');
                //$('.cover-image .inner').addClass('uploaded');
                //$('.cover-image .remove-cover').attr('data-id', data.result.image_id);
                $('#page-events-edit .image [data-action="remove-image"]').removeClass('d-none');
            }
        }
    });
})(jQuery);

// Page Events
(function($){
    // Remove event
    $('#page-events [data-action="event-remove"]').click(function() {
        var event_id = $(this).attr('data-id');

        swal({
                title: "",
                text: "Are you sure you want to remove selected event?",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/events/json/remove/' + event_id, function(response){
                    if(response.status === 'ok'){
                        window.location.href = settings.base_url + '/administrator/events';
                    }
                });
            });

        return false;
    });
})(jQuery);