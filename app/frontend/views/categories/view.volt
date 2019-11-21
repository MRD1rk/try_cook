<div id="categories-view">
    <div class="row">
        <div class="col-12">
            {{ BreadCrumbsWidget.run() }}
        </div>
        <div class="col-12">
            <div class="text-center">
                <h1 class="category-title">{{ t._(category.lang.title) }}</h1>
            </div>
        </div>
        <div class="offset-2 col-10">
            <div id="selected-filters">
            </div>
        </div>
        <div class="col-2">
            {{ FilterWidget.run('desktop',category,features,total_count) }}
        </div>
        <div class="col-10">
            {{ RecipeListWidget.run('categories-view',recipes) }}
        </div>
    </div>
</div>