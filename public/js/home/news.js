$(document).ready(function() {
    $('#add-news-modal').on('shown.bs.modal', function () {
        $(this).find('.modal-focus').focus();
    });
});
