<h1 class="tc-title">{{ t._('new-recipe') }}</h1>
<div id="content" class="recipes-index">
    <div class="row">
        <div class="col-3">
            <div class="feature-block">
                <div class=>
                    <label class="feature-label">{{ t._('categories') }}:</label>
                    <select class="feature-select"  multiple placeholder="{{ t._('begin_input') }}">
                        <option value=""></option>
                        {% for category in categories %}
                            <option value="{{ category.id }}">{{ category.lang.name }}</option>
                        {% endfor %}
                    </select>
                </div>
            </div>
            {% for feature in features %}
            <div class="feature-block">
                <div class=>
                    <label class="feature-label">{{ t._(feature.lang.value) }}:</label>
                    <select data-id_feature="{{ feature.id }}" class="feature-select"  placeholder="{{ t._('begin_input') }}">
                        <option value=""></option>
                        {% for feature_value in feature.values %}
                            <option value="{{ feature_value.id }}">{{ feature_value.lang.value }}</option>
                        {% endfor %}
                    </select>
                </div>
            </div>
            {% endfor %}
        </div>
        <div class="col-6">test2</div>
        <div class="col-3">test3</div>
    </div>
</div>