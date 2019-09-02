<div class="row">
    <div class="col-sm-12 col-md-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ t._('translations') }}</h4>
                <div class="text-center">
                    <a class="btn btn-success"
                       href="{{ url.get(['for':'admin-translations-add']) }}">{{ t._('add-translation') }}</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>{{ t._('pattern') }}</th>
                            {% for lang in langs %}
                                <th>{{ t._(lang.iso_code~'-translation') }}</th>
                            {% endfor %}
                            <th>{{ t._('action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {% for translation in translations %}
                            <tr class=" translation-item">
                                <td>{{ translation.pattern }}</td>
                                {% for lang in langs %}
                                    <td><textarea class="form-control" name="translation" placeholder="{{ t._('write-text') }}"
                                                  data-id_translation="{{ translation.id }}"
                                                  data-id_lang="{{ lang.id }}">{{ translation.getLang(['id_lang='~lang.id])?translation.getLang(['id_lang='~lang.id]).getValue():'' }}</textarea>
                                    </td>
                                {% endfor %}

                                <td class=" align-middle text-center">
                                    <button class="update-translation btn btn-success">{{ t._('save') }}</button>
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