document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('form');
    var memberDetails = document.getElementById('member_details');
    var userNotExistMessage = document.getElementById('userNotExist');

    if (!memberDetails) {
        form.style.display = 'block';
    }
    if (memberDetails) {
        memberDetails.style.display = 'block';
        form.style.display = 'none';
    }
    if (userNotExistMessage) {
        form.style.display = 'block';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    var memberDetails = document.getElementsByClassName('details')[0];
    if (memberDetails) {
        var countdownElement = document.getElementById('countdown');
        var secondsLeft = 5;

        function updateCountdown() {
            countdownElement.textContent = 'Closing in (' + secondsLeft + ') seconds...';
            secondsLeft--;
            console.log(secondsLeft);
            if (secondsLeft >= 0) {
                setTimeout(updateCountdown, 1000);
            } else {
                memberDetails.style.transition = 'opacity 0.5s ease-out, left 0.5s ease-out';
                memberDetails.style.opacity = '0';
                memberDetails.style.left = '-100%';
                setTimeout(function () {
                    memberDetails.style.display = 'none';
                    memberDetails.style.opacity = '1';
                    memberDetails.style.left = '0';
                    window.location.href = window.location.origin + window.location.pathname;
                }, 500);
            }
        }
        updateCountdown();
    }
});


setTimeout(function () {
    var userNotExistMessage = document.getElementById('userNotExist');
    if (userNotExistMessage) {
        userNotExistMessage.style.transition = 'opacity 0.5s ease-out';
        userNotExistMessage.style.opacity = '0';
        setTimeout(function () {
            userNotExistMessage.style.display = 'none';
        }, 500);
    }
}, 3000);