window.fbAsyncInit = function() {
    FB.init({
        appId: '777405132427492',
        xfbml: true,
        version: 'v2.9'
    });

    FB.getLoginStatus(function(res) {
        if(res.status === 'connected') {
            var accessToken = res.authResponse.accessToken;

            FB.api('/', {
                'id': $('meta[name="page_url"]').attr('content'),
                'access_token': accessToken
            }, function (response) {
                alert(JSON.stringify(response));
                if (response && !response.error) {
                    $('#fb-shares').text(response);
                }
            });
        }
    });
};
