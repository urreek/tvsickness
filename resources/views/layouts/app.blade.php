<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - TVSickness</title>
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/app.js"></script>
</head>
<body>
    @include('components.navbar')
    <main class="container">
        @yield('content')
    </main>
    <footer id="footer" class="z-depth-4">
        <div class="container">
                <section class="text-center col-xs-12 col-md-3" id="footer-copyright">
                    <h4>TVSickness</h4>
                    <p>Copyright 2018 &copy; TVSickness.com</p>
                </section>
                <section class="text-center col-xs-12 col-md-3" id="footer-navigation">
                    <h4>Navigate</h4>
                    <ul class="list-unstyled">
                        <li><a href="/home">Home</a></li>
                        <li><a href="/movies">Movies</a></li>
                        <li><a href="/tvshows">TV Shows</a></li>
                        <li><a href="/about">About</a></li>
                    </ul>
                </section>
                <section class="text-center col-xs-12 col-md-3" id="footer-copyright">
                    <h4>Contact</h4>
                    <a href="mailto:contact@tvsickness.com">contact@tvsickness.com</a>
                </section>
                <section class="text-center col-xs-12 col-md-3" id="footer-copyright">
                    <h4>TMDb</h4>
                    <p>
                        This product uses the TMDb API but is not endorsed or certified by <a href="https://www.themoviedb.org/"> TMDb</a>. 
                        <a href="https://www.themoviedb.org/"> <img src="/images/tmdb.svg" id="tmdb-logo"></a>
                    </p>
                </section>
        </div>
    </footer>
</body>
</html>