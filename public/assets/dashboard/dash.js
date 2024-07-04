document.addEventListener('DOMContentLoaded', function() {
    const paymentOptions = document.getElementById('payment-options');
    const paymentDetails = document.getElementById('payment-details');
    const renewOptions = document.getElementById('renew-options');
    const renewDetails = document.getElementById('renew-details');

    window.onload = function() {
        document.getElementById('payment-options').selectedIndex = 0;
        document.getElementById('renew-options').selectedIndex = 0;
    };

    paymentOptions.addEventListener('change', function() {
        if (paymentOptions.value !== "") {
            // Get the selected option
            const selectedOption = paymentOptions.options[paymentOptions.selectedIndex];

            // Extract data attributes
            const name = selectedOption.getAttribute('data-name');
            const email = selectedOption.getAttribute('data-email');
            const reason = selectedOption.getAttribute('data-reason');
            const details = selectedOption.getAttribute('data-details');
            const date = selectedOption.getAttribute('data-date');
            const endDate = selectedOption.getAttribute('data-enddate');
            const cost = selectedOption.getAttribute('data-cost');
            const timeStamp = selectedOption.getAttribute('data-timestamp');
            const id = selectedOption.getAttribute('data-id');

            
            document.getElementById('payment-submitted-by').textContent = `${name} (${email})`;
            paymentDetails.querySelector('.view-rec').href = '/view-receipt?id='+id.toString();
            
            // Clear and add items to the list
            const paymentRequestDetails = document.getElementById('payment-request-details');
            paymentRequestDetails.innerHTML = "";
            const items = [`Reason: ${reason}`, `Details: ${details}`, `Date From: ${formatDate(date)}`, `Date To: ${formatDate(endDate)}`, `Total Cost: ${cost}`];
            items.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                paymentRequestDetails.appendChild(li);
            });
            
            document.getElementById('payment-submission-date').textContent = formatDate(timeStamp);

            paymentDetails.classList.add('show');
        } else {
            paymentDetails.classList.remove('show');
        }
    });

    document.getElementById('payment-approve-btn').addEventListener('click', async()=>{
        try {
            // Get the ID
            const id = paymentOptions.options[paymentOptions.selectedIndex].getAttribute('data-id');;
    
            // Perform your AJAX/Fetch login
            const request = await fetch("/api/form/approve", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id })
            });
    
            // Check if the request was successful
            if (!request.ok) {
                throw new Error('Network response was not ok');
            }
    
            // Parse the response as JSON
            const response = await request.json();
    
            // Check for errors in the response and set the form message accordingly
            if (response.error) {
                alert(response.error);
            } else {
                alert('Success');
                window.location.reload();
            }
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            setFormMessage(loginForm, "error", "An error occurred during login.");
        }
    })

    renewOptions.addEventListener('change', function() {
        if (renewOptions.value !== "") {
            // Get the selected option
            const selectedOption = renewOptions.options[renewOptions.selectedIndex];

            // Extract data attributes
            const name = selectedOption.getAttribute('data-name');
            const email = selectedOption.getAttribute('data-email');
            const reason = selectedOption.getAttribute('data-reason');
            const details = selectedOption.getAttribute('data-details');
            const date = selectedOption.getAttribute('data-date');
            const endDate = selectedOption.getAttribute('data-enddate');
            const cost = selectedOption.getAttribute('data-cost');
            const timeStamp = selectedOption.getAttribute('data-timestamp');
            const id = selectedOption.getAttribute('data-id');

            
            document.getElementById('payment-submitted-by').textContent = `${name} (${email})`;
            renewDetails.querySelector('.view-rec').href = '/view-receipt?id='+id.toString();
            
            // Clear and add items to the list
            const renewRequestDetails = document.getElementById('renew-request-details');
            renewRequestDetails.innerHTML = "";
            const items = [`Reason: ${reason}`, `Details: ${details}`, `Date From: ${formatDate(date)}`, `Date To: ${formatDate(endDate)}`, `Total Cost: ${cost}`];
            items.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                renewRequestDetails.appendChild(li);
            });
            
            document.getElementById('payment-submission-date').textContent = formatDate(timeStamp);

            renewDetails.classList.add('show');
        } else {
            renewDetails.classList.remove('show');
        }
    });

    document.getElementById('renew-approve-btn').addEventListener('click', async()=>{
        try {
            // Get the ID
            const id = renewOptions.options[renewOptions.selectedIndex].getAttribute('data-id');;
    
            // Perform your AJAX/Fetch login
            const request = await fetch("/api/form/renew", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id })
            });
    
            // Check if the request was successful
            if (!request.ok) {
                throw new Error('Network response was not ok');
            }
    
            // Parse the response as JSON
            const response = await request.json();
    
            // Check for errors in the response and set the form message accordingly
            if (response.error) {
                alert(response.error);
            } else {
                alert('Success');
                window.location.reload();
            }
        } catch (error) {
            console.error('There was a problem with the fetch operation:', error);
            setFormMessage(loginForm, "error", "An error occurred during login.");
        }
    })
});


function formatDate(dateString) {
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const suffixes = ["th", "st", "nd", "rd"];
    
    // Parse the input date string
    const date = new Date(dateString);
    
    // Extract date components
    const year = date.getFullYear();
    const month = months[date.getMonth()];
    const day = date.getDate();
    const hours = date.getHours();
    const minutes = date.getMinutes();
    
    // Determine the correct suffix for the day
    const daySuffix = suffixes[(day % 10) <= 3 && (day % 100) !== 11 && (day % 100) !== 12 && (day % 100) !== 13 ? (day % 10) : 0];
    
    // Convert hours to 12-hour format and determine AM/PM
    const period = hours < 12 ? "AM" : "PM";
    const hours12 = hours % 12 === 0 ? 12 : hours % 12;
    
    // Format minutes to always be two digits
    const formattedMinutes = minutes < 10 ? `0${minutes}` : minutes;
    
    // Construct the final formatted date string
    return `${month} ${day}${daySuffix} ${year} ${hours12}:${formattedMinutes} ${period}`;
}
