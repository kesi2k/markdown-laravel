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
    <title>Document</title>
</head>

<body>
    <div class="container"> <!-- wrap everything in a Bootstrap container for spacing -->
        <a href="/markdown/create" class="btn btn-primary">Create Markdown</a>
        <div class="card my-3">
            <div class="card-body">
                <h5 class="card-title">Markdown </h5>
                <div class="card-text">{!! $markDownData !!}</div>
            </div>
        </div>

        <div class="card my-3">
            <div class="card-body">
                <h5 class="card-title">HTML </h5>
                @foreach($charsRemoved as $line)
                    @if($line === 'EmptyEmpty' || $line === 'Empty')
                        <br>                    
                    @else
                        <p class="card-text">                          
                            {{ $line }}
                        </p>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</body>