function previewImageFile(input) {
    if(input.files && input.files[0]) {
        var fileReader = new FileReader();

        fileReader.onload = function(e) {
            $('.image-upload-preview').attr('src', e.target.result).css('opacity', '1');
        }

        fileReader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {
    $('.image-uploader').on('dragover', function(e) {
        e.preventDefault();
        $('.image-upload-preview').css('opacity', '0');
    });

    $('.image-uploader').on('dragleave', function(e) {
        e.preventDefault();
        $('.image-upload-preview').css('opacity', '1');
    });

    $('.image-uploader').on('drop', function(e) {
        e.preventDefault();
        previewImageFile(e.originalEvent.dataTransfer);
    });

    $('.image-upload').change(function() {
        previewImageFile($(this)[0]);
    });
});