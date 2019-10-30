<!DOCTYPE html>

<html lang="{{ iso_code }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="token" title="{{ tokenKey }}" content="{{ tokenValue }}">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" sizes="57x57" href="/img/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/img/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icons/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/img/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    {{ tag.getTitle() }}
    {{ tag.getDescription() }}
    {{ tag.getAppleTouchIcons() }}
    {{ assets.outputCss('headerCss') }}


</head>

<body id="page-top">
<div class="container-fluid p-0">
    <div class="tc-header">
        <div class="tc-header-top">
            <div class="row ">
                <div class="col-lg-2 col-xs-6">
                    <div class="tc-header-logo ">
                    </div>
                </div>
                <div class="offset-lg-1 col-lg-3 col-xs-12 align-middle">
                    <div class="search-group input-group">
                        <input class="form-control my-0 py-1" id="search" type="text" placeholder="{{ t._('search') }}"
                               aria-label="{{ t._('search') }}">
                        <div class="input-group-append">
                    <span class="input-group-text" id="search-button">
                         <i class="fas fa-search text-white" aria-hidden="true"></i>
                    </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-6">
                    <div class="row justify-content-end">
                        <div class="col-lg-5">
                            <div class="header-sign">
                                <a href="#" class="btn-tc">{{ t._('signin') }}</a>
                                <a href="#" class="btn-tc btn-green">{{ t._('signup') }}</a>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            {{ SelectLangWidget.run() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tc-header-bottom">
            <div class="row">
                <div class="col-12 p-0">
                    {{ NavWidget.run('header') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-block {{ container_class }}">
    {{ content() }}
</div>
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-8 p-3">
                <div class="row">
                    <div class="col-4">
                        <ul class="footer-list">
                            <li><a href="#">{{ t._('main') }}</a></li>
                            <li><a href="#">{{ t._('recipes') }}</a></li>
                            <li><a href="#">{{ t._('about_us') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <ul class="footer-list">
                            <li><a href="#">{{ t._('popular') }}</a></li>
                            <li><a href="#">{{ t._('new_items') }}</a></li>
                            <li><a href="#">{{ t._('articles') }}</a></li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <ul class="footer-list">
                            <li><a href="#">{{ t._('rules') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-4 p-3">
                <div>
                    <img src="/img/footer_logo.png">
                </div>
                <div>
                    <p>Современный подход к кулинарии</p>
                </div>
            </div>
            <div class="col-8">
                <div class="build-by">
                    <span>{{ t._('build_by') }} &copy; {{ site_name }}, {{ date('Y') }}</span></div>
            </div>
            <div class="col-4">
                <div class="social-links">
                    <div class="social-link-item">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29">
                                        <path fill="#8b80a0"
                                              d="M15.1 5.536c-1.599.423-3.452.335-4.238 1.28-.794.959-.533 2.94-.76 4.68h4.868l-.622 5.296h-4.055v13.01c-1.545 0-2.917-.014-4.289.007-.913.014-.758-.686-.759-1.27-.007-3.318-.004-6.638-.004-9.957v-1.72H1.37v-5.316h3.873c0-1.221-.012-2.28.002-3.338.062-4.821 2.222-7.144 6.633-7.144 3.307 0 3.308 0 3.266 3.57-.005.367-.035.732-.043.902z"></path>
                            </svg>
                        </a></div>
                    <div class="social-link-item">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="31" viewBox="0 0 29 29">
                                <path fill="#8b80a0"
                                      d="M8.04 30.18c-3.638-.298-6.435-3.118-6.602-7.06a175.787 175.787 0 0 1-.033-14.284c.167-4.268 2.908-7.194 6.84-7.365a146.59 146.59 0 0 1 12.89.008c3.867.173 6.647 3.328 6.797 7.656.156 4.471.17 8.96-.005 13.43-.176 4.498-2.974 7.341-7.16 7.638-2.037.145-4.08.207-6.122.304-2.203-.106-4.409-.15-6.605-.328zM25.41 15.89c0-1.453.007-2.906-.005-4.359a42.789 42.789 0 0 0-.08-2.089c-.178-3.063-1.85-5.04-4.682-5.127a199.92 199.92 0 0 0-12.07.004c-2.67.08-4.389 1.74-4.51 4.66-.192 4.57-.188 9.164.001 13.735.12 2.855 1.76 4.494 4.391 4.59 4.073.148 8.158.165 12.23.01 2.944-.114 4.541-2.09 4.64-5.324.06-2.032.01-4.067.01-6.1h.074z"></path>
                                <path fill="#8b80a0"
                                      d="M21.537 15.842c-.001 4.276-2.966 7.483-6.92 7.482-3.88 0-6.951-3.308-6.971-7.51-.02-4.14 3.099-7.47 6.993-7.467 3.956.004 6.9 3.202 6.898 7.495zm-2.605.057c.028-2.602-1.83-4.667-4.235-4.71-2.382-.04-4.347 2-4.394 4.562-.047 2.579 1.839 4.654 4.258 4.683 2.45.03 4.344-1.935 4.37-4.535z"></path>
                                <path fill="#8b80a0"
                                      d="M21.45 10.145c-.64-.254-1.2-1.294-1.308-1.899-.201-1.109.436-1.892 1.574-1.914 1.117-.02 1.829.691 1.676 1.82-.096.711-.748 1.711-1.383 1.991a.699.699 0 0 1-.558.002z"></path>

                            </svg>
                        </a></div>
                    <div class="social-link-item">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29">
                                <path fill="#8b80a0"
                                      d="M1.309 6.182c.004-1.333.488-2.417 1.413-3.273a5.025 5.025 0 0 1 2.304-1.24c.575-.134 1.132-.04 1.562.386A18.777 18.777 0 0 1 8.222 3.89c.797 1.03 1.494 2.142 2.02 3.367.49 1.136.318 1.926-.581 2.71-.18.157-.373.298-.56.448-.79.643-1.064 1.45-.774 2.475.402 1.422 1.142 2.642 2.053 3.74 1.13 1.362 2.504 2.362 4.047 3.094 1.07.508 1.784.28 2.46-.75.159-.239.33-.47.525-.676.659-.697 1.44-.875 2.314-.577.2.068.404.148.583.264a28.348 28.348 0 0 1 4.19 3.325c.708.677.83 1.565.462 2.481-.798 1.975-2.165 3.252-4.126 3.723-.602.145-1.187-.08-1.732-.333C10.99 23.407 5.098 17.24 1.749 8.337a7.738 7.738 0 0 1-.33-1.152c-.068-.327-.076-.668-.11-1.003z"></path>
                                <path fill="#8b80a0"
                                      d="M14.178 1.287c2.856.09 5.277 1.286 7.31 3.416 1.774 1.859 2.92 4.103 3.312 6.753.123.834.12 1.692.138 2.54.01.48-.24.736-.634.75-.385.014-.61-.202-.676-.668-.162-1.115-.257-2.247-.493-3.343-.413-1.921-1.193-3.655-2.54-5.038-1.277-1.313-2.828-2.071-4.515-2.517-.798-.211-1.618-.331-2.431-.47-.48-.081-.694-.275-.677-.695.02-.486.266-.724.752-.728h.454z"></path>
                                <path fill="#8b80a0"
                                      d="M21.988 12.357c0 .185.015.37-.003.553-.04.41-.233.595-.614.61-.383.016-.575-.143-.647-.568-.126-.736-.204-1.485-.367-2.212-.295-1.321-.83-2.505-1.874-3.343-.876-.702-1.89-1.061-2.932-1.34-.331-.09-.671-.142-1.007-.206-.514-.097-.707-.343-.665-.856.035-.425.3-.687.72-.66 3.91.26 6.669 3.152 7.287 6.463.095.508.105 1.035.154 1.553l-.052.005z"></path>
                                <path fill="#8b80a0"
                                      d="M15.663 7.508c.802.036 1.434.351 1.992.845.837.742 1.441 1.644 1.563 2.843.028.276.008.567-.04.841-.053.305-.252.487-.549.52-.298.031-.524-.1-.627-.395-.087-.25-.123-.523-.172-.788-.252-1.353-1-2.142-2.256-2.373-.119-.02-.24-.038-.355-.075-.263-.086-.489-.214-.493-.569-.005-.37.183-.678.497-.768.164-.048.335-.063.44-.08z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
{#<img style="width: 100%;" src="/img/template.png">#}


<!-- Footer -->
{#<footer class="bg-black small text-center text-white-50">#}
{#    <div class="container">#}
{#        Copyright &copy; Your Website 2019#}
{#    </div>#}
{#</footer>#}
<script>
    let iso_code = '{{ iso_code }}';
</script>
{{ assets.outputJs('footerJs') }}
<input id="token" type="hidden" name="{{ security.getTokenKey() }}" value="{{ security.getToken() }}">
</body>

</html>
