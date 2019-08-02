<div id="index-signin">
    <div class="row justify-content-center">
        <div class="col-8">
            <form method="post">
                <div class="form-group">
                    <label for="email">{{ t._('email') }}:</label>
                    <input id="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">{{ t._('password') }}:</label>
                    <input id="password" name="password" class="form-control">
                </div>
                <div class="text-center">
                    <button class="btn btn-success">{{ t._('do-signin') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>