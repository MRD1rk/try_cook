<div class="sticky-top">
    <div class="recipe-block recipe-right-block justify-content-between text-center">
        <div class="row">
            <div class="col-12 recipe-block-item">
                <label>Если вы впервые у нас на сайте - ознакомьтесь с инструкцией!</label>
                <a href="#" class="btn btn-success">Инструкция</a>
            </div>
            <div class="col-12 recipe-block-item">
                <div class="preview-button-block">
                    <div class="s-swtich">
                        <input type="checkbox" id="recipe-preview">
                        <label for="recipe-preview"></label>
                        <span>Предварительный просмотр</span>
                    </div>
                </div>
                <hr>
                <div class="draft-recipe">
                    <button id="save_recipe_to_draft" class="btn btn-light border-dark m-3">{{ t._('to_draft') }}</button>
                    <label>Если Вы не готовы выложить рецепт, хотите его дополнить позже, сохраните черновик.</label>
                </div>
            </div>
            <div class="col-12 recipe-block-item">
                <button id="save-recipe" class="btn btn-light border-dark m-3">{{ t._('publish') }}</button>
                <label>Рецепт будет опубликован после прохождения модерации</label>
            </div>
        </div>
    </div>
</div>