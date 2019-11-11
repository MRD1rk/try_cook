<div class="row">
    <div class="col-sm-12 col-md-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ t._('translations') }}</h4>
                <div class="text-center mb-3">
                    <a class="btn btn-success"
                       href="{{ url.get(['for':'admin-translations-add']) }}">{{ t._('translations_add') }}</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ t._('pattern') }}</th>
                            {% for lang in langs %}
                                <th>{{ t._(lang.iso_code~'_translation') }}</th>
                            {% endfor %}
                            <th>{{ t._('control') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for translation in translations %}
                            <tr class=" translation-item">
                                <td>{{ translation.pattern }}</td>
                                {% for lang in langs %}
                                    <td><textarea class="form-control" name="translation" placeholder="{{ t._('write_text') }}"
                                                  data-id_translation="{{ translation.id }}"
                                                  data-id_lang="{{ lang.id }}">{{ translation.getLang(['id_lang='~lang.id])?translation.getLang(['id_lang='~lang.id]).getValue():'' }}</textarea>
                                    </td>
                                {% endfor %}
                                <td class=" align-middle text-center">
                                    <div class="btn-group">
                                    <button class="update-translation btn btn-success">{{ t._('save') }}</button>
                                        <button type="button"
                                                class="btn btn-success dropdown-toggle dropdown-toggle-split"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                               href="{{ url.get(['for':'admin-translations-delete','id_translation':translation.id]) }}">{{ t._('delete') }}</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>