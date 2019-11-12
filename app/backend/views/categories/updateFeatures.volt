<div id="categories-update-image" data-id_category="{{ category.id }}">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 mt-5">
            <div class="card">
                <div class="card-header">
                    {{ AdminSidebarWidget.run('categories',category.id) }}
                </div>
                <div class="card-body">
                    <h4 class="header-title text-center">{{ category.lang.title }}</h4>
                    <div id="category_update-image">
                        <label><input id="only-checked" type="checkbox">{{ t._('only_checked') }}</label>
                        <form method="post">
                            <table id="category-filters-table" class="table table-bordered table-hover js-sort-table">
                                <thead>
                                <tr>
                                    <th class="js-sort-number">{{ t._('selected') }}</th>
                                    <th>{{ t._('filter_title') }}</th>
                                    <th>{{ t._('position') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for feature in features %}
                                    {% set checked  = '' %}
                                    {% set checked_first = 0 %}
                                    {% if category_features[feature.id] is defined %}
                                        {% set checked = 'checked' %}
                                        {% set checked_first = 1 %}
                                    {% endif %}
                                    <tr id="{{ feature.id }}">
                                        <td>
                                            <span class="hidden">{{ checked_first }}</span>
                                            <input type="checkbox"
                                                   name="category_filters[{{ feature.id }}][id_feature]"
                                                   id="id_feature-{{ feature.id }}"
                                                   value="{{ feature.id }}" {{ checked }}
                                                   class="category-filter-checkbox">
                                        </td>
                                        <td><span>{{ feature.lang.value }}</span></td>
                                        <td class="text-center"><input type="hidden"
                                                                       class="{% if checked_first %}position{% endif %}"

                                                                       value="{% if category_filters[feature.id] is defined %}{{ category_filters[feature.id].position }}{% endif %}">
                                            {% if checked_first %}<i class="ti-move drugHandler">
                                            </i>
                                            {% endif %}
                                        </td>
                                    </tr>
                                {% endfor %}
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button class="btn btn-success" type="submit">{{ t._('save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>