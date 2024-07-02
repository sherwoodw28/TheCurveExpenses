<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - The Curve</title>
    <link rel="stylesheet" href="/assets/reset_pass/style.css">
</head>
<body>
    <div class="reset-password-container">
        <h1>Reset Your Password</h1>
        <form id="reset-password-form">
            <div class="form__message form__message--error"></div>
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
    </div>
</body>
</html>
<script>
    document.querySelector('#reset-password-form').addEventListener('submit', async(e)=>{
        e.preventDefault();

        // Get data from submission
        const email = document.querySelector('#email').value;

        try {
            // Perform your AJAX/Fetch signup
            const request = await fetch("/api/account/reset-password", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ email })
            });
    
            // Check if the request was successful
            if (!request.ok) {
                throw new Error('Network response was not ok');
            }
    
            // Parse the response as JSON
            const response = await request.json();
    
            // Check for errors in the response and set the form message accordingly
            if (response.error) {
                setFormMessage(document.querySelector('#reset-password-form'), "error", response.error);
            } else {
                setFormMessage(document.querySelector('#reset-password-form'), "reset", 'Password email reset');
            }
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            setFormMessage(document.querySelector('#reset-password-form'), "error", "An error occurred during login.");
        }
    })
    function setFormMessage(formElement, type, message) {
        const messageElement = formElement.querySelector(".form__message");

        messageElement.textContent = message;
        messageElement.classList.remove("form__message--success", "form__message--error");
        messageElement.classList.add(`form__message--${type}`);
    }
</script>