<div class="recipe-block-item recipe-part-item recipe-part-item-{{ recipe_part.position }}"
     data-id_recipe_part="{{ recipe_part.id }}">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-8">
                    <select data-id_recipe_part="{{ recipe_part.id }}"
                            name="recipe_parts[{{ recipe_part.id }}]"
                            class="recipe-part-select"
                            placeholder="{{ t._('recipe_part_title') }}">
                        <option value=""></option>
                        {% for part in parts %}
                            <option {% if recipe_part.id_part == part.id %} selected{% endif %}
                                    value="{{ part.id }}">{{ part.title }}</option>
                        {% endfor %}
                    </select>
                </div>
                <div class="col-4 align-self-center">
                    <p class="remove-recipe-part hovered-red text-right"><i
                                class="fas fa-trash"></i>&nbsp;{{ t._('remove_recipe_part') }}</p>
                </div>
            </div>
        </div>
        <div class="col-12 ingredient-block">
            <div class="row">
                <div class="col-12">
                    <p class="text-center">Список ингридиентов</p>
                </div>
            {% for ingredient in recipe_part.getIngredients() %}
                {{ partial('recipes/recipe-ingredient-item',['recipe_ingredient':ingredient]) }}
            {% endfor %}
            </div>
            <div class="text-center add-ingredient-block">

                <p class="text-center hovered-red btn-add-ingredient"><i
                            class="fa fa-plus"></i>&nbsp;{{ t._('add_ingredient') }}</p>
            </div>
        </div>
    </div>
</div>
