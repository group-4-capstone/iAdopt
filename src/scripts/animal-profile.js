
//===================================================pagination=====================================//
document.addEventListener("DOMContentLoaded", function () {
    const paginationLinks = document.querySelectorAll(".pagination .page-link");
  
    paginationLinks.forEach(link => {
      link.addEventListener("click", function (event) {
        event.preventDefault();
        const page = this.getAttribute("data-page");
        loadPage(page);
      });
    });
  
    function loadPage(page) {
      const xhr = new XMLHttpRequest();
      xhr.open("GET", `animal-profiles.php?page=${page}`, true);
      xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
      xhr.onload = function () {
        if (xhr.status === 200) {
          document.getElementById("animal-cards").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }
  });