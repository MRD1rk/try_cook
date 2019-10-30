<div id="categories-add">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">{{ t._('add-new-category') }}</h4>
                    <div id="category_add">
                        <form id="category_add_form" method="post">
                            {% for lang in langs %}
                                <div class="form-group">
                                    <label>{{ t._(lang.iso_code~'_translation') }}:</label>
                                    <input name="title[{{ lang.id }}]" class="form-control category">
                                </div>
                            {% endfor %}
                            <div class="form-group text-center">
                                <button class="btn btn-lg btn-success">{{ t._('save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>