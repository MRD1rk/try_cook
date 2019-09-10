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
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">


</head>

<body id="page-top">
<div class="container">
    <div class="tc-header">
        <div class="tc-header-top">
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <div class="tc-header-logo ">
                    </div>
                </div>
                <div class="col-lg-5 col-xs-12">
                    <div class="search-block">
                        <input type="text" placeholder="{{ t._('fast-search') }}">
                        <div class="search-button">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <a class="tc-header-button">{{ t._('login') }}</a>
                    <a class="tc-header-button">{{ t._('signup') }}</a>
                </div>
            </div>
        </div>
        <div class="tc-header-bottom">
            <div class="row">
                <div class="col-12">
                    {{ NavWidget.run('header') }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-block {{ container_class }}">
    {{ content() }}
</div>


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
