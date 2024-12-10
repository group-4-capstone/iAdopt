load_data_merch();

function load_data_merch(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-merchandise.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';

            if (response.data.length > 0) {
                for (var count = 0; count < response.data.length; count++) {

                    var merch_id = response.data[count].merch_id;
                    var item = response.data[count].item;
                    var link = response.data[count].link;
                    var status = response.data[count].status;
                    var image = response.data[count].image;
                    
                    // Append each merchandise item as a grid item
                    html += `
                        <div class="grid_items">
                            <img src="styles/assets/merchandise/${image}" alt="${item}">
                            <h2>${item}</h2>
                            <p><a href="${link}" target="_blank">Buy Here</a></p>
                        </div>
                    `;
                }
            } else {
                // If no data, show a message in the grid
                html = `<div class="text-center w-100">No Merchandise Found</div>`;
            }

            // Update the grid with the generated HTML
            document.querySelector('.merch').innerHTML = html;
        }
    };
}
