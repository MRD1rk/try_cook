<div id="auth-signup">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="text-center">
                <h1 class="title">{{ t._('signup') }}</h1>
            </div>
        </div>
        <div class="col-8">
            <div class="jumbotron">
                {% for message in messages %}
                    <div class="alert-overwrite alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        {{ message }}
                    </div>
                {% endfor %}
                <form method="post" novalidate>
                    {{ form.renderDecorated('firstname') }}
                    {{ form.renderDecorated('lastname') }}
                    {{ form.renderDecorated('email') }}
                    {{ form.renderDecorated('password') }}
                    {{ form.renderDecorated('confirm_password') }}
                    <div class="text-center">
                        {{ form.renderCsrf() }}
                        <button class="btn btn-success">{{ t._('save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>