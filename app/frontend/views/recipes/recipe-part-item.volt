<div class="col-12 recipe-part-block">
    <div class="recipe-part-block-1">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6"><label>{{ t._('recipe_part_title') }}</label></div>
                            <div class="col-6 text-right"><p class="remove-recipe-part hovered-red"><i
                                            class="fas fa-trash"></i>&nbsp;{{ t._('remove_recipe_part') }}</p></div>
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="form-group">
                            <select name="recipe_parts[{{ recipe_part.id }}]" class="recipe-part-select"
                                    placeholder="{{ t._('begin_input') }}">
                                {% for part in parts %}
                                    <option value="{{ part.id }}">{{ part.title }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 add-ingredient-block">
                <div class="btn-group">
                    <button class="btn btn-light btn-add-ingredient">{{ t._('add_ingredient') }}<i
                                class="fa fa-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>