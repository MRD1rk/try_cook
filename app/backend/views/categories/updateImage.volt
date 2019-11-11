<div id="categories-update-image">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-8 mt-5">
            <div class="card">
                <div class="card-header">
                    {{ AdminSidebarWidget.run('categories',category.id) }}
                </div>
                <div class="card-body">
                    <h4 class="header-title text-center">{{ category.lang.title }}</h4>
                    <div id="category_update-image">
                        <form id="category_add_form" enctype="multipart/form-data" method="post">
                            <div class="row">
                                <div class="col-12">
                                    <div class="category-icon-preview">
                                        <img src="{{ url.getCategoryIconLink(category.getId()) }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>{{ t._('download_image') }}</label>
                                        <div class="preview-image">
                                            <label class="add-category-preview-img" for="category_image">
                                                <span title="upload_img">{{ t._('upload_img') }}</span>
                                            </label>
                                            <input name="category_icon" id="category_image" type="file" required>
                                        </div>
                                    </div>
                                </div>
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