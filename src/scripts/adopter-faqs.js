load_data_faq();

function load_data_faq(query = '', page_number = 1) {
    var form_data = new FormData();
    form_data.append('query', query);
    form_data.append('page', page_number);

    var ajax_request = new XMLHttpRequest();
    ajax_request.open('POST', 'includes/fetch-faqs.php');
    ajax_request.send(form_data);

    ajax_request.onreadystatechange = function () {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            var response = JSON.parse(ajax_request.responseText);
            var html = '';
            var serial_no = 1;

            if (response.data.length > 0) {
                // Initialize accordion container
                html += '<div class="accordion accordion-flush" id="faqAccordion">';
                
                for (var count = 0; count < response.data.length; count++) {
                    var faq_id = response.data[count].faq_id;
                    var question = response.data[count].question;
                    var answer = response.data[count].answer;
                    var faq_status = response.data[count].faq_status;
            
                    // Display only Published FAQs
                    if (faq_status === 'Published') {
                        // Accordion item
                        html += `
                        <div class="accordion-item bg-transparent border-bottom py-3">
                            <h2 class="accordion-header" id="faqHeading_${faq_id}">
                                <button class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary" type="button" 
                                        data-bs-toggle="collapse" data-bs-target="#faqCollapse_${faq_id}" 
                                        aria-expanded="false" aria-controls="faqCollapse_${faq_id}">
                                    ${question} 
                                </button>
                            </h2>
                            <div id="faqCollapse_${faq_id}" class="accordion-collapse collapse" aria-labelledby="faqHeading_${faq_id}" 
                                 data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    ${answer}
                                </div>
                            </div>
                        </div>`;
                    }
                }
            
                // Close accordion container
                html += '</div>';
            } else {
                html += '<div class="text-center py-3">No FAQs Found</div>';
            }
            

            document.getElementById('faqs').innerHTML = html;
        }
    };
}
