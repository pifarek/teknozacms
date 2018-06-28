// Page Add Slide
(function($){
    // Datetimepicker
    $('#page-sliders-slide-add [name="start_date"], #page-sliders-slide-add [name="end_date"]').datetimepicker({
        format: 'd-m-Y H:i:s'
    });

    // Block element
    $('#page-sliders-slide-add input[type="file"]').change(function(){
        var name = $(this).attr('name');
        $('input[type="file"]').not('[name="' + name + '"]').attr('disabled', true);
        $('input[type="file"]').not('[name="' + name + '"]').parent().addClass('disabled');
    });

    // Slide URL
    $('#page-sliders-slide-add input[name="url"]').keyup(function(){
        if($(this).val()) {
            $('#page-sliders-slide-add .slide-url').removeClass('d-none');
        } else {
            $('#page-sliders-slide-add .slide-url').addClass('d-none');
            $('#page-sliders-slide-add .slide-url [type="text"]').val('');
        }
    });

    $('#page-sliders-slide-add input[name="url"]').trigger('keyup');

    // available date
    $('#page-sliders-slide-add select[name="available_date"]').change(function(){
        var value = $(this).val();
        if(value == 1){
            $('#page-sliders-slide-add .available-date').removeClass('d-none');
        }else{
            $('#page-sliders-slide-add .available-date').addClass('d-none');
        }
    });
    $('#page-sliders-slide-add select[name="available_date"]').trigger('change');

    // Upload tmp image
    $('#page-sliders-slide-add input[name="tmp"]').fileupload({
        dataType: 'json',
        progressInterval: 50,
        done: function (e, data) {
            $('#page-sliders-slide-add :input').attr('disabled', false);
            $('#page-sliders-slide-add .progress-bar').width('0%');
            if(data.result.status === 'ok'){
                $('#page-sliders-slide-add .slide-preview img').attr('src', settings.base_url + '/upload/tmp/' + data.result.filename);
                $('#page-sliders-slide-add input[name="image"]').val(data.result.filename);
            }
        },
        add: function (e, data){
            data.submit();
            $('#page-sliders-slide-add :input').attr('disabled', true);
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#page-sliders-slide-add .progress-bar').width(progress + '%');
        }
    });
})(jQuery);

// Page Edit Slide
(function($){
    // Datetimepicker
    $('#page-sliders-slide-edit [name="start_date"], #page-sliders-slide-edit [name="end_date"]').datetimepicker({
        format: 'd-m-Y H:i:s'
    });

    // Slide URL
    $('#page-sliders-slide-edit input[name="url"]').keyup(function(){
        if($(this).val()) {
            $('#page-sliders-slide-edit .slide-url').removeClass('d-none');
        } else {
            $('#page-sliders-slide-edit .slide-url').addClass('d-none');
            $('#page-sliders-slide-edit .slide-url [type="text"]').val('');
        }
    });

    $('#page-sliders-slide-edit input[name="url"]').trigger('keyup');

    // available date
    $('#page-sliders-slide-edit select[name="available_date"]').change(function(){
        var value = $(this).val();
        if(value == 1){
            $('#page-sliders-slide-edit .available-date').removeClass('d-none');
        }else{
            $('#page-sliders-slide-edit .available-date').addClass('d-none');
        }
    });
    $('#page-sliders-slide-edit select[name="available_date"]').trigger('change');

    // Upload slide image
    $('#page-sliders-slide-edit input[name="image"]').fileupload({
        dataType: 'json',
        progressInterval: 50,
        done: function (e, data) {
            $('#page-sliders-slide-edit :input').attr('disabled', false);
            $('#page-sliders-slide-edit .progress-bar').width('0%');
            if(data.result.status === 'ok'){
                $('#page-sliders-slide-edit .slide-preview img').attr('src', settings.base_url + '/upload/slides/' + data.result.filename);
            }
        },
        add: function (e, data){
            data.submit();
            $('#page-sliders-slide-edit :input').attr('disabled', true);
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#page-sliders-slide-edit .progress-bar').width(progress + '%');
        }
    });
})(jQuery);

// Page Sliders
(function($){
    // Remove slider
    $('#page-sliders [data-action="slider-remove"]').click(function(){
        var slider_id = $(this).attr('data-id');

        swal({
                title: "",
                text: "Are you sure you want to remove selected slider?",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/sliders/json/remove/' + slider_id, function(response){
                    if(response.status === 'ok'){
                        window.location.reload();
                    }
                });
            });

        return false;
    });

    // Remove slide
    $('#page-sliders [data-action="slide-remove"]').click(function(){
        var slide_id = $(this).attr('data-id');

        swal({
                title: "",
                text: "Are you sure you want to remove selected slide?",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/sliders/json/slide-remove/' + slide_id, function(response){
                    if(response.status === 'ok'){
                        window.location.reload();
                    }
                });
            });

        return false;
    });

    // Move item up
    $('#page-sliders [data-action="move-up"]').click(function(){
        var slide_id = $(this).attr('data-id');
        $.getJSON(settings.base_url + '/administrator/sliders/json/slide-move/up/' + slide_id, function(response){
            if(response.status === 'ok'){
                window.location.reload();
            }
        });
        return false;
    });

    // Move item down
    $('#page-sliders [data-action="move-down"]').click(function(){
        var organization_id = $(this).attr('data-id');
        $.getJSON(settings.base_url + '/administrator/sliders/json/slide-move/down/' + organization_id, function(response){
            if(response.status === 'ok'){
                window.location.reload();
            }
        });
        return false;
    });
})(jQuery);