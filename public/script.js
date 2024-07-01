function setFormMessage(formElement, type, message) {
    const messageElement = formElement.querySelector(".form__message");

    messageElement.textContent = message;
    messageElement.classList.remove("form__message--success", "form__message--error");
    messageElement.classList.add(`form__message--${type}`);
}

function setInputError(inputElement, message) {
    inputElement.classList.add("form__input--error");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = message;
}

function clearInputError(inputElement) {
    inputElement.classList.remove("form__input--error");
    inputElement.parentElement.querySelector(".form__input-error-message").textContent = "";
}

document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.querySelector("#login");
    const createAccountForm = document.querySelector("#createAccount");

    document.querySelector("#linkCreateAccount").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.add("form--hidden");
        createAccountForm.classList.remove("form--hidden");
    });

    document.querySelector("#linkLogin").addEventListener("click", e => {
        e.preventDefault();
        loginForm.classList.remove("form--hidden");
        createAccountForm.classList.add("form--hidden");
    });

    loginForm.addEventListener("submit", async (e) => {
        e.preventDefault();
    
        try {
            // Get the values from the form inputs
            const email = document.querySelector('[placeholder="Email"]').value;
            const password = document.querySelector('[placeholder="Password"]').value;
    
            // Perform your AJAX/Fetch login
            const request = await fetch("/api/account/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ email, password })
            });
    
            // Check if the request was successful
            if (!request.ok) {
                throw new Error('Network response was not ok');
            }
    
            // Parse the response as JSON
            const response = await request.json();
    
            console.log(response);
    
            // Check for errors in the response and set the form message accordingly
            if (response.error) {
                setFormMessage(loginForm, "error", response.error);
            } else {
                // Handle success (e.g., redirect to another page)
                console.log("Login successful!");
                // Redirect to another page or perform some other action
                // window.location.href = "/some-other-page";
            }
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            setFormMessage(loginForm, "error", "An error occurred during login.");
        }
    });
    

    document.querySelectorAll(".form__input").forEach(inputElement => {
        inputElement.addEventListener("blur", e => {
            if (e.target.id === "signupUsername" && e.target.value.length > 0 && e.target.value.length < 10) {
                setInputError(inputElement, "Username must be at least 10 characters in length");
            }
        });

        inputElement.addEventListener("input", e => {
            clearInputError(inputElement);
        });
    });
});