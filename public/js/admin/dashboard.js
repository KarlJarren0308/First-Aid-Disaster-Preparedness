// window.fbAsyncInit = function() {
//     FB.init({
//         appId: '777405132427492',
//         xfbml: true,
//         version: 'v2.9'
//     });
//
//     $.ajax({
//         url: 'https://graph.facebook.com/oauth/access_token',
//         method: 'GET',
//         data: {
//             client_id: '777405132427492',
//             client_secret: '59076d2ff159c571ae7afc1174064992',
//             grant_type: 'client_credentials'
//         },
//         success: function(response) {
//             var accessToken = response.access_token;
//
//             FB.api('/', {
//                 'id': $('meta[name="page_url"]').attr('content'),
//                 'access_token': accessToken
//             }, function (res) {
//                 alert(JSON.stringify(res));
//
//                 if (res && !res.error) {
//                     $('#fb-shares').text(JSON.stringify(res));
//                 }
//             });
//         }
//     });
// };

$(document).ready(function() {
    $(function() {
        $.ajax({
            url: '/admin/graphs/news/facebook_shares',
            method: 'GET',
            success: function(response) {
                $('#shares').text(JSON.stringify(response));
            }
        });

        return false;
    });
});
