<div class="row justify-content-center">
    <div class="col-sm-12 col-md-8 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ t._('add-new-translation') }}</h4>
                <p class="border-bottom alert-danger p-2">{{ t._('all_separators_will_be_replaced') }}</p>
                <div id="translation_add">
                    <form id="translation_add_form" method="post">
                        <div class="form-group">
                            <label>{{ t._('pattern') }}:</label>
                            <input name="pattern" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{ t._('category') }}:</label>
                            <input name="category" class="form-control">
                        </div>
                        {% for lang in langs %}
                            <div class="form-group">
                                <label>{{ t._(lang.iso_code~'_translation') }}:</label>
                                <input name="value[{{ lang.id }}]" class="form-control translation">
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
