<h1 class="tc-title">{{ t._('new-recipe') }}</h1>
<div id="content" class="recipes-index">
    <div class="row">
        <div class="col-3">
            <div class="feature-block">
                <div class=>
                    <label class="feature-label">{{ t._('categories') }}:</label>
                    <select id="category" name="category" class="feature-select" placeholder="{{ t._('begin_input') }}">
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
                    <select name="features[{{ feature.id }}]" data-id_feature="{{ feature.id }}" class="feature-select" placeholder="{{ t._('begin_input') }}">
                        <option value=""></option>
                        {% for feature_value in feature.values %}
                            <option name="features[{{ feature.id }}][{{ feature_value.id }}]" value="{{ feature_value.id }}">{{ feature_value.lang.value }}</option>
                        {% endfor %}
                    </select>
                </div>
            </div>
            {% endfor %}
        </div>
        <div class="col-6"><button class="btn btn-success submit">Save</button> </div>
        <div class="col-3">test3</div>
    </div>
</div>