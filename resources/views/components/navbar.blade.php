<nav class="navbar navbar-inverse navbar-fixed-top z-depth-4">
    <div class="container">
        <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/movies">TVSickness</a>
        </div>
        <div style="position: relative" id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/home">Home</a></li>
                <li><a href="/movies">Movies</a></li>
                <li><a href="/tvshows">TV Shows</a></li>
                <li><a href="/about">About</a></li>
            </ul>
            <form class="navbar-form navbar-right">
                <div class="form-group">
                    <input type="text" class="form-control" onkeyup="search(this.value)" placeholder="Search">
                </div>
            </form>
        </div>
        <div class="z-depth-4" id="search-content">
        </div>
    </div>
</nav>
