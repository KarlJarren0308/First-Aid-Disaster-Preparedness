$(document).ready(function() {
    $('#add-question-button').click(function() {
        $('#questionnairre').append('<div class="panel shadow"><div class="panel-body"><div class="form-group"><label for="">Question:</label><input type="text" name="questions[]" class="form-control"></div></div></div>');

        $('#questionnairre').scrollTop(9999);
    });
});
