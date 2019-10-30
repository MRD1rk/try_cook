<div id="categories-update">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-12 mt-5">
            <div class="card">
                <div class="card-header">
                    {{ AdminSidebarWidget.run('categories',category.id) }}
                </div>
                <div class="card-body">
                    <h4 class="header-title">{{ t._('update_category') }}</h4>
                    <div id="category_add">
                        <form id="category_add_form" method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ t._('active') }}:</label>
                                        <div class="s-swtich">
                                            <input type="hidden" name="main[active]" value="0">
                                            <input name="main[active]" value="1" id="active_{{ category.id }}" {% if category.active %}checked{% endif %} type="checkbox">
                                            <label for="active_{{ category.id }}">{{ t._('toggle') }}</label>
                                        </div>
                                    </div>
                                </div>
                                {% for lang in langs %}
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="title_{{ lang.id }}">{{ t._(lang.iso_code~'_title') }}:</label>
                                            <input name="lang[{{ lang.id }}][title]" id="title_{{ lang.id }}"
                                                   class="form-control title_{{ lang.iso_code }} title-src"
                                                   value="{{ category.getRelated('lang',['conditions':'id_lang='~lang.id]).title|default('')}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="link_rewrite_{{ lang.id }}">{{ t._(lang.iso_code~'_link_rewrite') }}:</label>
                                            <input name="lang[{{ lang.id }}][link_rewrite]" class="form-control"
                                                   id="link_rewrite_{{ lang.id }}"
                                                   value="{{ category.getRelated('lang',['conditions':'id_lang='~lang.id]).link_rewrite|default('')}}">
                                            <a class="generate-link_rewrite"
                                               title="{{ t._('generate_link_rewrite_from_title') }}"
                                               href="#">{{ t._('generate') }}</a>
                                        </div>
                                        <div class="form-group">
                                            <label for="description_{{ lang.id }}">{{ t._(lang.iso_code~'_description') }}:</label>
                                            <textarea rows="4" name="lang[{{ lang.id }}][description]" id="description_{{ lang.id }}"
                                                      class="form-control">
                                                {{ category.getRelated('lang',['conditions':'id_lang='~lang.id]).description|default('')}}
                                            </textarea>
                                        </div>
                                    </div>
                                {% endfor %}
                                <div class="col-12">
                                    <div class="form-group text-center">
                                        <button class="btn btn-lg btn-success">{{ t._('save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>