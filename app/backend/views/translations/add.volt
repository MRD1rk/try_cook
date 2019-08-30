<div class="row justify-content-center">
    <div class="col-sm-12 col-md-8 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ t._('add-new-translate') }}</h4>
                <div id="translate_add">
                    <form id="translate_add_form" method="post">
                        <input type="hidden" name="is_system" value="0">
                        <div class="form-group">
                            <label>{{ t._('pattern') }}:</label>
                            <input name="pattern" class="form-control">
                        </div>
                        {% for lang in langs %}
                            <div class="form-group">
                                <label>{{ t._(lang.iso_code~'-translate') }}:</label>
                                <input name="value[{{ lang.id }}]" class="form-control translates">
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
