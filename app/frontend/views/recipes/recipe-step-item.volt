<div data-id_step="{{ step.id }}" data-position="{{ step.position }}" class="step-item step-item-{{ step.position }}">
    <div class="row">
        <div class="col-6">
            <span class="draggable"><i class="fas fa-grip-vertical"></i></span> &nbsp;<span class="step-count">{{ t._('step') }} <span>{{ step.position }}</span></span>
        </div>
        <div class="col-6 short-hide">
            <p class="remove-recipe-step hovered-red text-right">
                <i class="fas fa-trash"></i>
                {{ t._('remove_recipe_step') }}
            </p>
        </div>
        <div class="col-12 short-hide">
            {% set preview_url = step.getLink() %}
            <div class="preview-image-block  {% if (preview_url is empty) %}not-image {% endif %}">
                <label class="add-recipe-preview-img" for="recipe_step_image_{{ step.id }}"
                       style="background-image: url('{{ preview_url }}');">
                    <span title="{{ t._('upload_img') }}">{{ t._('upload_img') }}</span>
                </label>
                <input class="recipe-step-image" id="recipe_step_image_{{ step.id }}" type="file">
            </div>
        </div>
        <div class="col-12">
            <div class="recipe-step-description-block">
                <textarea data-keep="true" name="recipe_steps[description][{{ step.id }}]">{{ step.lang.content|default('') }}</textarea>
            </div>
        </div>
    </div>
</div>