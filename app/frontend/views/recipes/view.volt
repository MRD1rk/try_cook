<div class="recipes-view">
    <div class="row justify-content-center">
        <div class="col-12">
            {{ BreadCrumbsWidget.run() }}
        </div>
        <div class="col-6">
            <div id="recipe_block_1" class="text-center">
                <div class="row">
                    <div class="col-12">
                        <h1 class="title">{{ recipe.getLang().getTitle() }}</h1>
                    </div>
                    <div class="col-10 offset-1">
                        <div class="row justify-content-center recipe_info_block">
                            <div class="col-2">
                                <div class="recipe_info">
                                    <img src="/img/icons/cook.svg">
                                    <span>2 порции</span>
                                </div>
                            </div>
                            <div class="col-2 border-right">
                                <div class="recipe_info">
                                    <img src="/img/icons/clock.svg">
                                    <span>30 мин</span>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="recipe_info">
                                    <img src="/img/icons/heart.svg">
                                    <span>125</span>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="recipe_info">
                                    <img src="/img/icons/eye.svg">
                                    <span>451</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div id="recipe_block_2">
                <div class="row">
                    <div class="col-6">
                        <div class="recipe_image_block">

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="recipe_description_block">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>