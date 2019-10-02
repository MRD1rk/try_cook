<div id="choose-language">
    <div class="dropdown">
        <div class="dropdown-toggle"
             data-toggle="dropdown">
            <span class="country-flag {{ current_lang.iso_code }}"></span>
            <span>{{ converter.truncate(current_lang.name,3,'',0) }}</span>
        </div>
        <div class="dropdown-menu">
            {% for lang in langs %}
                <a class="dropdown-item" href="{{ urls_langs[lang.id] }}"
                   {% if lang.id == current_lang.id %}onclick="return false;" {% endif %}>
                    <span class="country-flag {{ lang.iso_code }}"></span>
                    <span>{{ lang.name }}</span>
                </a>
                {% if not loop.last %}
                    <div class="dropdown-divider"></div>
                {% endif %}
            {% endfor %}
        </div>
    </div>
</div>