<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light pl-0">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#header-navbar" aria-controls="header-navbar" aria-expanded="false"
            aria-label="Toggle navigation">
        {{ t._('menu') }}
        <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="header-navbar">
        <ul class="navbar-nav">
            <li class="nav-item pr-3">
                <a class="nav-link" href="{{ url.get(['for':'index-index','iso_code':iso_code]) }}">{{ t._('main') }}</a>
            </li>
            <li class="nav-item pr-3">
                <a class="nav-link" href="{{ url.get(['for':'recipes-index','iso_code':iso_code]) }}">{{ t._('recipes') }}</a>
            </li>
            <li class="nav-item pr-3">
                <a class="nav-link" href="#">{{ t._('about_us') }}</a>
            </li>
            <li class="nav-item pr-3">
                <a class="nav-link" href="#">{{ t._('popular') }}</a>
            </li>
            <li class="nav-item pr-3">
                <a class="nav-link" href="#">{{ t._('new_items') }}</a>
            </li>
            <li class="nav-item pr-3">
                <a class="nav-link" href="#">{{ t._('articles') }}</a>
            </li>
        </ul>
    </div>
</nav>
<!-- Navigation End-->