<div class="recipe-part-item recipe-part-item-{{ recipe_part.position }}" data-id_recipe_part="{{ recipe_part.id }}">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-6"><label>{{ t._('recipe_part_title') }}</label></div>
                        <div class="col-6 text-right">
                            <p class="remove-recipe-part hovered-red"><i
                                        class="fas fa-trash"></i>&nbsp;{{ t._('remove_recipe_part') }}</p></div>
                    </div>
                </div>
                <div class="col-10">
                    <div class="form-group">
                        <select data-id_recipe_part="{{ recipe_part.id }}" name="recipe_parts[{{ recipe_part.id }}]"
                                class="recipe-part-select"
                                placeholder="{{ t._('begin_input') }}">
                            <option></option>
                            {% for part in parts %}
                                <option value="{{ part.id }}">{{ part.title }}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
            </div>
        </div>
        {% if ingredients is defined %}
            {% for ingredient in ingredients %}
                <div class="col-12 ingredient-item ingredient-item-1">
                    <div>
                        <div class="row">
                            <div class="col-6">
                                <select placeholder="{{ t._('begin_input') }}" class="ingredient-select">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-5">
                                        <input placeholder="{{ t._('weight') }}" class="weight-input form-control">
                                    </div>
                                    <div class="col-5">
                                        <select class="unit-select">
                                            <option value="">...</option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <div class="hovered-red delete-ingredient"><i class="fas fa-trash fa-2x"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {% endfor %}
        {% endif %}
        <div class="col-6 add-ingredient-block">
            <div class="btn-group">
                <button class="btn btn-light btn-add-ingredient">{{ t._('add_ingredient') }}<i
                            class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
</div>
