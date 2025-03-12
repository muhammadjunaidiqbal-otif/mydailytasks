<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

    <!-- Main Container -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <a href="" class="text-white text-decoration-none fw-bold fs-5">
                            <h2>Authentication System</h2>
                        </a>
                        <h6 class="mb-0">@yield('card-title')</h6>
                    </div>
                    <div class="card-body bg-light">
                   @yield('card-body')
                   @if (session('status'))
                        <div class="text-danger text-center mt-3 mb-3" id="success">
                        {{ session('status') }}
                        </div>
                    @endif 
                    @if (session('alert'))
                        <div class="alert alert-danger text-center mt-3 mb-3" role="alert" id="success">
                        {{ session('alert') }}
                        </div>
                    @endif 
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

     
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        setTimeout(function() {
            var message = document.getElementById("success");
            if (message) {
                message.style.display = "none";
            }
        }, 3000); 
    </script>

</body>
</html>
