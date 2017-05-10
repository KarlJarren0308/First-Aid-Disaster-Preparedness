$(document).ready(function() {
    $(function() {
        $.ajax({
            url: '/admin/graphs/news/views',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                var ctx = $('#news-views');
                var newsFacebookShares = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: response['labels'],
                        datasets: [
                            {
                                label: 'Page Views',
                                fill: false,
                                lineTension: 0.1,
                                backgroundColor: 'rgba(231, 73, 68, 0.4)',
                                borderColor: 'rgba(231, 73, 68, 1)',
                                borderCapStyle: 'butt',
                                borderDash: [],
                                borderDashOffset: 0.0,
                                borderJoinStyle: 'miter',
                                pointBorderColor: 'rgba(231, 73, 68, 1)',
                                pointBackgroundColor: '#fff',
                                pointBorderWidth: 1,
                                pointHoverRadius: 5,
                                pointHoverBackgroundColor: 'rgba(231, 73, 68, 1)',
                                pointHoverBorderColor: 'rgba(220, 220, 220, 1)',
                                pointHoverBorderWidth: 2,
                                pointRadius: 1,
                                pointHitRadius: 10,
                                data: response['data'],
                                spanGaps: false,
                            }
                        ]
                    }
                });
            }
        });

        return false;
    });
});
