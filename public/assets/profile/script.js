document.addEventListener("DOMContentLoaded", async function() {
    const managerSelect = document.getElementById('manager');
    const nameSelect = document.getElementById('Name')

    // Check if the dropdown menu exists
    if (managerSelect) {
        // Add an event listener for the 'change' event
        managerSelect.addEventListener('change', async function() {
            // Get the selected manager's ID
            const manager = managerSelect.value;

            try {
                // Perform your AJAX/Fetch login
                const request = await fetch("/api/account/change-manager", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({manager})
                });
            
                // Check if the request was successful
                if (!request.ok) {
                    throw new Error('Network response was not ok');
                }
            
                // Parse the response as JSON
                const response = await request.json();
            
                // Check for errors in the response and set the form message accordingly
                if (response.error) {
                    setFormMessage(loginForm, "error", response.error);
                }

            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                setFormMessage(loginForm, "error", "An error occurred during changing the manager.");
            }
        });
    } else {
        console.error("Manager dropdown not found!");
    }






    // Check if the name box exists
    if (nameSelect) {
        // Add an event listener for the 'input' event
        nameSelect.addEventListener('input', async function() {
            // Get the inputted name
            const name = nameSelect.value;

            try {
                // Perform your AJAX/Fetch login
                const request = await fetch("/api/account/change-name", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({name})
                });
            
                // Check if the request was successful
                if (!request.ok) {
                    throw new Error('Network response was not ok');
                }
            
                // Parse the response as JSON
                const response = await request.json();
            
                // Check for errors in the response and set the form message accordingly
                if (response.error) {
                    setFormMessage(loginForm, "error", response.error);
                }

            } catch (error) {
                console.error('There was a problem with the fetch operation:', error);
                setFormMessage(loginForm, "error", "An error occurred during changing the name.");
            }
        });
    } else {
        console.error("Name box not found!");
    }
});