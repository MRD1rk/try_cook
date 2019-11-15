<h1 class="tc-title">{{ t._('new-recipe') }}</h1>
<div id="content" class="recipes-index">
    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-8">
            <div class="recipe-block row justify-content-between">
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
            </div>
            </div>
        </div>
    </div>
</div>