<div class="col-12 ingredient-item ingredient-item-{{ recipe_ingredient.position }}"
     data-id_recipe_ingredient="{{ recipe_ingredient.id }}">
    <div class="row">
        <div class="col-6">
            <select placeholder="{{ t._('begin_input') }}" class="ingredient-select">
                <option data-data='{"unit_available": {{ recipe_ingredient.getIngredient() ? recipe_ingredient.getIngredient().unit_available|json_encode:{} }},"get_unit":{{ recipe_ingredient.id_ingredient|default(false) }}}'
                        value="{{ recipe_ingredient.id_ingredient }}">{{ recipe_ingredient.getIngredient().lang.title|default('') }}</option>
            </select>
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-3 p-0">
                    <input placeholder="{{ t._('weight') }}" {% if recipe_ingredient.count %} value="{{ recipe_ingredient.count }}" {% else %} disabled{% endif %}
                           class="weight-input form-control">
                </div>
                <div class="col-7">
                    <select placeholder="{{ t._('begin_input') }}" class="unit-select">
                        <option value=""></option>
                        {% if recipe_ingredient.getIngredient() %}
                            {% for unit in recipe_ingredient.getIngredient().getUnits() %}
                                <option value="{{ unit.id }}">{{ unit.lang.title }}</option>
                            {% endfor %}
                        {% endif %}
                    </select>
                </div>
                <div class="col-2">
                    <div class="hovered-red delete-ingredient"><i class="fas fa-trash"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>