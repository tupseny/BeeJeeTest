<nav class="navbar">
    <div class="d-flex flex-row">
        <form class="mr-3" method="post" action="/new">
            <button class="btn btn-primary" type="submit" value="Add...">Add...</button>
        </form>
        <form class="" method="post" action="/manager/clean">
            <button class="btn btn-warning" type="submit" value="Clean!">Clean!</button>
        </form>
    </div>

    <div class="text-success text-lg-center" hidden id="success-feedback"></div>
    <div class="text-warning text-lg-center" hidden id="error-feedback"></div>

    <form method="post" action="/login">
        <input type="submit" class="btn btn-outline-secondary" hidden name="login" id="login-btn" value="Login">
        <input type="submit" class="btn btn-dark" name="logout" hidden id="logout-btn" value="Log Out">
    </form>
</nav>
