<h1 class="tc-title">{{ t._('new_recipe') }}</h1>
<div id="content" class="recipes-add">
    <div class="row">
        <div class="col-2">
            <div class="sticky-top">
                {{ partial('recipes/filter-block',['categories':categories]) }}
            </div>
        </div>
        <div class="col-8">
            <div class="row recipe-block justify-content-between">
                <div class="col-12 recipe-block-item">
                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <input name="recipe_title" id="recipe_title" class="form-control"
                                       data-keep="true"
                                       placeholder="{{ t._('enter_recipe_title') }}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                {% set preview_url = url.getRecipeImage(cover.getId()) %}
                                <div class="preview-image-block {% if (preview_url is empty) %}not-image {% endif %}">
                                    <label class="add-recipe-preview-img" for="recipe_image"
                                           style="background-image: url('{{ preview_url }}');">
                                        <span title="{{ t._('upload_img') }}">{{ t._('upload_img') }}</span>
                                    </label>
                                    <input id="recipe_image" type="file">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="recipe_description">{{ t._('add_description') }}</label>
                                <textarea data-keep="true" class="form-control" id="recipe_description"></textarea>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>
                                    <i class="far fa-clock fa-2x"></i>
                                    {{ t._('cooking_time') }}
                                </label>
                                <div class="row">
                                    <div class="col-5 pr-0">
                                        <div class="row">
                                            <div class="col-6">
                                                <input name="recipe_cooking_hours" id="recipe_cooking_hours"
                                                       data-keep="true"
                                                       class="form-control">
                                            </div>
                                            <div class="col-6 p-0"><span class="align-middle">{{ t._('hours') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5 pr-0">
                                        <div class="row">
                                            <div class="col-6">
                                                <input name="recipe_cooking_minutes" id="recipe_cooking_minutes"
                                                       data-keep="true"
                                                       class="form-control">
                                            </div>
                                            <div class="col-6 p-0"><span class="align-middle">{{ t._('minuts') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>
                                    <i class="fas fa-user-friends fa-2x"></i>
                                    {{ t._('person_count') }}
                                </label>
                                <div class="row">
                                    <div class="col-9">
                                        <input name="recipe_person_count" id="recipe_person_count"
                                               data-keep="true"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row prepare-time">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="need_prepare" value="1"
                                               data-keep="true"
                                               name="need_prepare">
                                        <label class="custom-control-label"
                                               for="need_prepare">{{ t._('need_prepare') }}</label>
                                        <small class="form-text text-muted">Время на подготовку блюда</small>
                                    </div>
                                </div>
                                <div class="col-6 prepare-time-block">
                                    <div class="form-group">
                                        <label>
                                            <i class="far fa-clock fa-2x"></i>
                                            {{ t._('prepare_time') }}
                                        </label>
                                        <div class="row">
                                            <div class="col-5 pr-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <input name="recipe_prepare_hours" id="recipe_prepare_hours"
                                                               data-keep="true"
                                                               class="form-control">
                                                    </div>
                                                    <div class="col-6 p-0"><span
                                                                class="align-middle">{{ t._('hours') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5 pr-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <input name="recipe_prepare_minutes" id="recipe_prepare_minutes"
                                                               data-keep="true"
                                                               class="form-control">
                                                    </div>
                                                    <div class="col-6 p-0"><span
                                                                class="align-middle">{{ t._('minuts') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row justify-content-end">
                        <div class="col-6">
                            <p class="text-right hovered-red add-recipe-part"><i
                                        class="far fa-list-alt"></i>&nbsp;{{ t._('add_recipe_part') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 recipe-part-block p-0">
                    {% for recipe_part in recipe_parts %}
                        {{ partial('recipes/recipe-part-item',['recipe_part':recipe_part]) }}
                    {% endfor %}
                </div>
                <div class="col-12 recipe-block-item">
                    <div class="steps-block">{% for step in recipe.getSteps() %}{{ partial('recipes/recipe-step-item',['step':step]) }}{% endfor %}</div>
                    <div class="mt-2">
                        <div class="w100">
                            <div class="text-center">

                                <button id="add_recipe_step"
                                        class="btn btn-default hovered-red border-dark">{{ t._('add_step') }}</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!--right block-->
        <div class="col-2">
            <div class="sticky-top">
                <div class="row recipe-button-block  justify-content-between">
                    <div class="col-12">
                        <div class="text-center">
                            <button id="save-recipe" class="btn btn-success">{{ t._('save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>