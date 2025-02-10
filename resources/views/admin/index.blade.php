@extends('admin.layout')
@section('content')
    <h1>Admin Dashboard</h1>

    <!-- Token Add Form -->
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-success text-white text-center fs-4">
            Add Token
        </div>
        <div class="card-body">
            <form action="" id="tokenForm">
                <div class="form-group">
                    <input type="number" class="form-control form-control-lg" name="token" placeholder="Enter number of tokens" required min="1">
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-success btn-lg">Add Token</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Dynamic Info Section -->
    <div class="row">
        <div class="col-md-6 ">
            <h1>Total Issued Tokens: <span id="totalTokens">0</span></h1>
        </div>
        <div class="col-md-6 ">
            <h3>Last Went: <span id="lastWent">0</span></h3>
            <h3>Token Left: <span id="tokenLeft">0</span></h3>
        </div>
    </div>

    <!-- Issue Token Section -->
    <div class="row mt-4 justify-content-center">
        <div class="col-lg-4">
            <a href="#" class="text-decoration-none" id="issueToken">
                <div class="card bg-success text-white text-center fs-3 rounded shadow-lg">
                    <div class="card-body py-4">
                        Issue Token
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-5">
        <button class="btn btn-danger btn-sm" id="clearSession">Clear Session</button>
    </div>
@endsection
@section('scripts')
<script>
    $(document).on('submit', '#tokenForm', function (e) {
        e.preventDefault();

        var tokenCount = $('input[name="token"]').val(); // Get the number of tokens to add

        if (!tokenCount || tokenCount <= 0) {
            alert('Please enter a valid number of tokens.');
            return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "{{route('admin.addtoken')}}",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === 200) {
                    $('#tokenForm')[0].reset();
                    // Update UI with the total tokens and token left
                    updateTokenDisplay(response.data.total, response.data.last_went);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors such as network issues, or invalid response
                console.error("Error: " + error);
                alert('An error occurred: ' + error);
            }
        });
    });

    function updateTokenDisplay(total, last_went) {

        $('#totalTokens').text(total);
        $('#lastWent').text(last_went);
        $('#tokenLeft').text(total-last_went);
    }

    $(document).on('click', '#issueToken', function (e) {
        e.preventDefault();

        $.ajax({
            type: "GET",
            url: "{{route('admin.issuetoken')}}",
            success: function (response) {
                console.log(response);

                if (response.status === 200) {

                    $('#totalTokens').text(response.data.total);

                    updateTokenDisplay(response.data.total, response.data.last_went);
                }
            },
            error: function(xhr, status, error) {
                // Handle errors such as network issues, or invalid response
                console.error("Error: " + error);
                alert('An error occurred: ' + error);
            }
        });
    });

    $(document).on('click', '#clearSession', function (e) {
        e.preventDefault();

        if (confirm('Sure Clear Session?')) {
            $.ajax({
                type: "GET",
                url: "{{route('admin.clearsession')}}",
                success: function (response) {
                    if (response.status === 200) {
                        alert(response.message);

                        updateTokenDisplay(0,0);

                        // Reset counters
                        for (var i = 1; i <= 4; i++) {
                            $('#counter' + i + 'Token').text('No Token');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + error);

                    alert('Alert : ' + error);
                }
            });
        }
    });

</script>
@endsection
