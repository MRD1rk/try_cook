<div id="recipes">
    <div class="row">
        {% for recipe in recipes %}
            <div class="col-3">
                <div class="recipe-item">
                    <div class="recipe-preview-img-block">
                        <a class="recipe-link" href="#">
                            <img src="{{ url.getRecipeImage(recipe.id) }}">
                        </a>
                    </div>
                    <div class="recipe-meta-block">
                        <div class="recipe-title">
                            <label>{{ recipe.title }}</label>
                        </div>
                        <div class="recipe-short-description">
                            <span>{{ recipe.description }}</span>
                        </div>
                    </div>
                    <div class="recipe-author-block">
                        <a class="author-link" href="#">
                            <div class="author-avatar float-left">
                                <img src="/img/no_photo.png">
                            </div>
                            <div class="author-block">
                                <div class="author-name">{{ recipe.author.getFullName() }}</div>
                                <div class="recipe-post-time">{{ recipe.date_add }}</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        {% endfor %}
    </div>
</div>