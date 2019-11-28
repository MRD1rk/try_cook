{% if not(user.logged) %}
    <div class="header-sign">
        <a href="#" onclick="$('#auth_modal').modal('show')" class="btn-tc">{{ t._('signin') }}</a>
        <a href="{{ url.get(['for':'auth-signup','iso_code':iso_code]) }}"
           class="btn-tc btn-green">{{ t._('signup') }}</a>
    </div>
{% else %}
    <div id="header-account-btn">
        <div class="btn-group">
            <button type="button" class="btn-tc dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                <img class="user-avatar" src="img/default-avatar.png">
                <span class="user-name">{{ user.getFullName() }}</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url.get(['for':'auth-logout']) }}">{{ t._('logout') }}</a>
            </div>
        </div>
    </div>
{% endif %}