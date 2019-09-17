<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#header-navbar" aria-controls="header-navbar" aria-expanded="false"
            aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="header-navbar">
        <ul class="navbar-nav mr-auto nav-fill w-100">
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="{{ url.get(['for':'index-index','iso_code':iso_code]) }}">{{ t._('main') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="{{ url.get(['for':'recipes-index','iso_code':iso_code]) }}">{{ t._('recipes') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#signup">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#signup">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#signup">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#signup">Contact</a>
            </li>
        </ul>
    </div>
</nav>
<!-- End Navigation -->