// Page Contacts
$(document).ready(function(){
    // Remove contact
    $('#page-contacts [data-action="contact-remove"]').click(function() {
        var contact_id = $(this).attr('data-id');

        swal({
                title: "",
                text: contactTranslations.js_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/contacts/json/remove/' + contact_id, function(response) {
                    if(response.status === 'ok') {
                        window.location.href = settings.base_url + '/administrator/contacts';
                    }
                });
            });

        return false;
    });
});
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
                text: EventsTranslations.js_remove,
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
// Page Menus Items Edit
$(document).ready(function(){
    // Display shortcut button
    $('#page-menus-item-edit select[name="type"]').change(function() {
        var type = $(this).val();

        $('#page-menus-item-edit .shortcut-button').html('');

        $.getJSON(settings.base_url + '/administrator/menus/json/page-shortcut/' + type, function(response) {
            if(response.status === 'ok') {
                var button = $('<a>').html(response.shortcut.name).addClass('btn btn-success').css({color: '#fff'}).attr('href', response.shortcut.url).attr('target', '_blank');
                $('#page-menus-item-edit .shortcut-button').html(button);
            }
        });
        return false;
    });
    $('#page-menus-item-edit select[name="type"]').trigger('change');

    // Upload cover image
    $('#page-menus-item-edit .input-intro-image').fileupload({
        dataType: 'json',
        done: function (e, data) {
            if(data.result.status === 'ok'){
                $('#page-menus-item-edit .intro-image .inner').html('<img src="' + settings.base_url + '/upload/menus/' + data.result.filename + '" alt="">');
                $('#page-menus-item-edit .upload-intro-image').addClass('d-none');
                $('#page-menus-item-edit .upload-intro-video').addClass('d-none');
                $('#page-menus-item-edit .intro-image').removeClass('d-none');
            }
        }
    });

    // Remove intro image
    $('#page-menus-item-edit .remove-intro-image').click(function(){
        var item_id = $(this).attr('data-id');
        $.getJSON(settings.base_url + '/administrator/menus/json/item-remove-intro-image/' + item_id, function(response){
            if(response.status === 'ok'){
                $('#page-menus-item-edit .intro-image').addClass('d-none');
                $('#page-menus-item-edit .intro-image .inner').html('');
                $('#page-menus-item-edit .upload-intro-image').removeClass('d-none');
                $('#page-menus-item-edit .upload-intro-video').removeClass('d-none');
            }
        });
        return false;
    });
});

// Page Menus Items
$(document).ready(function(){
    // Move item up
    $('#page-menus-items .move-up').click(function(){
        var item_id = $(this).attr('data-id');
        var menu_id = $(this).attr('data-menu');
        var tr = $(this).closest('tr');
        $.getJSON(settings.base_url + '/administrator/menus/items/' + menu_id + '/json/move/up/' + item_id, function(response){
            if(response.status === 'ok'){
                window.location.reload();
            }
        });
        return false;
    });

    // Move item down
    $('#page-menus-items .move-down').click(function(){
        var item_id = $(this).attr('data-id');
        var menu_id = $(this).attr('data-menu');
        var tr = $(this).closest('tr');
        $.getJSON(settings.base_url + '/administrator/menus/items/' + menu_id + '/json/move/down/' + item_id, function(response){
            if(response.status === 'ok'){
                window.location.reload();
            }
        });
        return false;
    });

    // Remove selected item
    $('#page-menus-items .remove-menu-item').click(function(){
        var item_id = $(this).attr('data-id');
        var menu_id = $(this).attr('data-menu');

        swal({
                title: "",
                text: MenusTranslations.js_items_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/menus/items/' + menu_id + '/json/remove/' + item_id, function(response){
                    if(response.status === 'ok'){
                        window.location.reload();
                    }
                });
            });

        return false;
    });
});

// Page Menus
$(document).ready(function() {
    // Remove menu
    $('#page-menus .remove-menu').click(function() {
        var menu_id = $(this).attr('data-id');

        swal({
                title: "",
                text: MenusTranslations.js_menus_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/menus/json/remove/' + menu_id, function(response) {
                    if(response.status === 'ok') {
                        window.location.href = settings.base_url + '/administrator/menus';
                    }
                });
            });

        return false;
    });
});
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
        $('#multimedia-add-modal textarea').val('');
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
                    swal(MultimediaTranslations.js_added);
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
                    swal(MultimediaTranslations.js_album_added);
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
                text: MultimediaTranslations.js_remove,
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
                text: MultimediaTranslations.js_album_remove,
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
// Page News Categories
(function($){
    // Remove news categories
    $('#page-news-categories [data-action="category-remove"]').click(function() {
        var category_id = $(this).attr('data-id');
        swal({
                title: "",
                text: NewsTranslations.js_categories_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/news/categories/json/remove/' + category_id, function (response) {
                    if (response.status === 'ok') {
                        window.location.href = settings.base_url + '/administrator/news/categories';
                    }
                });
            });

        return false;
    });
})(jQuery);

// Page News Edit
(function($){
    $('#page-news-edit .news-date').datetimepicker({
        format: 'd-m-Y H:i:s'
    });
    // upload news image
    $('#page-news-edit .input-news-image').fileupload({
        dataType: 'json',
        progressInterval: 10,
        done: function (e, data) {
            $('#news-cover-progressbar').addClass('d-none');
             if(data.result.status === 'ok') {
                 $('#page-news-edit .news-image .image').html('<img src="' + settings.base_url + '/upload/news/s/' + data.result.filename + '" alt="">');
                 $('#page-news-edit .news-image .image').removeClass('d-none');
                 $('#page-news-edit .news-image .remove-image').removeClass('d-none');
                 $('#page-news-edit .news-image .upload-news-image').addClass('d-none');
             }
        },
        add: function (e, data) {
            data.submit();
            $('#news-cover-progressbar div').width(0);
            $('#news-cover-progressbar').removeClass('d-none');
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#news-cover-progressbar div').text(progress + '%').width(progress + '%');
            console.log(progress);
        }
     });
     // remove news image
     $('#page-news-edit .remove-image').click(function(){
         var news_id = $(this).attr('data-id');
         $.getJSON(settings.base_url + '/administrator/news/json/image-remove/' + news_id, function(response){
            if(response.status === 'ok'){
                $('#page-news-edit .news-image .remove-image').addClass('d-none');
                $('#page-news-edit .news-image .upload-news-image').removeClass('d-none');
                $('#page-news-edit .news-image .image').addClass('d-none');
            }
        });
        return false;
     });
})(jQuery);

// Page News List
(function($){
    // Remove news
    $('#page-news [data-action="news-remove"]').click(function(){
        var news_id = $(this).attr('data-id');
        swal({
                title: '',
                text: NewsTranslations.js_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function(){
                $.getJSON(settings.base_url + '/administrator/news/json/remove/' + news_id, function(response){
                    if(response.status === 'ok'){
                        window.location.href = settings.base_url + '/administrator/news';
                    }
                });
            });
    });
})(jQuery);
// Page Newsletter
(function($){
    // Remove newsletter user
    $('#page-newsletter [data-action="newsletter-remove"]').click(function(){
        var newsletter_id = $(this).attr('data-id');

        swal({
                title: "",
                text: NewsletterTranslations.js_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/newsletter/json/remove/' + newsletter_id, function(response){
                    if(response.status === 'ok'){
                        window.location.href = settings.base_url + '/administrator/newsletter';
                    }
                });
            });

        return false;
    });
})(jQuery);

// Page Newsletter Groups
(function($){
    // Remove group
    $('#page-newsletter-groups [data-action="group-remove"]').click(function(){
        var group_id = $(this).attr('data-id');

        swal({
                title: "",
                text: NewsletterTranslations.js_group_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: false
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/newsletter/json/group-remove/' + group_id, function(response){
                    if(response.status === 'ok'){
                        window.location.href = settings.base_url + '/administrator/newsletter/groups';
                    }
                });
            });

        return false;
    });
})(jQuery);

// Page Newsletter Send Greetings
(function($){
    // change type
    $('#page-newsletter-send-greetings select[name="type"]').change(function(){
        var type = $(this).val();

        if(type === 'users'){
            $('#page-newsletter-send-greetings .groups-list').slideUp(100);
            $('#page-newsletter-send-greetings .users-list').slideDown(100);
        }else if(type === 'groups'){
            $('#page-newsletter-send-greetings .groups-list').slideDown(100);
            $('#page-newsletter-send-greetings .users-list').slideUp(100);
        }
    });

    $('#page-newsletter-send-greetings select[name="type"]').trigger('change');
})(jQuery);

// Page Newsletter Send Empty
(function($){
    $("#newsletter-sortable1, #newsletter-sortable2, #newsletter-sortable3").sortable({
        connectWith: "ul.elements",
        stop: function(event, ui){
            $('#newsletter_elements_count').html($('#newsletter-sortable1 li').length);
            $('#news_elements_count').html($('#newsletter-sortable2 li:not(.hidden)').length);
            $('#events_elements_count').html($('#newsletter-sortable3 li:not(.hidden)').length);
        },
        change: function(event, ui){
            $('#page-newsletter-send-content .drag-info').remove();
        }
    }).disableSelection();


    // Search elements
    $('#page-newsletter-send-content input[name="search"]').val('');
    $('#page-newsletter-send-content input[name="search"]').keyup(function(){
        var string = $(this).val();
        var pattern = new RegExp(string, 'i');
        $('#newsletter-sortable2 li, #newsletter-sortable3 li').each(function(){
            var title = $(this).children('h4').text();
            if(!pattern.test(title)){
                $(this).addClass('hidden');
            }else{
                $(this).removeClass('hidden');
            }
        });

        $('#news_elements_count').html($('#newsletter-sortable2 li:not(.hidden)').length);
        $('#events_elements_count').html($('#newsletter-sortable3 li:not(.hidden)').length);

        return false;
    });

    // Submit elements
    $('#page-newsletter-send-content form.step1').submit(function(){
        var elements = [];
        // Get selected elements
        $('#newsletter-sortable1 li').each(function(){
            var type = $(this).attr('data-type');
            var id = $(this).attr('data-id');
            elements.push({
                'type' : type,
                'id' : id
            });
        });
        if(elements.length < 1){
            bootbox.alert('Sorry, you need to select at least one element.');
        }else{
            $.getJSON(settings.base_url + '/administrator/newsletter/send/json/content-elements', {elements: elements}, function(response){
                if(response.status === 'ok'){
                    window.location.href = settings.base_url + '/administrator/newsletter/send/content';
                }
            });
        }

        return false;
    });

    // change type
    $('#page-newsletter-send-content select[name="type"]').change(function(){
        var type = $(this).val();

        if(type === 'users'){
            $('#page-newsletter-send-content .groups-list').slideUp(100);
            $('#page-newsletter-send-content .users-list').slideDown(100);
        }else if(type === 'groups'){
            $('#page-newsletter-send-content .groups-list').slideDown(100);
            $('#page-newsletter-send-content .users-list').slideUp(100);
        }
    });

    $('#page-newsletter-send-content select[name="type"]').trigger('change');
})(jQuery);

// Page Newsletter Send Empty
(function($){
    // change type
    $('#page-newsletter-send-empty select[name="type"]').change(function(){
        var type = $(this).val();

        if(type === 'users'){
            $('#page-newsletter-send-empty .groups-list').slideUp(100);
            $('#page-newsletter-send-empty .users-list').slideDown(100);
        }else if(type === 'groups'){
            $('#page-newsletter-send-empty .groups-list').slideDown(100);
            $('#page-newsletter-send-empty .users-list').slideUp(100);
        }
    });

    $('#page-newsletter-send-empty select[name="type"]').trigger('change');
})(jQuery);

// Page Newsletter Send
(function($){
    // change type
    $('#page-newsletter-send select[name="type"]').change(function(){
        var type = $(this).val();

        $('#page-newsletter-send .recipients').addClass('hidden');
        if(type === 'users'){
            $('#page-newsletter-send .users-list').removeClass('hidden');
        }else if(type === 'groups'){
            $('#page-newsletter-send .groups-list').removeClass('hidden');
        }
    });

    $('#page-newsletter-send select[name="type"]').trigger('change');

    // Select template
    $('#page-newsletter-send select[name="template"]').change(function(){
        var template_id = $(this).val();
        if(template_id > 0){
            $('#page-newsletter-send .additional').html('');
            $.getJSON(settings.base_url + '/administrator/newsletter/json/template/' + template_id, function(response){
                if(response.status === 'ok'){
                    tinyMCE.get('newsletter-message').setContent(response.content);

                    $('#page-newsletter-send .additional').html(response.html);
                }
            });
        }
    });

    $('#page-newsletter-send select[name="template"]').trigger('change');
})(jQuery);
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
// Page Projects
(function($){
    // Remove project
    $('#page-projects [data-action="project-remove"]').click(function(){
        var project_id = $(this).attr('data-id');

        swal({
                title: "",
                text: ProjectsTranslations.js_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: true
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/projects/json/remove/' + project_id, function(response){
                    if(response.status === 'ok'){
                        window.location.href = settings.base_url + '/administrator/projects';
                    }
                });
            });

    });
})(jQuery);

// Page Project Edit
(function($){
    // Remove project cover
    $('#page-project-edit [data-action="image-remove"]').click(function(){
        var image_id = $(this).attr('data-id');
        $.getJSON(settings.base_url + '/administrator/projects/json/cover-remove/' + image_id, function(response){
            if(response.status === 'ok'){
                $('#page-project-edit .image .inner').html('');
                $('#page-project-edit [data-action="image-remove"]').addClass('d-none');
            }
        });
        return false;
    });

    // Upload project cover
    $('#page-project-edit .image .input-cover-image').fileupload({
        dataType: 'json',
        done: function (e, data) {
            if(data.result.status === 'ok'){
                $('#page-project-edit .image .inner').html('<img src="' + settings.base_url + '/upload/projects/covers/' + data.result.filename + '" alt="">');
                $('#page-project-edit .image [data-action="image-remove"]').removeClass('d-none');
            }
        }
    });

    // Upload project image
    $('#page-project-edit .input-image').fileupload({
        dataType: 'json',
        done: function (e, data) {
            if(data.result.status === 'ok'){
                $('#page-project-edit .project-images').append('<div class="project-image" data-id="' + data.result.image_id + '"><a href="' + settings.base_url + '/upload/projects/' + data.result.filename + '" target="_blank" class="preview"><img src="' + settings.base_url + '/upload/projects/' + data.result.filename + '" alt=""></a><a href="#" class="remove"><i class="fas fa-times-circle"></i></a></div>');
                $('#page-project-edit .project-images').removeClass('d-none');
            }
        }
    });

    // Remove project image
    $(document).on('click', '#page-project-edit .project-image .remove', function(){
        var image_id = $(this).parent().attr('data-id');

        swal({
                title: "",
                text: ProjectsTranslations.js_image_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: true
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/projects/json/image-remove/' + image_id, function(response){
                    if(response.status === 'ok'){
                        $('#page-project-edit .project-image[data-id="' + image_id + '"]').remove();
                    }
                });
            });

        return false;
    });
})(jQuery);

// Page Projects Tags
(function($){
    // Remove project tag
    $('#page-projects-tags [data-action="tag-remove"]').click(function(){
        var tag_id = $(this).attr('data-id');

        swal({
                title: "",
                text: ProjectsTranslations.js_tag_remove,
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: true
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/projects/tags/json/remove/' + tag_id, function(response){
                    if(response.status === 'ok'){
                        window.location.href = settings.base_url + '/administrator/projects/tags';
                    }
                });
            });

        return false;
    });
})(jQuery);
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
                text: SlidersTranslations.js_slider_remove,
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
                text: SlidersTranslations.js_slide_remove,
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