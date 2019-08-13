{#breadcrumbs-nav-start#}
<div class="breadcrumbs">
    {% for breadcrumb in breadcrumbs %}
        <a href="{{ breadcrumb['link'] }}"><span class="breadcrumb-item">{{ breadcrumb['name'] }}</span></a>
    {% endfor %}
</div>
{#breadcrumbs-nav-end#}