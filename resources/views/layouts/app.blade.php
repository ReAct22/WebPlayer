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
            width: 100vw;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* .hamburger {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            z-index: 1050;
        } */

        #categorySelect {
            display: none;
            /* position: absolute; */
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

        .carousel-control-next-icon,
        .carousel-control-prev-icon {
            filter: brightness(0.1);
            /* makin kecil makin gelap */
            border: 2px solid #fff;
            /* tambahkan border putih */
            border-radius: 50%;
            /* opsional, agar tampak lebih bulat */
            padding: 10px;
            /* opsional, untuk memberi ruang di dalam */
            background-color: rgba(0, 0, 0, 0.5);
            /* opsional, untuk efek backdrop gelap */
        }
    </style>
</head>

<body>
    @yield('content')




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('script-home')


</body>

</html>
