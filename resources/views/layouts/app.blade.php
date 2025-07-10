
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

       .video-js.vjs-theme-youtube {
        color: #fff;
        font-family: 'Roboto', sans-serif;
        background-color: #000;
    }

    .vjs-theme-youtube .vjs-big-play-button {
        background-color: rgba(255, 255, 255, 0.8);
        color: #000;
        border-radius: 50%;
        font-size: 2em;
    }

    .vjs-theme-youtube .vjs-control-bar {
        background-color: rgba(0, 0, 0, 0.8);
    }
    .video-container {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        padding-top: 25px;
        height: 0;
    }

    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
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
