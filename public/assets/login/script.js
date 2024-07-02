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
            const email = loginForm.querySelector('[placeholder="Email"]').value;
            const password = loginForm.querySelector('[placeholder="Password"]').value;
    
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
    
            // Check for errors in the response and set the form message accordingly
            if (response.error) {
                setFormMessage(loginForm, "error", response.error);
            } else {
                setCookie('session', response.cookie, 6 * 30);
                window.location.href = "/dashboard";
            }
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            setFormMessage(loginForm, "error", "An error occurred during login.");
        }
    });
    
    createAccountForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        try {
            // Get the values from the form inputs
            const email = createAccountForm.querySelector('[placeholder="Email"]').value;
            const password = createAccountForm.querySelector('[placeholder="Password"]').value;
            const password_conf = createAccountForm.querySelector('[placeholder="Confirm Password"]').value;
            const name = createAccountForm.querySelector('[placeholder="Full Name"]').value;

            if(password_conf != password){
                setFormMessage(createAccountForm, "error", "The password don't match!");
                return;
            }
    
            // Perform your AJAX/Fetch signup
            const request = await fetch("/api/account/signup", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ email, password, name })
            });
    
            // Check if the request was successful
            if (!request.ok) {
                throw new Error('Network response was not ok');
            }
    
            // Parse the response as JSON
            const response = await request.json();
    
            // Check for errors in the response and set the form message accordingly
            if (response.error) {
                setFormMessage(createAccountForm, "error", response.error);
            } else {
                setCookie('session', response.cookie, 6 * 30);
                window.location.href = "/dashboard";
            }
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            setFormMessage(createAccountForm, "error", "An error occurred during login.");
        }
    });

    document.querySelectorAll(".form__input").forEach(inputElement => {
        inputElement.addEventListener("input", e => {
            clearInputError(inputElement);
        });
    });
});

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 30 * 24 * 60 * 60 * 1000)); // Calculate expiration time in milliseconds (assuming 30 days per month)
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}