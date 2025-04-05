<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h2>Booking Requested!</h2>
    <p>You requested to book: <strong>{{ $session->name }}</strong></p>
    <p>Click the button below to confirm your booking:</p>

    <p>
        <a href="http://127.0.0.1:8000/confirm-booking/{{ $session->id }}"
           style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
            Confirm Booking
        </a>
    </p>
</body>
</html>