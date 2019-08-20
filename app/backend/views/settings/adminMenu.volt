<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ t._('admin-menu') }}</h4>
                <div id="setting-admin-menu">
                    <ul>
                        <li class="jstree-open">Root
                            <ul>
                                {% for item in menu_items %}
                                    <li>{{ item.title }}
                                    {% if item.childs %}
                                        <ul>
                                            {% for child in item.childs %}
                                                <li>{{ child.title }}</li>
                                            {% endfor %}
                                        </ul>
                                        </li>
                                    {% endif %}
                                {% endfor %}
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>