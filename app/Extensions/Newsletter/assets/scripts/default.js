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