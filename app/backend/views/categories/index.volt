<div class="row">
    <div class="col-sm-12 col-md-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ t._('categories') }}</h4>
                <div class="text-center mb-3">
                    <a class="btn btn-success"
                       href="{{ url.get(['for':'admin-categories-add']) }}">{{ t._('add-category') }}</a>
                </div>
                <table id="categories-index" class="table table-bordered table-vcenter">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>{{ t._('title') }}</th>
                        <th>{{ t._('description') }}</th>
                        <th>{{ t._('image') }}</th>
                        <th>{{ t._('is_active') }}</th>
                        <th>{{ t._('position') }}</th>
                        <th>{{ t._('control') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    {% for category in categories %}
                        <tr id="{{ category.id }}" class="category-item">
                            <td>{{ category.id }}</td>
                            <td>
                                <span>{{ category.getRelated('lang',['conditions':'id_lang='~lang.id]).title|default('') }}</span>
                            </td>
                            <td>
                                <span>{{ category.getRelated('lang',['conditions':'id_lang='~lang.id]).description|default('') }}</span>
                            </td>
                            <td style="width: 100px;"><img src="{{ url.getCategoryIconLink(category.getId()) }}"> </td>
                            <td class="text-center">
                                <div class="s-swtich">
                                    <input onchange="updateCategoryActive($(this))" data-id_category="{{ category.id }}"
                                           {% if category.active %}checked{% endif %} type="checkbox"
                                           id="active-{{ category.id }}" class="update-active">
                                    <label for="active-{{ category.id }}">{{ t._('toggle') }}</label>
                                </div>
                            </td>
                            <td class="text-center"><input type="hidden" class="position"
                                                           value="{{ category.position }}"><i
                                        class="ti-move drugHandler"></i></td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ url.get(['for':'admin-categories-view','id_category':category.id]) }}"
                                       class="btn btn-secondary">{{ t._('view') }}</a>
                                    <button type="button"
                                            class="btn btn-secondary dropdown-toggle dropdown-toggle-split"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="{{ url.get(['for':'admin-categories-update','id_category':category.id]) }}">{{ t._('update') }}</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="{{ url.get(['for':'admin-categories-delete','id_category':category.id]) }}">{{ t._('delete') }}</a>
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