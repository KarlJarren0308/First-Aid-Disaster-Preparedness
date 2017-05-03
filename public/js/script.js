function sDataButton(dataButton) {
    return $('[data-button="' + dataButton + '"]');
}

function sDataForm(dataForm) {
    return $('[data-form="' + dataForm + '"]');
}

function onDataButtonClick(dataButton, func) {
    $('body').on('click', '[data-button="' + dataButton + '"]', func);
}

function onDataFormSubmit(dataForm, func) {
    $('body').on('submit', '[data-form="' + dataForm + '"]', func);
}

function ajaxError(xhr, textStatus, errorThrown) {
    console.log(xhr.responseText);
}

$(document).ready(function() {
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $('.tabs > li > .tab').click(function() {
        $(this).parent().parent().find('li').removeClass('active');
        $(this).parent().addClass('active');

        $($(this).attr('href') + '.tab-pane').parent().find('.tab-pane').removeClass('active');
        $($(this).attr('href') + '.tab-pane').addClass('active');

        return false;
    });
});
