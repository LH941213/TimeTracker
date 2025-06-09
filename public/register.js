document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault();
    let formData = new FormData(this);

    fetch('../controllers/register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => alert(data))
    .catch(error => console.error('Error:', error));
});
