$(document).ready(function() {
    $('#delete-health-and-safety-modal .yes-button').click(function() {
        sDataForm('delete-health-and-safety-form').submit();
    });

    $('#delete-health-and-safety-modal .no-button').click(function() {
        $('#delete-health-and-safety-modal').modal('hide');
    });

    onDataButtonClick('delete-health-and-safety-button', function() {
        sDataForm('delete-health-and-safety-form').find('input[name="healthAndSafetyID"]').val($(this).data('var-id'));

        $('#delete-health-and-safety-modal').modal({
            show: true
        });
    });
});
