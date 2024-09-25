
// ===================================== Rescue Request Table ================================= //
// Function to handle table row clicks and open the modal with dynamic data
document.querySelectorAll('#newRescueTable tbody tr').forEach(function(row) {
    row.addEventListener('click', function() {
        // Get data from the clicked row
        const rescueDate = row.getAttribute('data-rescue-date');
        const characteristics = row.getAttribute('data-characteristics');  // Fetch characteristics from attribute
        const reporter = row.cells[1].textContent;  // Using the 2nd cell for reporter
        const address = row.cells[2].textContent;   // Using the 3rd cell for address
        const status = row.getAttribute('data-status');  // From the data-status attribute

        // Populate modal fields with the clicked row's data
        document.getElementById('rescueDate').value = rescueDate;
        document.getElementById('characteristics').value = characteristics;  // Populate characteristics
        document.getElementById('reporter').value = reporter;
        document.getElementById('address').value = address;
        // Optionally, populate status or other remarks field if needed
        // document.getElementById('remarks').value = status;

        // Open the modal
        new bootstrap.Modal(document.getElementById('rescueRequestModal')).show();
    });
});




// ===================================== Rescue Records Table ================================= //
document.addEventListener("DOMContentLoaded", function() {
    // Get all rows from the table
    const tableRows = document.querySelectorAll("#rescueTable tbody tr");

    // Add click event listener to each row
    tableRows.forEach(row => {
        row.addEventListener("click", function() {
            // Fetch data from row attributes
            const petName = this.dataset.petName;
            const rescuedBy = this.dataset.rescuedBy;
            const rescueDate = this.dataset.rescueDate;
            const type = this.dataset.type;
            const status = this.dataset.status;
            const gender = this.dataset.gender;
            const rescuedAt = this.dataset.rescuedAt; // New field
            const remarks = this.dataset.remarks; // Assuming remarks data is also available in the row attributes

            // Populate modal fields with row data
            document.getElementById('petName').value = petName;
            document.getElementById('rescuer').value = rescuedBy;
            document.getElementById('rescueDate').value = rescueDate;
            document.getElementById('type').value = type;
            document.getElementById('status').value = status;
            document.getElementById('gender').value = gender;
            document.getElementById('rescued-at').value = rescuedAt; // New field
            document.getElementById('remarks').value = remarks || ''; // Handle empty remarks

            // Initialize and show the modal
            const informationModal = new bootstrap.Modal(document.getElementById('informationModal'));
            informationModal.show();
        });
    });

    const updateButton = document.getElementById("updateButton");
    const inputs = document.querySelectorAll("#petName, #rescueDate, #rescuer, #type, #status, #gender, #rescued-at, #remarks");

    updateButton.addEventListener("click", function() {
        inputs.forEach(input => {
            input.removeAttribute("disabled");
        });
    });
});