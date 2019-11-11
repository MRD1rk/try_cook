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
        <div class="col-4">
            {{ FilterWidget.run() }}
        </div>
    </div>
</div>