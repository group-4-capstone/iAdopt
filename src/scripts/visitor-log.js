load_data();

function load_data(query = '', page_number = 1)
{
    var form_data = new FormData();

    form_data.append('query', query);

    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();

    ajax_request.open('POST', 'includes/fetch-visit.php');

    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function()
    {
        if(ajax_request.readyState == 4 && ajax_request.status == 200)
        {
            var response = JSON.parse(ajax_request.responseText);

            var html = '';

            var serial_no = 1;

            if(response.data.length > 0)
            {
                for(var count = 0; count < response.data.length; count++)
                {
                    html += '<tr>';
                    html += '<td>'+response.data[count].visit_id+'</td>';
                    html += '<td>'+response.data[count].name+'</td>';
                    html += '<td>'+response.data[count].group_name+'</td>';
                    html += '<td>'+response.data[count].num_pax+'</td>';
                    html += '<td>'+response.data[count].purpose+'</td>';
                    html += '<td>'+response.data[count].visit_date+'</td>';
                    html += '</tr>';
                    serial_no++;
                }
            }
            else
            {
                html += '<tr><td colspan="6" class="text-center">No Data Found</td></tr>';
            }

            document.getElementById('post_data').innerHTML = html;


            document.getElementById('pagination_link').innerHTML = response.pagination;

        }

    }
}