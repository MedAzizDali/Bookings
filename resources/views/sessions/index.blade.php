<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Listings</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
    

    <script>
        

        window.Pusher = Pusher;
        $(document).on('click', '.book-btn', function() {
            var sessionId = $(this).data('id');
            $.ajax({
                url: '/sessions/book/' + sessionId,
                type: 'POST',
                
                success: function(response) {
                    $('#notification').text(response.message).show();
                    setTimeout(function() {
                        $('#notification').fadeOut();
                    }, 5000);
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
    window.Echo.channel('sessions')
    .listen('.booking-confirmed', (e) => {
        console.log("Booking Confirmed:", e.session);
        let notification = document.getElementById('notification');
        notification.textContent = `Booking confirmed for: ${e.session.name}`;
        notification.style.display = 'block';

        setTimeout(() => {
            notification.style.display = 'none';
        }, 5000);
    });



    </script>
</body>
</html>
