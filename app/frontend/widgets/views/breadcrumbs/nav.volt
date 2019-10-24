<!--Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url.get(['for':'index-index','iso_code':iso_code]) }}">{{ t._('main') }}</a> </li>
    {% for breadcrumb in breadcrumbs %}
        {% if loop.last %}
            <li class="breadcrumb-item active">{{ breadcrumb['name'] }}</li>
        {% else %}
            <li class="breadcrumb-item"><a class="breadcrumb-link" href="{{ breadcrumb['link']|default('') }}">{{ breadcrumb['name'] }}</a></li>
        {% endif %}
    {% endfor %}
</ol>
<!--Breadcrumbs-end-->