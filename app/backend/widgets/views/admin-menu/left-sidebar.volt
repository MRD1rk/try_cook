{%- macro getMenu(tabs, current) %}
    {% for tab in tabs %}
        {% set active = '' %}
        {% set count_childs = tab.countChilds() %}
        {% if current['controller'] == tab.controller AND current['action'] == tab.action %}
            {% set active = 'active' %}
        {% endif %}
        {% if count_childs > 0 %}
            <li class="{{ active }}">
                <a href="javascript:void(0)" aria-expanded="true">
                    <i class="{{ tab.icon }}"></i><span>{{ tab.title }}</span>
                </a>
                <ul class="collapse">
                    {% for child in tab.childs %}
                        <li class="{{ active }}"><a
                                    href="{{ url.get(['for':child.getRouteName()]) }}">{{ child.title }}</a></li>
                    {% endfor %}
                </ul>
            </li>
        {% else %}
            <li class="{{ active }}">
                <a class="nav-link" href="{{ url.get(['for':tab.getRouteName()]) }}"><i
                            class="{{ tab.icon }}"></i>
                    <span class="nav-name">{{ t._(tab.title) }}</span>
                </a>
            </li>
        {% endif %}
    {% endfor %}
{%- endmacro %}

<div class="main-menu">
    <div class="menu-inner">
        <nav>
            <ul class="metismenu" id="menu">
                {% set current['controller'] = controller %}
                {% set current['action'] = action %}
                {{ getMenu(tabs, current) }}
            </ul>
        </nav>
    </div>
</div>