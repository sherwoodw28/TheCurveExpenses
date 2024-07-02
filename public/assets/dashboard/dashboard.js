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
            // Update the details dynamically if needed
            // For now, we are showing static content
            document.getElementById('payment-submitted-by').textContent = "Eric Rosa (ericrosa914@gmail.com)";
            
            // Clear and add items to the list
            const paymentRequestDetails = document.getElementById('payment-request-details');
            paymentRequestDetails.innerHTML = "";
            const items = ["MAX STINKS", "Reason: Yo beautiful, pay my bills!"];
            items.forEach(item => {
                const li = document.createElement('li');
                li.textContent = item;
                paymentRequestDetails.appendChild(li);
            });
            
            document.getElementById('payment-submission-date').textContent = "2023-07-01 12:00 PM";

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
