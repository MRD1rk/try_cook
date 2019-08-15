<!-- login area start -->
<div class="login-area login-s2">
    <div class="container">
        <div class="login-box ptb--100">
            <form method="post">
                <div class="login-form-head">
                    <h4>{{ t._('sign-in') }}</h4>
                    <p>{{ t._('first sign-in and start work in admin template') }}</p>
                </div>
                <div class="login-form-body">
                    <div class="form-gp">
                        <label for="sign-in-email">{{ t._('email-address') }}</label>
                        <input required name="email" type="email" id="sign-in-email">
                        <i class="ti-email"></i>
                    </div>
                    <div class="form-gp">
                        <label for="sign-in-password">{{ t._('password') }}</label>
                        <input required name="password" type="password" id="sign-in-password">
                        <i class="ti-lock"></i>
                    </div>
                    <div class="row mb-4 rmber-area">
                        <div class="col-6">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input name="remember_me" value="1" type="checkbox" class="custom-control-input" id="remember_me">
                                <label class="custom-control-label" for="remember_me">{{ t._('remember-me') }}</label>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#">{{ t._('forgot-password') }}</a>
                        </div>
                    </div>
                    <div class="submit-btn-area">
                        <button id="form_submit" type="submit">{{ t._('submit') }} <i class="ti-arrow-right"></i></button>
                    </div>
                    <div class="form-footer text-center mt-5">
                        <p class="text-muted">Don't have an account? <a href="register.html">Sign up</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>