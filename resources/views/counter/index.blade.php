<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Token System</title>
    <link rel="stylesheet" href="{{asset('cropper/cropper.min.css')}}">
    <link rel="stylesheet" href="{{asset('bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('sweetalert/sweetalert2.min.css')}}">

</head>
<body>
    <div class="container mt-5">
        <h1>{{ Auth::guard('counter')->user()->name }} DashBoard</h1>
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white text-center fs-4">
                Counter
            </div>
            <div class="card-body text-center">
                <h5 class="card-title" id="counter4Token">No Token</h5>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-success btn-lg w-100" id="getToken">Get Token</button>
            </div>
        </div>
    </div>
<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('cropper/cropper.min.js')}}"></script>
<script src="{{asset('bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('sweetalert/sweetalert2.min.js')}}"></script>
<script>
    $(document).on('click', '#getToken', function (e) {
            e.preventDefault();

            var counterId = $(this).data('counter'); // Get the counter number
            var tokenLabel = "#counter" + counterId + "Token"; // Get the corresponding token label

            $.ajax({
                type: "GET",
                url: "{{route('counter.gettoken', encrypt(Auth::guard('counter')->user()->id))}}",
                success: function (response) {

                    if (response.status === 200) {
                        updateTokenDisplay(response.data.total, response.data.last_went);
                        $(tokenLabel).text("Token #" + response.data.last_went);
                    }
                },
                error: function(xhr, status, error) {
                        var errorResponse = JSON.parse(xhr.responseText);
                        alert('Alert: ' + errorResponse.message);
                }
            });
        });
</script>
</body>
</html>
