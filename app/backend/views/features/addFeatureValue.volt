<div class="row justify-content-center">
    <div class="col-sm-12 col-md-8 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ t._('add_new_feature_value') }}</h4>
                <div id="feature_add">
                    <form id="feature_add_form" method="post">
                        {% for lang in langs %}
                            <div class="form-group">
                                <label>{{ t._(lang.iso_code~'_translation') }}:</label>
                                <input name="value[{{ lang.id }}]" class="form-control feature">
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
