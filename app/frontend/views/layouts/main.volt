<!DOCTYPE html>

<html lang="{{ iso_code }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
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
                        <input class="form-control my-0 py-1" id="search" type="text" placeholder="Search"
                               aria-label="Search">
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
<img style="width: 100%;" src="/img/template.png">


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
</body>

</html>
