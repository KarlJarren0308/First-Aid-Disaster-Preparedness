function ajaxError(xhr, textStatus, errorThrown) {
    console.log(xhr.responseText);
}

$(document).ready(function() {
    $('.tabs > li > .tab').click(function() {
        $(this).parent().parent().find('li').removeClass('active');
        $(this).parent().addClass('active');

        $($(this).attr('href') + '.tab-pane').parent().find('.tab-pane').removeClass('active');
        $($(this).attr('href') + '.tab-pane').addClass('active');

        return false;
    });
});
