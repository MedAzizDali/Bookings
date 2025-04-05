<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Listings</title>
    <link rel="stylesheet" href="{{ asset('sessions.css') }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>
 
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Available Sessions</h1>
        <div id="notification" class="alert alert-success mt-4" style="display:none;"></div>

        <div class="list-group">
            @foreach ($sessions as $session)
                <div class="list-group-item">
                    <h5>{{ $session->name }}</h5>
                    <p>{{ $session->description }}</p>
                    <p><strong>Start Time:</strong> {{ $session->start_time }}</p>
                    <button class="btn btn-primary book-btn" data-id="{{ $session->id }}">Book Now</button>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        {{ $sessions->links('pagination::bootstrap-5') }}

    </div>
    
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>

        window.Pusher = Pusher;
        // Define showToast function first
        function showToast(message, type) {
            Toastify({
                text: message,
                duration: 5000,
                gravity: "top",
                position: "right",
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                close: true,
            }).showToast();
        }

        $(document).on('click', '.book-btn', function() {
            var sessionId = $(this).data('id');
            $.ajax({
                url: '/sessions/book/' + sessionId,
                type: 'POST',
                success: function(response) {
                    showToast(response.message, "success"); 
                },
                error: function() {
                    showToast("An error occurred while booking.", "error");
                }
            });
        });

        Pusher.logToConsole = true; 

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ config('broadcasting.connections.pusher.key') }}',
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            forceTLS: true
        });

        // Listen for the event
        window.Echo.channel('sessions').listen('.booking-confirmed', (e) => {
            console.log("Booking Confirmed:", e.session);
            showToast(`Booking confirmed for: ${e.session.name}`, "success"); // Show toast for real-time updates
        });



    </script>
</body>
</html>
