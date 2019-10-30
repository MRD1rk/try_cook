<nav id="admin-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categories-navbar" aria-controls="categories-navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="categories-navbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url.get(['for':'admin-categories-update','id_category':id]) }}">{{ t._('main_info') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url.get(['for':'admin-categories-update-image','id_category':id]) }}">{{ t._('update_image') }}</a>
            </li>
        </ul>
    </div>
</nav>