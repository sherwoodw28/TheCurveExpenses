document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('form');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Create a FormData object
        const formData = new FormData();
        
        // Append text values
        formData.append('reason', document.getElementById('reason').value);
        formData.append('details', document.getElementById('details').value);
        formData.append('dateNeededFrom', document.getElementById('dateNeededFrom').value);
        formData.append('dateNeededTo', document.getElementById('dateNeededTo').value);
        formData.append('totalCost', document.getElementById('totalCost').value);
        formData.append('assistance', document.getElementById('assistance').value);
        formData.append('comments', document.getElementById('comments').value);

        // Append files
        formData.append('file1', document.querySelector('#fileUpload').files[0]);
        formData.append('file2', document.querySelector('#fileUpload1').files[0]);
        formData.append('file3', document.querySelector('#fileUpload2').files[0]);

        try {
            // Perform the request
            const request = await fetch("/api/form/submit", {
                method: "POST",
                body: formData
            });
    
            // Check if the request was successful
            if (!request.ok) {
                throw new Error('Network response was not ok');
            }
    
            // Parse the response as JSON
            const response = await request.json();
    
            // Check for errors in the response and set the form message accordingly
            if (response.error) {
                setFormMessage(false, "error", response.error);
            } else {
                alert('Form submitted successfully');
                window.location.href = '/dashboard';
            }
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            setFormMessage(false, "error", "An error occurred during form submission.");
        }
    });
});

function setFormMessage(success, type, message) {
    const messageElement = document.querySelector('#message');
    messageElement.textContent = message;
    messageElement.className = type;
}
