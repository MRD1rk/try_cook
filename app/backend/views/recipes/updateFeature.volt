<div id="recipes-updateFeature">
    <div class="row">
        <div class="col-sm-12 col-md-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">{{ recipe.lang.title }}</h4>
                    <form method="post">
                        <table id="features-view" class="table table-bordered table-vcenter">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>{{ t._('feature_name') }}</th>
                                <th>{{ t._('feature_value_name') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            {% for feature in features %}
                                <tr id="{{ feature.id }}" class="feature-value-item">
                                    <td>{{ feature.id }}</td>
                                    <td>{{ feature.lang.value }}</td>
                                    <td>
                                        <select name="features[{{ feature.id }}]" class="feature-select">
                                            <option value=""></option>
                                            {% for feature_value in feature.values %}
                                                <option
                                                        {% if recipe_features[feature_value.id] is defined %}
                                                            selected
                                                        {% endif %}
                                                        value="{{ feature_value.id }}">{{ feature_value.lang.value }}</option>
                                            {% endfor %}
                                        </select>
                                    </td>
                                </tr>
                            {% endfor %}
                            </tbody>
                        </table>
                        <div class="text-center">
                            <button class="btn btn-success">{{ t._('save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>