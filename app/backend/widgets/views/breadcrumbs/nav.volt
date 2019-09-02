<!--breadcrumbs-nav-start-->
<div class="breadcrumbs-area clearfix">
    <ul class="breadcrumbs pull-left">
        {% for breadcrumb in breadcrumbs %}
            {% if loop.last %}
                <li><span>{{ breadcrumb['name'] }}</span></li>
            {% else %}
                <li><a href="{{ breadcrumb['link']|default('') }}">{{ breadcrumb['name'] }}</a></li>
            {% endif %}
        {% endfor %}
    </ul>
</div>
<!--breadcrumbs-nav-end-->