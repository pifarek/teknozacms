// Page News Categories
(function($){
    // Remove news categories
    $('#page-news-categories [data-action="category-remove"]').click(function() {
        var category_id = $(this).attr('data-id');
        swal({
                title: "",
                text: "Are you sure you want to remove selected category?",
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
                text: "Are you sure you want to remove selected news?",
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