// Page Multimedia
$(document).ready(function(){
    // Disable form inputs
    function disableForm(type){
        $('#multimedia-' + type + '-modal :input').attr('disabled', 'disabled');
    }

    // Enable form inputs
    function enableForm(type){
        $('#multimedia-' + type + '-modal :input').removeAttr('disabled');
    }

    function showIndicator(type){
        $('#multimedia-' + type + '-modal .work-indicator').removeClass('d-none');
    }

    function hideIndicator(type){
        $('#multimedia-' + type + '-modal .work-indicator').addClass('d-none');
    }

    // Clear form
    function cleanForm(){

    }

    /**
     * Check if we have any multimedia items
     */
    function isEmpty()
    {
        return ($('#page-multimedia .multimedia-item').length || $('#page-multimedia .album').length);
    }

    function displayEmptyAlert(display)
    {
        if(display) {
            $('.multimedia-empty').removeClass('d-none');
        } else {
            $('.multimedia-empty').addClass('d-none');
        }
    }

    // Sort items
    $( ".items-list" ).sortable({
        tolerance: "pointer",
        update: function( event, ui ) {
            var ids = $(this).sortable('toArray', {attribute : 'data-id'});

            $.getJSON(settings.base_url + '/administrator/multimedia/json/order', {ids: ids}, function(response){

            })
        }
    });

    // Clear content of modal
    $('#multimedia-add-modal').on('show.bs.modal', function (e) {
        $('#multimedia-add-modal .nav-tabs-types a:first').trigger('click');

        var album_id = $('#multimedia-add-modal').attr('data-album') || 0;
        $('#multimedia-add-modal select[name="album"]').val(album_id);

        $('#multimedia-add-modal .alert').addClass('d-none');
        $('#multimedia-add-modal .has-error').removeClass('has-error');

        $('#multimedia-add-modal input[type="text"]').val('');
        $('#multimedia-add-modal input[name="image-filename"]').val('');

        $('#multimedia-add-modal .image-preview').html('').addClass('d-none');
    });

    // Clear content of modal
    $('#multimedia-album-add-modal').on('show.bs.modal', function (e) {
        $('#multimedia-album-add-modal input[type="text"]').val('');
        $('#multimedia-album-add-modal select[name="album"]').val(0);

        var album_id = $('#multimedia-album-add-modal').attr('data-album') || 0;
        $('#multimedia-album-add-modal select[name="parent"]').val(album_id);
    });

    // Chenge the multimedia type
    $('#multimedia-add-modal .nav-tabs-types a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('#multimedia-add-modal input[name="type"]').val($(e.target).attr('href').split('-')[1]);
    });

    // Upload temporary image
    $('#multimedia-add-modal .fileupload').fileupload({
        dataType: 'json',
        done: function (e, data) {
            if(data.result.status === 'ok'){
                $('.image-preview').html('<img src="' + settings.base_url + '/upload/tmp/' + data.result.filename + '" alt="">').removeClass('d-none');
                $('input[name="image-filename"]').val(data.result.filename);
            }else if(data.result.status === 'err'){
                $('.image-preview').html('').addClass('d-none');
                $('.image-upload').addClass('has-error');
                $('.image-upload .alert').removeClass('d-none').text(data.result.errors.image);
                $('input[name="image-filename"]').val('');
            }
            hideIndicator('add');
            enableForm('add');
        },
        add: function(e, data){

            $('.image-upload').removeClass('has-error');
            $('.image-upload .alert').addClass('d-none').text('');

            showIndicator('add');

            data.submit();

            disableForm('add');
        }
    });

    // Add a new multimedia item
    $('#multimedia-add-modal form').submit(function(){
        $('#multimedia-add-modal .alert').addClass('d-none');
        $('#multimedia-add-modal .has-error').removeClass('has-error');

        var current_album_id = $('#multimedia-add-modal').attr('data-album') || 0;
        var selected_album_id = $('#multimedia-add-modal select[name="album"]').val();
        var fields = $('#multimedia-add-modal form').serialize();

        showIndicator('add');

        disableForm('add');

        $.post(settings.base_url + '/administrator/multimedia/json/add', fields, function(response){
            hideIndicator('add');
            enableForm('add');

            if(response.status === 'ok'){
                if(current_album_id == selected_album_id){
                    $('#page-multimedia .items-list').append(response.view);
                    $('html, body').animate({
                        scrollTop: $('#item-' + response.item_id).offset().top
                    }, 2000);
                }else{
                    swal('A new multimedia item has been created successfully.');
                }

                $('#multimedia-add-modal').modal('hide');

                displayEmptyAlert(!isEmpty());

            }else if(response.status === 'err'){
                $('#multimedia-add-modal .alert').removeClass('d-none');
                for(var i in response.errors){
                    $('#multimedia-add-modal [name="' + i + '"]').closest('.form-group').addClass('has-error');
                }
            }
        });
        return false;
    });

    // Add a new multimedia album
    $('#multimedia-album-add-modal form').submit(function(){
        $('#multimedia-album-add-modal .alert').addClass('d-none');
        $('#multimedia-album-add-modal .has-error').removeClass('has-error');

        var current_album_id = $('#multimedia-album-add-modal').attr('data-album') || 0;
        var selected_album_id = $('#multimedia-album-add-modal select[name="parent"]').val();
        var fields = $('#multimedia-album-add-modal form').serialize();

        $.post(settings.base_url + '/administrator/multimedia/json/album-add', fields, function(response){

            if(response.status === 'ok'){
                if(current_album_id == selected_album_id){
                    $('#page-multimedia .albums-list').append(response.view);
                }else{
                    swal('A new album has been created successfully.');
                }

                $('#multimedia-album-add-modal').modal('hide');

                displayEmptyAlert(!isEmpty());
            }else if(response.status === 'err'){
                $('#multimedia-album-add-modal .alert').removeClass('d-none');
                for(var i in response.errors){
                    $('#multimedia-album-add-modal [name="' + i + '"]').closest('.form-group').addClass('has-error');
                }
            }
        });
        return false;
    });

    // Edit multimedia album
    $('#page-multimedia').on('click', '[data-action="album-edit"]', function(){
        var album_id = $(this).attr('data-id');

        $.getJSON(settings.base_url + '/administrator/multimedia/json/album/' + album_id, {}, function(response){
            if(response.status === 'ok'){

                $('#multimedia-album-edit-modal input[name="album_id"]').val(album_id);

                for(var i in response.album){
                    $('#multimedia-album-edit-modal :input[name="' + i + '"]').val(response.album[i]);
                }

                $('#multimedia-album-edit-modal').modal('show');
            }
        });

    });

    // Edit multimedia album
    $('#multimedia-album-edit-modal form').submit(function(){
        $('#multimedia-album-edit-modal .alert').addClass('d-none');
        $('#multimedia-album-edit-modal .has-error').removeClass('has-error');

        var current_album_id = $('#multimedia-album-edit-modal').attr('data-album') || 0;
        var selected_album_id = $('#multimedia-album-edit-modal select[name="parent"]').val();
        var album_id = $('#multimedia-album-edit-modal input[name="album_id"]').val();
        var fields = $('#multimedia-album-edit-modal form').serialize();

        $.post(settings.base_url + '/administrator/multimedia/json/album-edit/' + album_id, fields, function(response){

            if(response.status === 'ok'){
                if(current_album_id == selected_album_id){
                    $('#page-multimedia .album[data-id="' + album_id + '"]').replaceWith(response.view);
                }else{
                    $('#page-multimedia .album[data-id="' + album_id + '"]').fadeOut(200, function(){
                        $(this).remove();
                    });
                }

                $('#multimedia-album-edit-modal').modal('hide');
            }else if(response.status === 'err'){
                $('#multimedia-album-edit-modal .alert').removeClass('d-none');
                for(var i in response.errors){
                    $('#multimedia-album-edit-modal [name="' + i + '"]').closest('.form-group').addClass('has-error');
                }
            }
        });
        return false;
    });

    // Edit multimedia item
    $('#page-multimedia').on('click', '[data-action="item-edit"]', function(){
        var multimedia_id = $(this).attr('data-id');

        $.getJSON(settings.base_url + '/administrator/multimedia/json/multimedia/' + multimedia_id, {}, function(response){
            if(response.status === 'ok'){

                $('#multimedia-edit-modal input[name="multimedia_id"]').val(multimedia_id);

                for(var i in response.multimedia){
                    $('#multimedia-edit-modal :input[name="' + i + '"]').val(response.multimedia[i]);
                }

                $('#multimedia-edit-modal').modal('show');
            }
        });

    });

    // Edit multimedia item
    $('#multimedia-edit-modal form').submit(function(){
        $('#multimedia-edit-modal .alert').addClass('d-none');
        $('#multimedia-edit-modal .has-error').removeClass('has-error');

        var current_album_id = $('#multimedia-edit-modal').attr('data-album') || 0;
        var selected_album_id = $('#multimedia-edit-modal select[name="album"]').val();
        var multimedia_id = $('#multimedia-edit-modal input[name="multimedia_id"]').val();
        var fields = $('#multimedia-edit-modal form').serialize();

        showIndicator('edit');

        disableForm('edit');

        $.post(settings.base_url + '/administrator/multimedia/json/edit/' + multimedia_id, fields, function(response){
            hideIndicator('edit');
            enableForm('edit');

            if(response.status === 'ok'){
                if(current_album_id == selected_album_id){
                    $('#page-multimedia .multimedia-item[data-id="' + multimedia_id + '"]').replaceWith(response.view);
                    $('html, body').animate({
                        scrollTop: $('#item-' + response.item_id).offset().top
                    }, 2000);
                }else{
                    $('#page-multimedia .multimedia-item[data-id="' + multimedia_id + '"]').fadeOut(200, function(){
                        $(this).remove();
                    });
                }

                $('#multimedia-edit-modal').modal('hide');
            }else if(response.status === 'err'){
                $('#multimedia-edit-modal .alert').removeClass('d-none');
                for(var i in response.errors){
                    $('#multimedia-edit-modal [name="' + i + '"]').closest('.form-group').addClass('has-error');
                }
            }
        });
        return false;
    });

    // Remove multimedia
    $('#page-multimedia').on('click', '[data-action="multimedia-remove"]', function(){
        var multimedia_id = $(this).attr('data-id');

        swal({
                title: "",
                text: "Are you sure you want to remove selected item?",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: true
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/multimedia/json/multimedia-remove/' + multimedia_id, function(response){
                    if(response.status === 'ok'){
                        $('#page-multimedia .multimedia-item[data-id="' + multimedia_id + '"]').fadeOut(200, function(){
                            $(this).remove();

                            displayEmptyAlert(!isEmpty());
                        });
                    }
                });
            });

        return false;
    });

    // Remove album
    $('#page-multimedia').on('click', '[data-action="album-remove"]', function(){
        var album_id = $(this).attr('data-id');

        swal({
                title: "",
                text: "Are you sure you want to remove selected album?",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: true
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/multimedia/json/album-remove/' + album_id, function(response){
                    if(response.status === 'ok'){
                        $('#page-multimedia .album[data-id="' + album_id + '"]').fadeOut(200, function(){
                            $(this).remove();

                            displayEmptyAlert(!isEmpty());
                        });
                    }
                });
            });

        return false;
    });
});