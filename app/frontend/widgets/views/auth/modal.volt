<div class="modal fade" id="auth_modal" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="text-center">
                    <h5 class="modal-title">{{ t._('login') }}</h5>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <div class="login-form">
                            <form id="signin_form" method="post" novalidate="novalidate">
                                <div class="form-group">
                                    <label for="email">{{ t._('email') }}</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                           placeholder="{{ t._('enter_email') }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ t._('password') }}</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                           placeholder="{{ t._('enter_password') }}">
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="remember_me" value="1"
                                               id="remember_me">
                                        <label class="custom-control-label"
                                               for="remember_me">{{ t._('remember_me') }}</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback text-center d-block"></div>
                                <div class="valid-feedback text-center d-block"></div>
                                <div class="col-md-12 text-center m-3">
                                    <button class="btn btn-block btn-success">{{ t._('login') }}</button>
                                </div>
                                {% if login_methods is defined %}
                                    <div class="col-md-12 ">
                                        <div class="login-or">
                                            <hr class="hr-or">
                                            <span class="span-or">or</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <p class="text-center">
                                            <a href="javascript:void();" class="google btn mybtn"><i
                                                        class="fas fa-google-plus">
                                                </i> Signup using Google
                                            </a>
                                        </p>
                                    </div>
                                {% endif %}
                                <div class="form-group">
                                    <div class="auth-links text-center">
                                            <a href="{{ url.get(['for':'auth-signup','iso_code':iso_code]) }}"
                                               id="signup">{{ t._('signup') }}</a>
                                        <hr/>
                                            <a href="{{ url.get(['for':'auth-signup','iso_code':iso_code]) }}"
                                               id="signup">{{ t._('restore_password') }}</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            {#            <div class="modal-footer">#}
            {#            </div>#}
        </div>
    </div>
</div>