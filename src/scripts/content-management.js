function openPage(pageName, elmnt, color) {
  // Hide all elements with class="tabcontent" by default
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
  }

  // Remove the underline from all tablinks/buttons
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
      tablinks[i].style.textDecoration = "none";
      tablinks[i].style.textDecorationColor = ""; // Reset underline color
      tablinks[i].style.textDecorationThickness = ""; // Reset underline thickness
      tablinks[i].style.textUnderlineOffset = ""; // Reset the vertical space
  }

  // Show the specific tab content
  document.getElementById(pageName).style.display = "block";

  // Add the underline, set the color, and thickness for the clicked tab
  elmnt.style.textDecoration = "underline";
  elmnt.style.textDecorationColor = color; // Set the color of the underline
  elmnt.style.textDecorationThickness = "4px"; // Set the thickness of the underline
  elmnt.style.textUnderlineOffset = "6px"; // Add vertical space between the text and underline
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();




document.querySelectorAll('input').forEach(input => {
  input.addEventListener('keypress', function(event) {
      if (this.value.length === 0 && !/^[a-zA-Z]$/.test(event.key)) {
          event.preventDefault(); // Prevent numbers or spaces as the first character in non-amount fields
      }
  });
});





