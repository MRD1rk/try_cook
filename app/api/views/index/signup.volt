<div class="container">
    <div id="index-signin">
        <div class="row justify-content-center">
            <div class="col-6">
                <form method="post">
                    <div class="form-group">
                        <label for="firstname">{{ t._('firstname') }}:</label>
                        <input id="firstname" name="firstname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="lastname">{{ t._('lastname') }}:</label>
                        <input id="lastname" name="lastname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">{{ t._('email') }}:</label>
                        <input id="email" name="email" type="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">{{ t._('password') }}:</label>
                        <input id="password" name="password" type="password" class="form-control">
                    </div>
                    <div class="text-center">
                        <button class="btn btn-success">{{ t._('do-signup') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>