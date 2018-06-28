// Page Contacts
$(document).ready(function(){
    // Remove contact
    $('#page-contacts [data-action="contact-remove"]').click(function() {
        var contact_id = $(this).attr('data-id');

        swal({
                title: "",
                text: "Are you sure you want to remove selected contact?",
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