$(document).ready(function() {
    $('#delete-news-modal .yes-button').click(function() {
        sDataForm('delete-news-form').submit();
    });

    $('#delete-news-modal .no-button').click(function() {
        $('#delete-news-modal').modal('hide');
    });

    onDataButtonClick('delete-news-button', function() {
        sDataForm('delete-news-form').find('input[name="newsID"]').val($(this).data('var-id'));

        $('#delete-news-modal').modal({
            show: true
        });
    });
});
