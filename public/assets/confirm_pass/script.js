const errorBox = document.querySelector('#message');

document.querySelector('#change_pass').addEventListener('submit', async (e)=>{
    e.preventDefault();

    let password = document.querySelector('#password').value;
    let passConf = document.querySelector('#cnfrm-password').value;

    if(password != passConf){
        setFormMessage(false, "error", 'Passwords must match');
        return;
    }

    try {
        // Perform your AJAX/Fetch logic
        const request = await fetch("/api/account/change-password", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ password })
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
        } else{
            // Success
            location.href = '/login';
        }
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        setFormMessage(false, "error", "An error occurred during updating password.");
    }
});

function setFormMessage(a, b, message){
    errorBox.textContent = message;
}