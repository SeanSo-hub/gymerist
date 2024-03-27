document.addEventListener('DOMContentLoaded', function() {
    // Check if the member details section exists
    var form = document.getElementById('form');
    var memberDetails = document.getElementById('member_details');

    if (form.style.display === 'none') {
        form.style.display = 'block';
        memberDetails.style.display = 'none';
    }
    else if(memberDetails) {
        // Set a timeout to hide the member details section after 5 seconds
        form.style.transition = 'opacity 0.5s ease-in, left 0.5s ease-in';
        memberDetails.style.transition = 'opacity 0.5s ease-out, left 0.5s ease-out';
        form.style.opacity = '0';
        memberDetails.style.opacity = '1';
        form.style.left = '0';
        memberDetails.style.left = '0';
        setTimeout(function() {
            form.style.opacity = '1'; // Ensure the form is visible before fading out
            memberDetails.style.opacity = '0'; // Fade out member details
            memberDetails.style.left = '-100%'; // Swipe to the left
            setTimeout(function() {
                form.style.display = 'block';
                memberDetails.style.display = 'none';
                form.style.opacity = '1'; // Reset form opacity
                form.style.left = '0';
            }, 500); // Wait for the fade out transition to complete
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
                memberDetails.style.transition = 'opacity 0.5s ease-out, left 0.5s ease-out';
                memberDetails.style.opacity = '0'; // Fade out member details
                memberDetails.style.left = '-100%'; // Swipe to the left
                setTimeout(function() {
                    memberDetails.style.display = 'none';
                    memberDetails.style.opacity = '1'; // Reset opacity
                    memberDetails.style.left = '0'; // Reset left position
                }, 500); // Wait for the fade out transition to complete
            }
        }
        // Initial call to start the countdown
        updateCountdown();
    }
});

setTimeout(function() {
    var userNotExistMessage = document.getElementById('userNotExist');
    if (userNotExistMessage) {
        userNotExistMessage.style.transition = 'opacity 0.5s ease-out';
        userNotExistMessage.style.opacity = '0';
        setTimeout(function() {
            userNotExistMessage.style.display = 'none';
        }, 500); // Wait for the fade out transition to complete
    }
}, 3000);
