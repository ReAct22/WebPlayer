<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Testimoni Laser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("{{ asset('images/bg-image.jpg') }}");

            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;

            margin: 0;
            padding: 0;
        }

        .hamburger {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            z-index: 1050;
        }

        #categorySelect {
            display: none;
            position: absolute;
            top: 50px;
            right: 10px;
            z-index: 1040;
            width: 200px;
        }

        .playlist-thumbnail {
            cursor: pointer;
            transition: transform 0.2s;
        }

        .playlist-thumbnail:hover {
            transform: scale(1.03);
        }

        .carousel-item video,
        .carousel-item img {
            max-height: 400px;
            object-fit: contain;
        }
    </style>
</head>

<body>
    @yield('content')




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('script-home')


</body>

</html>
