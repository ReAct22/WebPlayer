
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>WebPlayer</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" />
    <link href="https://vjs.zencdn.net/8.22.0/video-js.css" rel="stylesheet" />
    <style>
      body {
        background-image: url("assets/image/background.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        width: 100%;
      }
      .video {
        border-radius: 20px;
        width: 100%;
      }
      @media screen and (max-width: 600px) {
        .video {
          width: 100%;
        }
      }
      @media screen and (max-width: 400px) {
        .video {
          width: 100%;
        }
      }
    </style>
  </head>
  <body>
    @yield('content')

    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <link href="https://vjs.zencdn.net/8.22.0/video-js.css" rel="stylesheet" />
    @stack('scripts')
  </body>
</html>
