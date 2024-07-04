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


            
            document.getElementById('payment-submitted-by').textContent = `${name} (${email})`;
            
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

    renewOptions.addEventListener('change', function() {
        if (renewOptions.value !== "") {
            // Update the details dynamically if needed
            // For now, we are showing static content
            document.getElementById('renew-submitted-by').textContent = "Jane Doe";
            
            // Clear and add items to the list
            const renewRequestDetails = document.getElementById('renew-request-details');
            renewRequestDetails.innerHTML = "";
            const items = ["Consectetur adipiscing elit.", "Another renewal detail item."];
            items.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                renewRequestDetails.appendChild(li);
            });

            document.getElementById('renew-submission-date').textContent = "2023-07-02 1:00 PM";

            renewDetails.classList.add('show');
        } else {
            renewDetails.classList.remove('show');
        }
    });
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
