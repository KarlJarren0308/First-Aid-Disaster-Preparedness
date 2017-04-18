$(document).ready(function() {
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
