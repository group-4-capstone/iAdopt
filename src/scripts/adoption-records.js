
document.querySelectorAll('tr[data-href]').forEach(row => {
    row.addEventListener('click', function() {
        window.location.href = this.getAttribute('data-href');
    });
});
