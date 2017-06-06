function calculateResult(yesCount, noCount) {
    return ((yesCount / (yesCount + noCount)) * 100).toFixed(2);
}

$(document).ready(function() {
    var commentsLength = 0;
    var selfTestYesCount = 0;
    var selfTestNoCount = 0;

    $(function() {
        setInterval(function() {
            $.ajax({
                url: '/health_and_safety/comments',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    healthAndSafetyID: $('#health-and-safety-block').data('var-id')
                },
                dataType: 'json',
                success: function(response) {
                    var img = '';

                    if(commentsLength !== response['data'].length) {
                        $('#comments-block').html('');

                        for(var i = 0; i < response['data'].length; i++) {
                            if(response['data'][i]['account_info']['image'] === null) {
                                img = 'fadp_anonymous.png';
                            } else {
                                img = response['data'][i]['account_info']['image'];
                            }

                            $('#comments-block').append('<div class="comment block"><div class="image"><img src="/uploads/' + img + '" class="round"></div><div class="content"><div>' + response['data'][i]['comment'] + '</div><div>' + moment(response['data'][i]['created_at']).fromNow() + '</div></div></div>');
                        }

                        commentsLength = response['data'].length;
                    }
                }
            });

            return false;
        }, 1000);
    });

    $('#captcha-modal').on('hidden.bs.modal', function () {
        grecaptcha.reset();
    });

    $('#comment-form').submit(function() {
        $('#captcha-modal').modal('show');

        return false;
    });

    $('#captcha-form').submit(function() {
        $.ajax({
            url: '/captcha/comment',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                grecaptcha.reset();

                $('#captcha-modal').modal('hide');

                if(response['status'] === 'Success') {
                    $.ajax({
                        url: '/health_and_safety/comment',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: $('#comment-form').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if(response['status'] === 'Success') {
                                $('#comment-form input[name="comment"]').val('').focus();
                            }
                        }
                    });

                    return false;
                }
            }
        });

        return false;
    });

    $('.start-self-test-button').click(function() {
        $(this).fadeOut(250, function() {
            $('.self-tests').children('.self-test-page').eq(0).fadeIn(250);
        });
    });

    $('.self-test-answer .yes-button').click(function() {
        var selfTestPage = $(this).parent().parent().parent().parent();
        var selfTestPageIndex = selfTestPage.index();
        var selfTestPageCount = selfTestPage.parent().children('.self-test-page').length;

        $(this).parent().parent().find('button').attr('disabled', true);

        selfTestYesCount++;

        if(selfTestPageIndex + 1 == selfTestPageCount - 1) {
            var result = calculateResult(selfTestYesCount, selfTestNoCount);

            $('.self-test-page').eq(selfTestPageIndex + 1).children('.self-test-result').text('Test Result: ' + result + '%');
        }

        if(selfTestPageIndex + 1 < selfTestPageCount) {
            selfTestPage.fadeOut(250, function() {
                selfTestPage.parent().children('.self-test-page').eq(selfTestPageIndex + 1).fadeIn(250);
            });
        }
    });

    $('.self-test-answer .no-button').click(function() {
        var selfTestPage = $(this).parent().parent().parent().parent();
        var selfTestPageIndex = selfTestPage.index();
        var selfTestPageCount = selfTestPage.parent().children('.self-test-page').length;

        $(this).parent().parent().find('button').attr('disabled', true);

        selfTestNoCount++;

        if(selfTestPageIndex + 1 == selfTestPageCount - 1) {
            var result = calculateResult(selfTestYesCount, selfTestNoCount);

            $('.self-test-page').eq(selfTestPageIndex + 1).children('.self-test-result').text('Test Result: ' + result + '%');
        }

        if(selfTestPageIndex + 1 < selfTestPageCount) {
            selfTestPage.fadeOut(250, function() {
                selfTestPage.parent().children('.self-test-page').eq(selfTestPageIndex + 1).fadeIn(250);
            });
        }
    });
});
