<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/home.css">
    <title>Gymerist | Home</title>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="image">
                <img src="{{ asset('assets/images/gymerist_logo.png') }}" alt="Logo">
            </div>
            @if (!(isset($code) && isset($member)))
                <form id="form" action="{{ route('home') }}" method="post">
                    @csrf
                    <input type="text" name="code" placeholder="Enter Code" autocomplete="off" required>
                    <button type="submit">Check In</button>
                </form>
            @endif

            <div class="details">
                @if (isset($code) && !isset($member))
                    <div id="member_details">
                        <p id="userNotExist" style="color: red; animation: blink 1s infinite;">Member code does not exist</p>
                    @elseif(isset($code))
                        <h2>Member Details:</h2>
                        <p>Fullname: {{ $member->firstname . ' ' . $member->lastname ?? 'N/A' }}</p>
                        <p>Code: {{ $member->code }}</p>
                        <p>Email: {{ $member->email }}</p>
                        <p>Status: {{ $member->subscription_status ?? 'Not a member' }}</p>
                        <p>Plan ends on:
                            {{ isset($payment->plan_end_date) ? \Carbon\Carbon::parse($payment->plan_end_date)->format('F j, Y') : 'Not subscribed to a plan' }}
                        </p>
                        <p id="countdown"></p>
                    </div>
                @endif
            </div>
            <div id="cat">
                <lottie-player src="{{ URL::asset('/assets/json/cat.json') }}" background="transparent" speed="1"
                    style="width: 300px; height: 300px" direction="1" mode="normal" loop autoplay></lottie-player>
            </div>
        </div>
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <script src="{{ URL::asset('assets/js/admin/countdown.js') }}"></script>
</body>

</html>
