// Old
// OTHER OLD CODE ON GITHUB


// New
document.addEventListener('DOMContentLoaded', function() {
    const dragElements = document.querySelectorAll('.item');

    // Make them draggable
    Array.from(dragElements).forEach(element => {
        element.addEventListener('mousedown', ()=>{
            element.style['width'] = window.getComputedStyle(element).width;

            document.addEventListener("mousemove", setDragMode);

            setTimeout(()=>{
                document.removeEventListener("mousemove", setDragMode);

                if(!element.classList.contains('attach')){
                    openPopup(element);
                }
            }, 60);

            function setDragMode(){
                element.classList.add('attach');
            }
        })
    });

    document.addEventListener("mousemove", (event) => {
        const elements = document.querySelectorAll(".card, .trash");
        const closestElement = getClosestElement(elements, event.clientX, event.clientY);

        // Remove existing active cards class
        Array.from(document.querySelectorAll('.card.active, .trash.active')).forEach(element => {
            element.classList.remove('active');
        });

        if(document.querySelector('.attach')){ // Check if we are dragging
            closestElement.classList.add('active');
        }
    });

    // Stop dragging
    document.addEventListener('mouseup', ()=>{
        Array.from(document.querySelectorAll('.attach')).forEach(element => {
            element.classList.remove('attach');

            // Run the operations
            if(document.querySelector('.card.active') && document.querySelector('.card.active').getAttribute('id')){
                opperation(parseInt(element.getAttribute('data-id')), document.querySelector('.card.active').getAttribute('id'));
                document.querySelector('.card.active').append(element);
            }
            if(document.querySelector('.active.trash')){
                opperation(parseInt(element.getAttribute('data-id')), 'refuse');

                element.remove();
            }
        });
    })

    // Snap element to cursor
    document.addEventListener('mousemove', moveElementToMouse);

    function moveElementToMouse(event){
        const element = document.querySelector('.attach');

        if(element){
            element.style.left = `${event.clientX - 150}px`;
            element.style.top = `${event.clientY - 30}px`;
        }
    }

    // Popup quit
    document.querySelector('.popup img').addEventListener('click', ()=>{
        document.querySelector('.popup').style.display = 'none';
    });
});
function openPopup(element){
    // Show the popup
    document.querySelector('.popup').style.display = 'block';

    // Extract data attributes
    const name = element.getAttribute('data-name');
    const email = element.getAttribute('data-email');
    const reason = element.getAttribute('data-reason');
    const details = element.getAttribute('data-details');
    const date = element.getAttribute('data-date');
    const endDate = element.getAttribute('data-enddate');
    const cost = element.getAttribute('data-cost');
    const timeStamp = element.getAttribute('data-timestamp');
    const id = element.getAttribute('data-id');
    const comment = element.getAttribute('data-comment');

    document.querySelector('.popup .title').textContent = reason;
    document.querySelector('.popup .content').innerHTML = 
   `<b>Submitted By:</b> ${name} (${email}) <br>
    <b>Reason:</b> ${reason} <br>
    <b>Details:</b> ${details} <br>
    <b>Date From:</b> ${formatDate(date)} <br>
    <b>Date To:</b> ${formatDate(endDate)} <br>
    <b>Total Cost:</b> ${cost} <br>
    <b>Comment:</b> ${comment} <br>
    <b>Submission Date:</b> ${formatDate(timeStamp)} <br>
    <a href="/view-receipt?id=${id}">View Receipts</a>`;
}
function getClosestElement(elements, cursorX, cursorY) {
    return Array.from(elements).reduce((closest, el) => {
      const rect = el.getBoundingClientRect();
      const elX = (rect.left + rect.right) / 2;
      const elY = (rect.top + rect.bottom) / 2;
      const distance = Math.hypot(cursorX - elX, cursorY - elY);
      return !closest || distance < closest.distance ? { el, distance } : closest;
    }, null).el;
}
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
async function opperation(id, op){
    try {
        // Perform your AJAX request
        const request = await fetch("/api/form/"+op, {
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
        }
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        alert(error);
    }
}