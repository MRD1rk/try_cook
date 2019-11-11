<div id="categories-update-image">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 mt-5">
            <div class="card">
                <div class="card-header">
                    {{ AdminSidebarWidget.run('categories',category.id) }}
                </div>
                <div class="card-body">
                    <h4 class="header-title text-center">{{ category.lang.title }}</h4>
                    <div id="category_update-image">
                        <form method="post">
                            <table id="category-filters-table" class="table table-bordered table-hover js-sort-table">
                                <thead>
                                <tr>
                                    <th class="js-sort-number">Выбрано</th>
                                    <th>Название фильтра</th>
                                    <th>Позиция</th>
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
                                    <tr>
                                        <td>
                                            <span class="hidden">{{ checked_first }}</span>
                                            <input type="checkbox"
                                                   name="category_filters[{{ feature.id }}][id_feature]"
                                                   id="id_feature-{{ feature.id }}"
                                                   value="{{ feature.id }}" {{ checked }}
                                                   class="category-filter">
                                        </td>
                                        <td><span>{{ feature.lang.value }}</span></td>
                                        <td class="text-center"><input type="hidden" class="position"
                                                                       name="category_filters[{{ feature.id }}][position]"
                                                                       value="{%  if category_filters[feature.id] is defined  %}{{ category_filters[feature.id].position }}{% endif %}">
                                            {% if checked_first %}<i class="ti-move drugHandler">
                                            </i>
                                            {% endif %}
                                        </td>
                                    </tr>
                                {% endfor %}
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button class="btn btn-success" type="submit">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>