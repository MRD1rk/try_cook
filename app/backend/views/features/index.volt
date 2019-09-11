<div class="row">
    <div class="col-sm-12 col-md-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ t._('features') }}</h4>
                <div class="text-center">
                    <a class="btn btn-success"
                       href="{{ url.get(['for':'admin-features-add']) }}">{{ t._('add-feature') }}</a>
                </div>
                <table class="table table-hover table-bordered table-vcenter">
                    <thead>
                    <tr>
                        <th>Id</th>
                        {% for lang in langs %}
                            <th>{{ t._(lang.iso_code~'-translation') }}</th>
                        {% endfor %}
                        <th>{{ t._('is_active') }}</th>
                        <th>{{ t._('control') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for feature in features %}
                        <tr class="translation-item">
                            <td>{{ feature.id }}</td>
                            {% for lang in langs %}
                                <td>
                                    <span>{{ feature.getLang(['id_lang='~lang.id])?feature.getLang(['id_lang='~lang.id]).getValue():'' }}</span>
                                </td>
                            {% endfor %}
                            <td class="text-center">
                                <div class="s-swtich">
                                    <input data-id="{{ feature.id }}" {% if feature.active %}checked{% endif %} type="checkbox" id="active-{{ feature.id }}" class="update-active">
                                    <label for="active-{{ feature.id }}">{{ t._('toggle') }}</label>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ url.get(['for':'admin-features-view','id':feature.id]) }}"
                                       class="btn btn-secondary">{{ t._('view') }}</a>
                                    <button type="button"
                                            class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="{{ url.get(['for':'admin-features-update','id':feature.id]) }}">{{ t._('update') }}</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="{{ url.get(['for':'admin-features-delete','id':feature.id]) }}">{{ t._('delete') }}</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>