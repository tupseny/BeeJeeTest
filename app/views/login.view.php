<form method="post" action="/login">
    <div class="row d-flex justify-content-center pt-5">
        <div class="col-4">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username"
                       placeholder="Enter username" name="username" required min="3">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" required min="3"
                       name="password" aria-describedby="error">
                <?php if (isset($_COOKIE['error']) and $_COOKIE['error'] === 'invalid_credentials'): ?>
                    <span id="error" class="form-text text-danger">Invalid credentials</span>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </div>
</form>

<?php
if (isset($_COOKIE['error'])){
    setcookie('error', '', 0, '/login');
}
?>
