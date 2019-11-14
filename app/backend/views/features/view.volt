<div class="row">
    <div class="col-sm-12 col-md-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ t._(feature.lang.value) }}</h4>
                <div class="float-left">
                    <a href="{{ url.get(['for':'admin-features-index']) }}" class="btn btn-primary">{{ t._('back') }}</a>
                </div>
                <div class="text-center mb-3">
                    <a class="btn btn-success"
                       href="{{ url.get(['for':'admin-features-add-value','id_feature':feature.id]) }}">{{ t._('add-feature-value') }}</a>
                </div>
                <table id="features-view" class="table table-bordered table-vcenter">
                    <thead>
                    <tr>
                        <th>Id</th>
                        {% for lang in langs %}
                            <th>{{ t._(lang.iso_code~'-translation') }}</th>
                        {% endfor %}
                        <th>{{ t._('is_active') }}</th>
                        <th>{{ t._('position') }}</th>
                        <th>{{ t._('control') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for feature_value in feature.values %}
                        <tr id="{{ feature_value.id }}" class="feature-value-item">
                            <td>{{ feature_value.id }}</td>
                            {% for lang in langs %}
                                <td>
                                    <span>{{ feature_value.getLang(['id_lang='~lang.id])?feature_value.getLang(['id_lang='~lang.id]).getValue():'' }}</span>
                                </td>
                            {% endfor %}
                            <td class="text-center">
                                <div class="s-swtich">
                                    <input onchange="updateFeatureValueActive($(this))" data-id_feature_value="{{ feature_value.id }}" {% if feature_value.active %}checked{% endif %} type="checkbox" id="active-{{ feature_value.id }}" class="update-active">
                                    <label for="active-{{ feature_value.id }}">{{ t._('toggle') }}</label>
                                </div>
                            </td>
                            <td class="text-center"><input type="hidden" class="position" value="{{ feature.position }}"><i class="ti-move drugHandler"></i></td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ url.get(['for':'admin-features-update-value','id_feature_value':feature_value.id]) }}"
                                       class="btn btn-secondary">{{ t._('update') }}</a>
                                    <button type="button"
                                            class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="{{ url.get(['for':'admin-features-delete-value','id_feature_value':feature_value.id]) }}">{{ t._('delete') }}</a>
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