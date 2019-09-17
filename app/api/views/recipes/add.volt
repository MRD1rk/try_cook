<h1 class="tc-title">{{ t._('new-recipe') }}</h1>
<div id="content" class="recipes-index">
    <div class="row">
        <div class="col-3">
            <div class="feature-block">
                <div class=>
                    <label class="feature-label">{{ t._('categories') }}:</label>
                    <select id="category" name="category" class="feature-select" placeholder="{{ t._('begin_input') }}">
                        <option value=""></option>
                        {% for category in categories %}
                            <option value="{{ category.id }}">{{ category.lang.name }}</option>
                        {% endfor %}
                    </select>
                </div>
            </div>
            {% for feature in features %}
                <div class="feature-block">
                    <div class=>
                        <label class="feature-label">{{ t._(feature.lang.value) }}:</label>
                        <select name="features[{{ feature.id }}]" data-id_feature="{{ feature.id }}"
                                class="feature-select" placeholder="{{ t._('begin_input') }}">
                            <option value=""></option>
                            {% for feature_value in feature.values %}
                                <option name="features[{{ feature.id }}][{{ feature_value.id }}]"
                                        value="{{ feature_value.id }}">{{ feature_value.lang.value }}</option>
                            {% endfor %}
                        </select>
                    </div>
                </div>
            {% endfor %}
        </div>
        <div class="col-6">
            <div class="row justify-content-between">
                <div class="col-12">
                    <div class="form-group">
                        <input name="recipe_name" class="form-control" placeholder="{{ t._('enter_recipe_name') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <div class="preview-image">
                            <label class="add-recipe-preview-img" for="recipe_image">
                                <span title="{{ t._('upload_img') }}">{{ t._('upload_img') }}</span>
                            </label>
                            <input id="recipe_image" type="file">
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="recipe_description">{{ t._('add-description') }}</label>
                        <textarea class="form-control" id="recipe_description"></textarea>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>{{ t._('cooking_time') }}</label>
                        <div class="row">
                            <div class="col-2">
                                <i class="far fa-clock fa-2x"></i>
                            </div>
                            <div class="col-5 pr-0">
                                <div class="row">
                                    <div class="col-6">
                                        <input name="recipe_cooking_hour" class="form-control">
                                    </div>
                                    <div class="col-6 p-0"><span class="align-middle">{{ t._('hours') }}</span></div>
                                </div>
                            </div>
                            <div class="col-5 pr-0">
                                <div class="row">
                                    <div class="col-6">
                                        <input name="recipe_cooking_minute" class="form-control">
                                    </div>
                                    <div class="col-6 p-0"><span class="align-middle">{{ t._('minuts') }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-group">
                        <label>{{ t._('person_count') }}</label>
                        <div class="row">
                            <div class="col-3">
                                <i class="fas fa-user-friends fa-2x"></i>
                            </div>
                            <div class="col-9">
                                <input name="recipe_person_count" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row prepare-time">
                        <div class="col-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="need_prepare">
                                <label class="custom-control-label" for="need_prepare">{{ t._('need_prepare') }}</label>
                            </div>
                        </div>
                        <div class="col-6 prepare-time-block">
                            <div class="form-group">
                                <div class="text-center">
                                    <label>{{ t._('prepare_time') }}</label>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <i class="far fa-clock fa-2x"></i>
                                    </div>
                                    <div class="col-5 pr-0">
                                        <div class="row">
                                            <div class="col-6">
                                                <input name="recipe_cooking_hour" class="form-control">
                                            </div>
                                            <div class="col-6 p-0"><span class="align-middle">{{ t._('hours') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5 pr-0">
                                        <div class="row">
                                            <div class="col-6">
                                                <input name="recipe_cooking_minute" class="form-control">
                                            </div>
                                            <div class="col-6 p-0"><span class="align-middle">{{ t._('minuts') }}</span>
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
                            <p class="text-right hovered-red add-recipe-part">{{ t._('add_recipe_part') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 parts"></div>
{#                <div class="col-12 recipe-part-block">#}
{#                    <div class="row">#}
{#                        <div class="col-12">#}
{#                            <div class="row">#}
{#                                <div class="col-6">#}
{#                                    <div class="form-group">#}
{#                                        <select id="recipe_part" name="recipe_part[id]" class="recipe-part-select"#}
{#                                                placeholder="{{ t._('begin_input') }}">#}
{#                                            <option value=""></option>#}
{#                                            <option>Основное</option>#}
{#                                            <option>Заправка</option>#}
{#                                            <option>Крем</option>#}
{#                                        </select>#}
{#                                    </div>#}
{#                                </div>#}
{#                            </div>#}
{#                        </div>#}
{#                        <div class="col-6">#}
{#                            <p class="input-rounded form-control text-left">{{ t._('add_ingredient') }}<i#}
{#                                        class="fa fa-plus"></i></p>#}
{#                        </div>#}
{#                        <div class="col-12">#}
{#                            <div class="ingredient-item">#}
{#                                <div class="row">#}
{#                                    <div class="col-6">#}
{#                                        <select class="ingredient-select">#}
{#                                            <option value="">{{ t._('begin_input') }}</option>#}
{#                                            <option value="2">Рис</option>#}
{#                                            <option value="3">Ананас</option>#}
{#                                            <option value="4">Авокадо</option>#}
{#                                        </select>#}
{#                                    </div>#}
{#                                    <div class="col-6">#}
{#                                        <div class="row">#}
{#                                            <div class="col-5">#}
{#                                                <input placeholder="{{ t._('weight') }}" class="form-control">#}
{#                                            </div>#}
{#                                            <div class="col-5">#}
{#                                                <select class="unit-select">#}
{#                                                    <option value="">...</option>#}
{#                                                    <option value="1">шт</option>#}
{#                                                    <option value="2">кг</option>#}
{#                                                    <option value="3">пучек</option>#}
{#                                                </select>#}
{#                                            </div>#}
{#                                            <div class="col-2">#}
{#                                                <div class="delete-ingredient"><i class="fas fa-trash fa-2x"></i></div>#}
{#                                            </div>#}
{#                                        </div>#}
{#                                    </div>#}
{#                                </div>#}
{#                            </div>#}
{#                        </div>#}
{#                    </div>#}

{#                </div>#}
            </div>
        </div>
        <div class="col-3">test3</div>
    </div>
</div>