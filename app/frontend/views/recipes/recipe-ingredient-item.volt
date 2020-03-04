<div class="col-12 ingredient-item ingredient-item-{{ recipe_ingredient.position }}"
     data-id_recipe_ingredient="{{ recipe_ingredient.id }}">
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
                    <div class="hovered-red delete-ingredient"><i class="fas fa-trash fa-2x"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>