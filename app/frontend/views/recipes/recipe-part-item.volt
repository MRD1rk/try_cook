<div class="recipe-block-item recipe-part-item recipe-part-item-{{ recipe_part.position }}"
     data-id_recipe_part="{{ recipe_part.id }}"
     data-position="{{ recipe_part.position }}">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-1 pr-0 draggable" title="{{ t._('change_part_position') }}">
                    <i class="fas fa-grip-vertical"></i>
                </div>
                <div class="col-7 p-0">
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
                    <p class="text-center">{{ t._('ingredients_list') }}</p>
                </div>
                <div class="col-12">
                    <div class="row ingredient-items">
                        {% for ingredient in recipe_part.getIngredients() %}
                            {{ partial('recipes/recipe-ingredient-item',['recipe_ingredient':ingredient]) }}
                        {% endfor %}
                    </div>
                </div>
            </div>
            <div class="text-center add-ingredient-block">
                <p class="text-center hovered-red btn-add-ingredient">
                    <i class="fa fa-plus"></i>&nbsp;{{ t._('add_ingredient') }}
                </p>
            </div>
        </div>
    </div>
</div>
