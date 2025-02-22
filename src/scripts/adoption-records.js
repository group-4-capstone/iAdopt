load_data();

function load_data(query = '', page_number = 1, sort_order = 'desc') {
    var form_data = new FormData();

    form_data.append('query', query);
    form_data.append('page', page_number);
    form_data.append('sort_order', sort_order);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'includes/fetch-adoption-applications.php');

    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);

            var html = '';

            var serial_no = 1;

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {
                    var application_id = response.data[count].application_id;
                    html += '<tr onclick="window.location.href=\'adoption-details.php?id=' + application_id + '\'">';
                    html += '<td>' + application_id + '</td>';
                    html += '<td>' + response.data[count].application_date + '</td>';
                    html += '<td>' + response.data[count].first_name + ' ' + response.data[count].last_name + '</td>';
                    html += '<td>' + response.data[count].complete_address + '</td>';
                    html += '<td>' + response.data[count].name + '</td>';
                    var badgeClass = '';
                    if (response.data[count].application_status === 'For Interview') {
                        badgeClass = 'badge-review';
                    } else if (response.data[count].application_status === 'Approved') {
                        badgeClass = 'badge-approved';
                    } else if (response.data[count].application_status === 'Rejected') {
                        badgeClass = 'badge-rejected';
                    }

                    html += '<td><span class="badge-oval ' + badgeClass + '">' + response.data[count].application_status + '</span></td>';
                    html += '</tr>';
                    serial_no++;
                }
            } else {
                html += '<tr><td colspan="6" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('post_data').innerHTML = html;
            document.getElementById('pagination_link').innerHTML = response.pagination;
        }
    };
}


// Rescue Records Sort By Event Listener
document.querySelectorAll('.application-sort-option').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        const sortOrder = this.getAttribute('data-sort');
        load_data('', 1, sortOrder);
    });
});