 // Wait for the page to fully load
 document.addEventListener('DOMContentLoaded', function() {
    // Check if the member details section exists
    var cat = document.getElementById('cat');
    var memberDetails = document.getElementById('member_details');

    if (cat.style.display === 'none') {
        cat.style.display = 'block';
        memberDetails.style.display = 'none';
    }
    else if(memberDetails) {
        // Set a timeout to hide the member details section after 5 seconds
        cat.style.display = 'none';
        memberDetails.style.display = 'block';
        setTimeout(function() {
            cat.style.display = 'block';
            memberDetails.style.display = 'none';
        }, 5000); // 5000 milliseconds = 5 seconds
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Check if the member details section exists
    var memberDetails = document.getElementById('member_details');
    if (memberDetails) {
        var countdownElement = document.getElementById('countdown');
        var secondsLeft = 5; // Initial value for countdown
        // Function to update countdown text
        function updateCountdown() {
            countdownElement.textContent = 'Closing in (' + secondsLeft + ') seconds...';
            secondsLeft--; // Decrement secondsLeft
            if (secondsLeft >= 0) {
                // If there are seconds left, schedule the next update
                setTimeout(updateCountdown, 1000); // Update countdown every second (1000 milliseconds)
            } else {
                // If countdown is complete, hide the member details section
                cat.style.display = 'cat';
                
            }
        }
        // Initial call to start the countdown
        updateCountdown();
    }
});


setTimeout(function() {
    var userNotExistMessage = document.getElementById('userNotExist');
    if (userNotExistMessage) {
        userNotExistMessage.style.display = 'none';
    }
}, 3000);