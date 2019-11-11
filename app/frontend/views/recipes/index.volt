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
            <div class="categories">
                <div class="row">
                    {% for category in categories %}
                        <div class="col-3">
                            <div class="category-item p-2">
                                <a href="{{ url.getCategoryLink(category.id,category.lang.link_rewrite) }}">
                                    <img class="category-item-icon" src="{{ url.getCategoryIconLink(category.id) }}">
                                    <div class="category-title-block">
                                        <span class="category-item-title">{{ category.lang.title }}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    {% endfor %}
                </div>
            </div>
        </div>
    </div>
</div>