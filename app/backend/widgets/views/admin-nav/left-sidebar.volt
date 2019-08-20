{%- macro getMenu(tabs) %}
    {% for tab in tabs %}
        {% set count_childs = tab.countChilds() %}
        {% if count_childs > 0 %}
            <li>
                <a href="javascript:void(0)">
                    <i class="{{ tab.icon }}"></i><span>{{ tab.title }}</span>
                </a>
                <ul class="collapse submenu">
                    {% for child in tab.childs %}
                        <li><a href="{{ url.get(['for':child.getRouteName()]) }}">{{ child.title }}</a></li>
                    {% endfor %}
                </ul>
            </li>
        {% else %}
            <li>
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
            <ul class="metismenu" id="left-menu">
                {{ getMenu(tabs) }}
            </ul>
        </nav>
    </div>
</div>