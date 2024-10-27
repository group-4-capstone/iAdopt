 // Event listener for when the success modal for Announcement is hidden
 $('#successAnnouncementModal').on('hidden.bs.modal', function () {
    localStorage.setItem('activeTab', 'Home'); // Store the Announcement tab key
    location.reload();
});

// Event listener for when the success modal for Merchandise is hidden
$('#successMerchModal').on('hidden.bs.modal', function () {
    localStorage.setItem('activeTab', 'News'); // Store the Merchandise tab key
    location.reload();
});

// Event listener for when the success modal for Volunteers is hidden
$('#successVolunteerModal').on('hidden.bs.modal', function () {
    localStorage.setItem('activeTab', 'Contact'); // Store the Volunteers tab key
    location.reload();
});

// Event listener for when the success modal for FAQ is hidden
$('#successFAQModal').on('hidden.bs.modal', function () {
    localStorage.setItem('activeTab', 'About'); // Store the FAQ tab key
    location.reload();
});

 // Event listener for when the success modal for Announcement is hidden
 $('#successEditAnnouncementModal').on('hidden.bs.modal', function () {
    localStorage.setItem('activeTab', 'Home'); // Store the Announcement tab key
    location.reload();
});

// Event listener for when the success modal for Merchandise is hidden
$('#successEditMerchModal').on('hidden.bs.modal', function () {
    localStorage.setItem('activeTab', 'News'); // Store the Merchandise tab key
    location.reload();
});

// Event listener for when the success modal for Volunteers is hidden
$('#successEditVolunteerModal').on('hidden.bs.modal', function () {
    localStorage.setItem('activeTab', 'Contact'); // Store the Volunteers tab key
    location.reload();
});

// Event listener for when the success modal for FAQ is hidden
$('#successEditFAQModal').on('hidden.bs.modal', function () {
    localStorage.setItem('activeTab', 'About'); // Store the FAQ tab key
    location.reload();
});

// On page load, check for active tab and open it
window.onload = function() {
    const activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        let tabId;
        switch (activeTab) {
            case 'Home':
                tabId = 'defaultOpen'; // Announcement tab
                break;
            case 'News':
                tabId = 'merchtab'; // Merchandise tab
                break;
            case 'Contact':
                tabId = 'volunteertab'; // Volunteers tab
                break;
            case 'About':
                tabId = 'faqtab'; // FAQs tab
                break;
        }
        openPage(activeTab, document.getElementById(tabId), '#ffdb5a');
        localStorage.removeItem('activeTab'); // Remove the activeTab after it's used
    }
};