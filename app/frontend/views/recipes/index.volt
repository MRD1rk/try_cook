<div id="recipes-index">
    <div class="row">
        <div class="col-12">
            {{ BreadCrumbsWidget.run() }}
        </div>
        <div class="col-12">
            <div class="text-center">
                <h1 class="category-title">{{ t._('recipes') }}</h1>
            </div>
        </div>
        <div class="col-12">
            <div class="recipe-search-block">
                <form class="form-inline">
                    <label class="sr-only" for="recipe_search_input">{{ t._('search_by_title') }}</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-search"></i> </div>
                        </div>
                        <input type="text" class="form-control" id="recipe_search_input" placeholder="{{ t._('search_by_title') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>