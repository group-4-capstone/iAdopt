// ----------------------------- announcements TABLE ----------------------------------- //
load_data_announcements();

function load_data_announcements(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-announcements.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                var html = '';
                for (var count = 0; count < response.data.length; count++) {
                    var announcement_id = response.data[count].announcement_id;
                    var image = response.data[count].image;
                    var title = response.data[count].title;
                    var description = response.data[count].description;
                    var announcement_status = response.data[count].announcement_status;

                    var shortContent = description.length > 100 ? description.substring(0, 100) + '...' : description;
            
                    // Only display announcements with status "Published"
                    if (announcement_status === 'Published') {
                      // Shorten content for preview
        
                    // Add each announcement item as a grid item
                    html += `
                        <div class="grid_items">
                            <img src="styles/assets/announcement/${image}" alt="${title}">
                            <div class="grid_text">
                                <h3>${title}</h3>
                                <p>${shortContent}</p>
                                <button class="btn" data-bs-toggle="modal" data-bs-target="#readMoreModal_${announcement_id}">Read More</button>
                            </div>
                        </div>
                    `;
                    }
                }
            
                // Check if there are published announcements
                if (html === '') {
                    html = '<p class="text-center">No published announcements available at the moment.</p>';
                }
            
                // Append the generated HTML to the container
                document.querySelector('.updates').innerHTML = html;
                document.getElementById('announcements_pagination_link').innerHTML = response.pagination;
                // Attach click event listeners to "Read More" buttons
                document.querySelectorAll('.read-more-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const announcementId = this.getAttribute('data-id');
                        const title = this.getAttribute('data-title');
                        const description = this.getAttribute('data-description');
                        const image = this.getAttribute('data-image');

                        // Set modal content
                        document.getElementById('modalAnnouncementTitle').textContent = title;
                        document.getElementById('modalAnnouncementDescription').textContent = description;
                        document.getElementById('modalAnnouncementImage').src = `styles/assets/announcement/${image}`;
                    });
                });

            } else {
                html = '<p class="text-center">No published announcements available at the moment.</p>';
            }
           
        }
    };
}

