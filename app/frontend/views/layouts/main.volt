<!DOCTYPE html>

<html lang="{{ iso_code }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Grayscale - Start Bootstrap Theme</title>
    <script src="https://kit.fontawesome.com/758b2eb9a3.js"></script>
    {{ assets.outputCss('headerCss') }}
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">


</head>

<body id="page-top">
<div class="tc-header">
    <div class="tc-header-top row">
        <div class="col-4">
            <div class="tc-header-logo ">
                <img src="/img/logo.png" alt="logo">
            </div>
        </div>
        <div class="col-4">
            <div class="search-block">
                <input type="text" placeholder="Search">
                <div class="search-button">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="col-4">
            login
        </div>
    </div>
    {{ NavWidget.run() }}
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
{{ assets.outputJs('footerJs') }}

</body>

</html>
