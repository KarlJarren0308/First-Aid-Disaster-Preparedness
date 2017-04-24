function previewImageFile(input) {
    if(input.files && input.files[0]) {
        var fileReader = new FileReader();

        fileReader.onload = function(e) {
            $('.file-upload-preview').attr('src', e.target.result).css('opacity', '1');
        }

        fileReader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {
    $('.file-uploader').on('dragover', function(e) {
        e.preventDefault();
        $('.file-upload-preview').css('opacity', '0');
    });

    $('.file-uploader').on('dragleave', function(e) {
        e.preventDefault();
        $('.file-upload-preview').css('opacity', '1');
    });

    $('.file-uploader').on('drop', function(e) {
        e.preventDefault();
        previewImageFile(e.originalEvent.dataTransfer);
    });

    $('.file-upload').change(function() {
        previewImageFile($(this)[0]);
    });
});