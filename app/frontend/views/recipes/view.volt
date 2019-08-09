<div class="recipes-view">
    <div class="row">
        <div class="recipe-header">
            <h2>{{ recipe.lang.title }}</h2>
        </div>
        <div class="media-block">
            <img class="img-fluid" src="https://e2.edimdoma.ru/data/recipes/0012/9638/129638-ed4_wide.jpg?1565272039">
        </div>
        <div class="author-block">
            {{ recipe.user.getFullName() }}
        </div>
    </div>
</div>