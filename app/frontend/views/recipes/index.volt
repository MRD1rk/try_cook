<div id="recipes-index">
    <div class="row">
        <div class="col-12">
            {{ BreadCrumbsWidget.run() }}
        </div>
        <div class="col-12">
            <div class="text-center">
                <h1 class="title">{{ t._('recipes') }}</h1>
            </div>
            <div class="text-right">
                <a href="{{ url.get(['for':'recipes-new','iso_code' : iso_code]) }}"
                   class="btn btn-green">{{ t._('add_new_recipe') }}</a>
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