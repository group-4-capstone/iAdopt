load_data_notif();

function load_data_notif(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-notifications.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState === 4 && ajax_request.status === 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {
                    var notification_id = response.data[count].notification_id;
                    var message = response.data[count].message;
                    var notification_type = response.data[count].notification_type;
                    var created_at = response.data[count].created_at;

                    html += '<tr>';
                    html += '<td>' + notification_id + '</td>';
                    html += '<td><b>' + message + '</b></td>';
                    html += '<td>' + notification_type + '</td>';
                    html += '<td>' + created_at + '</td>';
                    html += '</tr>';
                    serial_no++;
                }
            } else {
                html = `<div class="text-center w-100">No Notifications Found</div>`;
            }

            
            document.getElementById('post_data').innerHTML = html;


            document.getElementById('pagination_link').innerHTML = response.pagination;
        }
    };
}
