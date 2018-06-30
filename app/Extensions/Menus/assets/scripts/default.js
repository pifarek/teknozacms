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