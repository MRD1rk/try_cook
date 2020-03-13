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
                <div class="col-5">
                    <input placeholder="{{ t._('weight') }}" class="weight-input form-control">
                </div>

                <div class="col-5">
                    <select class="unit-select">
                        {% if recipe_ingredient.getIngredient() %}
                            {% for unit in recipe_ingredient.getIngredient().getUnits() %}
                                <option value="{{ unit.id }}">{{ unit.lang.title }}</option>
                            {% endfor %}
                        {% endif %}
                    </select>
                </div>
                <div class="col-2">
                    <div class="hovered-red delete-ingredient"><i class="fas fa-trash fa-2x"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>