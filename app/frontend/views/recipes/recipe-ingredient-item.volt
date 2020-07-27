<div class="col-12 ingredient-item ingredient-item-{{ recipe_ingredient.position }}"
     data-id_recipe_ingredient="{{ recipe_ingredient.id }}" data-position="{{ recipe_ingredient.position }}">
    <div class="row">
        <div class="col-1 pr-0 draggable" >
            <i class="fas fa-grip-vertical"></i></div>
        <div class="col-5 pl-0">
            <select placeholder="{{ t._('begin_input') }}" class="ingredient-select">
                {% set unit_available = recipe_ingredient.getIngredient() != null ? recipe_ingredient.getIngredient().unit_available: {} %}
                <option data-data='{"unit_available": {{ unit_available|json_encode }},"saved":{{ recipe_ingredient.id_ingredient is defined }} }'
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
                                <option {% if recipe_ingredient.id_unit == unit.id %} selected {% endif %}value="{{ unit.id }}">{{ unit.lang.title }}</option>
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