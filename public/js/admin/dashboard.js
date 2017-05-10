window.fbAsyncInit = function() {
    FB.init({
        appId: '777405132427492',
        xfbml: true,
        version: 'v2.9'
    });

    FB.api('/', {
        'id': $('meta[name="page_url"]').attr('content')
    }, function (response) {
        if (response && !response.error) {
            document.getElementById('fb-shares').innerHTML = JSON.stringify(response);
        }
    });
};
