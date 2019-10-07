<div class="index-index">
    <div class="main-banner"></div>
    <div class="row">
        <div class="col-md-6">
            <div class="about-us-img">

            </div>
        </div>
        <div class="col-md-6">
            <div class="about-us-block">
                <h2 class="custom-title">{{ t._('about_us') }}</h2>
                <div class="about-us-text">
                    <p>Наш портал — не просто место, где собраны рецепты</p>
                    <p> блюд со всего мира, которые под силу приготовить не</p>
                    <p>только профессионалам, но каждой фото или видео.</p>
                    <p>«Едим Дома» — настоящая социальная где кипит</p>
                    <p>живое общение:делятся своими секретами, благодаря</p>
                    <p>чему простые домохозяйки внастоящих шеф-поваров. </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="border-top"></div>
        <div class="popular-block">
            <h2 class="custom-title">{{ t._('popular') }}</h2>
            <p>{{ t._('most_popular_recipes') }}</p>
            {{ PopularRecipesWidget.run() }}
        </div>
    </div>
    <div id="new-items">
        <div class="container">
            <h2 class="custom-title">{{ t._('new_items') }}</h2>
            <div class="new-items-big">
                <div class="row">
                    <div class="col-8 p-0">
                        <img src="/img/new_items_big.png">
                    </div>
                    <div class="col-4 p-0">
                        <div class="new-big-item p-2">
                            <h3 class="recipe-title">Салат с курицей в азиатском стиле</h3>
                            <p class="recipe-short-description pt-3">Куриное филе нарезать пооой,
                                добавить 2 столовые ложки соевого
                                соуса и чайную ложку кунжутного масла.
                                Перемешать, чтобы все куски курицы
                                оказалисьв панировке Куриное филе
                                нарезать соломкой, посыпать ...
                            </p>
                                <a class="btn-tc" href="#">{{ t._('forward') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>