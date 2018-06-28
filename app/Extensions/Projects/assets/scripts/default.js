// Page Projects
(function($){
    // Remove project
    $('#page-projects [data-action="project-remove"]').click(function(){
        var project_id = $(this).attr('data-id');

        swal({
                title: "",
                text: "Are you sure you want to remove selected project?",
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
                text: "Are you sure you want to remove image?",
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
                text: "'Are you sure you want to remove selected tag?",
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