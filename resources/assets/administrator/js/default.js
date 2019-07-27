// Core - these two are required :-)
import tinymce from 'tinymce/tinymce'
import 'tinymce/themes/modern/theme'

// Plugins
import 'tinymce/plugins/paste/plugin'
import 'tinymce/plugins/link/plugin'
import 'tinymce/plugins/autoresize/plugin'

// Make Morris working
let makeMorris = require('morris-js-module')
let Morris = makeMorris(jQuery);

// Set the default datetimepicker language
jQuery.datetimepicker.setLocale(settings.language);

// Tinymce
tinymce.init({
    mode: "textareas",
    theme : "modern",
    toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | link image mybutton | fontsizeselect | fontselect ',
    selector: "textarea.tinymce",
    plugins: "link paste autoresize",
    language: settings.language,
    relative_urls: false,
});

/**
 * Administrator Index
 */
(function($){
    // Charts - Last Day
    if($('#chart-last-day').length){
        new Morris.Line({
            element: 'chart-last-day',
            data: jsonLastDay,
            xkey: 'hour',
            ykeys: ['visitors'],
            labels: ['visitors'],
            hideHover: 'auto',
            resize: true
        });
    }

    // Charts - Last Month
    if($('#chart-last-month').length){
        new Morris.Line({
            element: 'chart-last-month',
            data: jsonLastMonth,
            xkey: 'day',
            ykeys: ['visitors'],
            labels: ['visitors'],
            hideHover: 'auto',
            resize: true
        });
    }
})(jQuery);

// Page Settings Users
(function($){
    // Remove selected user
    $('#page-settings-users-list [data-action="user-remove"]').click(function(){
        var user_id = $(this).attr('data-id');

        swal({
                title: "",
                text: "Are you sure you want to remove selected user?",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: true
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/settings/users/json/user-remove/' + user_id, function(response){
                    if(response.status === 'ok'){
                        window.location.href = settings.base_url + '/administrator/settings/users/list';
                    }
                });
            });

        return false;
    });
})(jQuery);

// Page Settings Locales
(function($){
    // Remove selected locale
    $('#page-settings-locales-list [data-action="locale-remove"]').click(function() {
        var locale_id = $(this).attr('data-id');

        swal({
                title: "",
                text: "Are you sure you want to remove selected locale?",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: true
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/settings/locales/json/locale-remove/' + locale_id, function(response) {
                    if(response.status === 'ok') {
                        window.location.href = settings.base_url + '/administrator/settings/locales/list';
                    }
                });
            });

        return false;
    });
})(jQuery);

// Page Settings Translations
(function($){
    // Read file to edit
    $('#page-settings-translations .select-file').change(function() {
        var file = btoa($(this).val());

        $.getJSON(settings.base_url + '/administrator/settings/json/translation-edit/' + file, function(response)
        {
            if(response.status === 'ok')
            {
                $('#translation-editor').html(response.html);
                //$('#translation-editor .nav-tabs').tab();
                //$('.modal-body .nav').tab();
            }
        });
    });

    $('#page-settings-translations .select-file').trigger('change');

    // Translate value
    $('#page-settings-translations').on('keyup', 'input.translation-value', function()
    {
        var value = $(this).val().replace(/'/g, "\\'");
        var key = $(this).attr('data-key');

        var content = $('#translate-file').val();

        var pattern = new RegExp("'" + key + "'[ ]=>[ ]'.*'", 'gi');
        if(content.search(pattern) > 0) {
            var content = content.replace(pattern, "'" + key + "' => '" + value + "'");
        } else {
            alert('Sorry, we couldn\'t find selected index. Please refresh this page.');
        }

        $('#translate-file').val(content);
    });
})(jQuery);

// Page Profile
(function($){

    // Upload user avatar
    $('#page-profile [name="avatar"]').fileupload({
        dataType: 'json',
        done: function (e, data) {
            if(data.result.status === 'ok'){
                $('#page-profile .form-group .user-avatar img').attr('src', settings.base_url + '/upload/users/' + data.result.filename);
                $('#page-profile .form-group .user-avatar').removeClass('d-none');
                $('#page-profile [data-action="avatar-remove"]').removeClass('d-none');
            }
        }
    });

    // Remove user avatar
    $('#page-profile [data-action="avatar-remove"]').click(function(){

        swal({
                title: "",
                text: "Are you sure you want to remove image?",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, remove",
                closeOnConfirm: true
            },
            function () {
                $.getJSON(settings.base_url + '/administrator/profile/json/remove-avatar', function(response){
                    if(response.status === 'ok'){
                        $('#page-profile .form-group .user-avatar').addClass('d-none');
                        $('#page-profile [data-action="avatar-remove"]').addClass('d-none');
                    }
                });
            });

        return false;
    });
})(jQuery);

// Common
(function($){
    // Toggle sidebar
    $('[data-fullscreen]').click(function() {
        if($('body').hasClass('fullscreen')) {
            $('body').removeClass('fullscreen');
            $.getJSON(settings.base_url + '/administrator/json/fullscreen');
        } else {
            $('body').addClass('fullscreen');
            $.getJSON(settings.base_url + '/administrator/json/fullscreen', {fullscreen: true});
        }
        $(this).tooltip('hide');
        return false;
    });

    // Multiple Languages
    $('.languages-available input[type="checkbox"]').change(function(){
        var selected_locales = [];

        // Get selected locales
        $('.languages-available input[type="checkbox"]:checked').each(function(){
            selected_locales.push($(this).val());
        });
        // Show tabs if at least one locale is selected
        if(selected_locales.length > 0){
            $('.languages-selector .nav-tabs').removeClass('d-none');
            $('.languages-selector .tab-content').removeClass('d-none');

            $('.languages-selector .nav-tabs li').addClass('d-none');
            $('.languages-selector .tab-content .tab-pane').addClass('d-none');

            for(var i in selected_locales) {
                $('.languages-selector .nav-tabs li[data-locale="' + selected_locales[i] + '"]').removeClass('d-none');
                $('.languages-selector .tab-content .tab-pane[data-locale="' + selected_locales[i] + '"]').removeClass('d-none');
            }

            // Active first visible locale
            $('.languages-selector .nav-tabs').each(function(){
               $(this).find('li:not(.d-none):first a').trigger('click');
            });

        } else {
            $('.languages-selector .nav-tabs').addClass('d-none');
            $('.languages-selector .tab-content').addClass('d-none');
        }
    });

    $('.languages-available input[type="checkbox"]:checked').each(function(){
        $(this).trigger('change');
    });

    // Active all tabs
    $('.nav-tabs').not('.not-active').each(function(){
        $(this).children('li:not(.d-none):first').children('a:not(.active)').trigger('click');
    });

    // Enable tooltips
    $('[data-toggle="tooltip"]').tooltip();
})(jQuery);
