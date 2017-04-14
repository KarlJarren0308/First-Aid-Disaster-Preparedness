$(document).ready(function() {
    $('#add-news-button').click(function() {
        $('#add-news-modal').modal('show');
    });

    $('#add-news-modal').on('shown.bs.modal', function () {
        $(this).find('.modal-focus').focus();
    });
});
