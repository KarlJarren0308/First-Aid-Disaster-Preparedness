$(document).ready(function() {
    $('#unban-users-modal .yes-button').click(function() {
        sDataForm('unban-users-form').submit();
    });

    $('#unban-users-modal .no-button').click(function() {
        $('#unban-users-modal').modal('hide');
    });

    onDataButtonClick('unban-users-button', function() {
        sDataForm('unban-users-form').find('input[name="accountID"]').val($(this).data('var-id'));

        $('#unban-users-modal').modal({
            show: true
        });
    });

    $('#ban-users-modal .yes-button').click(function() {
        sDataForm('ban-users-form').submit();
    });

    $('#ban-users-modal .no-button').click(function() {
        $('#ban-users-modal').modal('hide');
    });

    onDataButtonClick('ban-users-button', function() {
        sDataForm('ban-users-form').find('input[name="accountID"]').val($(this).data('var-id'));

        $('#ban-users-modal').modal({
            show: true
        });
    });
});
