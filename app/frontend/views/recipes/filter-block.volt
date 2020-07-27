<div id="filter-block">
    <div class="filters-items">
        {% if categories is defined %}
            <div class="filter-item">
                <div class="filter-item-title">
                    <label>{{ t._('post_in_category') }}</label>
                </div>
                <div class="filter-item-values category">
                    {% for category in categories %}
                        <div class="filter-item-value {% if loop.index > 5 %}marked visible-hidden hide{% endif %}">
                            <div class="filter-item-value">
                                <div class="custom-control custom-radio">
                                    <input type="radio" data-type="category" name="id_category"
                                           data-keep="true"
                                           class="custom-control-input"
                                           value="{{ category.getId() }}"
                                           id="category-check-{{ category.id }}">
                                    <label class="custom-control-label"
                                           for="category-check-{{ category.id }}">{{ category.lang.title }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    {% endfor %}
                </div>
                {% if categories|length > 3 %}
                    <div class="show-all-filter">
                        <div class="text-center">
                            <i class="fas fa-angle-double-down"></i>
                        </div>
                    </div>
                {% endif %}
            </div>
        {% endif %}
        {% if features is defined %}
            {% for feature in features %}
                <div class="filter-item">
                    <div class="filter-item-title">
                        <label>{{ feature['value'] }}</label>
                    </div>
                    <div class="filter-item-values{% if feature['id_feature'] ==  1 %} nationality{% endif %}">
                        {% for feature_value in feature['feature_values'] %}
                            <div class="filter-item-value {% if loop.index > 3 %}marked visible-hidden hide{% endif %}">
                                <div class="custom-control custom-radio">
{#                                    <input type="radio" class="custom-control-input" name="features[{{ feature['id_feature'] }}][{{ feature_value['id_feature_value'] }}]"#}
                                    <input type="radio" class="custom-control-input" name="features[{{ feature['id_feature'] }}]"
                                           data-keep="true"
                                           data-id_feature="{{ feature['id_feature'] }}"
                                           value="{{ feature_value['id_feature_value'] }}"
                                           id="feature-check-{{ feature_value['id_feature_value'] }}">
                                    <label class="custom-control-label"
                                           for="feature-check-{{ feature_value['id_feature_value'] }}">{{ feature_value['value'] }}
                                    </label>
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                    {% if feature['feature_values']|length > 3 %}
                        <div class="show-all-filter">
                            <div class="text-center">
                                <i class="fas fa-angle-double-down"></i>
                            </div>
                        </div>
                    {% endif %}
                </div>
            {% endfor %}
        {% endif %}
    </div>
</div>