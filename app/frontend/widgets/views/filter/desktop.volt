<div id="filter-block"  data-id_category="{{ id_category }}">
    <div class="filter-title-block">
        <h2 class="filter-head">{{ t._('total_recipes') }} {{ total_recipes }}</h2>
    </div>
    <div class="filters-items">
        {% for feature in features %}
            <div class="filter-item">
                <div class="filter-item-title">
                    <span>{{ feature['value'] }}</span>
                </div>
                <div class="filter-item-values">
                    {% for feature_value in feature['feature_values'] %}
                        <div class="filter-item-value">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" {% if feature_value['disabled']%} disabled {% endif %}
                                       value="{{ feature['id_feature'] }}_{{ feature_value['id_feature_value'] }}"
                                       id="feature-check-{{ feature_value['id_feature_value'] }}" {% if selected_features[feature_value['id_feature_value']] is defined %}
                                checked{% endif %}>
                                <label class="custom-control-label"
                                       for="feature-check-{{ feature_value['id_feature_value'] }}">{{ feature_value['value'] }}
                                    ({{ feature_value['count'] }})</label>
                            </div>
                        </div>
                    {% endfor %}
                </div>
            </div>
        {% endfor %}
    </div>
</div>