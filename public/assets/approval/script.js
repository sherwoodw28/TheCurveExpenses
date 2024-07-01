// script.js
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('sampleForm');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting normally

        const email = document.getElementById('email').value;
        const reason = document.getElementById('reason').value;
        const details = document.getElementById('details').value;
        const dateNeededFrom = document.getElementById('dateNeededFrom').files[0];
        const dateNeededTo = document.getElementById('dateNeededTo').files[0];
        const totalCost = document.getElementById('totalCost').files[0];
        const assistance = document.getElementById('assistance').files[0];
        const comments = document.getElementById('comments').files[0];

        // Basic validation (more sophisticated validation can be added)
        if (!email || !reason || !details || !dateNeededFrom || !dateNeededTo || totalCost || !assistance || !comments) {
            alert('Please fill out all fields');
            return;
        }

        if (!validateEmail(email)) {
            alert('Please enter a valid email address');
            return;
        }

        // Handle file upload
        const formData = new FormData();
        formData.append('email', email);
        formData.append('reason', reason);
        formData.append('details', details);
        formData.append('dateNeededFrom', dateNeededFrom);
        formData.append('dateNeededTo', dateNeededTo);
        formData.append('totalCost', totalCost);
        formData.append('assistance', assistance);
        formData.append('comments', comments);

        fetch('your-server-endpoint', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert('Form submitted successfully!');
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Form submission failed!');
        });
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});