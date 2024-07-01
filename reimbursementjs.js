// script.js
document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('sampleForm');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting normally

        const email = document.getElementById('email').value;
        const approval= document.getElementById('approval').value;
        const cost= document.getElementById('cost').value;
        const file= document.getElementById('fileUpload').value;
        const comments= document.getElementById('comments').value;


        // Basic validation 
        if (!email || !approval || !cost || !file || !comments) {
            alert('Please fill out all fields');
            return;
        }

        if (!validateEmail(email)) {
            alert('Please enter a valid email address');
            return;
        }

        alert('Form submitted successfully!');
        
    });

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});