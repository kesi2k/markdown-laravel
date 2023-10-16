<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CDN links -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Submit Markdown</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Submit Markdown</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="/markdown/post" method="post" enctype="multipart/form-data">
                {{-- <form action="#" method="post"> --}}

                    @csrf

                    <div class="form-group">
                        <label for="body">Message Body:</label>
                        <textarea id="body" name="message" cols="50" rows="10" placeholder="Enter markdown" class="form-control"></textarea>
                    </div>     
                    <br>
                    <br>            
                    <button
                        type="submit"
                        class="">
                        Submit Markdown
                    </button>
                </form>
        </div>
    </div>
</body>