 <form method="post" action="/new/add">
    <div class="row d-flex justify-content-center">
        <div class="col-7">
            <div class="form-row">
                <div class="col">
                    <!--    Username    -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="username">Имя пользователя: </span>
                        </div>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username"
                               aria-describedby="username" name="username" required minlength="3">
                    </div>
                </div>
                <div class="col">
                    <!--    Email    -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="email">Email: </span>
                        </div>
                        <input type="email" class="form-control" placeholder="Email" aria-label="Email"
                               aria-describedby="email" name="email" required>
                    </div>
                </div>
            </div>

            <!--    Body    -->
            <div class="form-group">
                <label class="text" for="toDoInput">To do:</label>
                <textarea class="form-control" id="toDoInput" required minlength="3" rows="3" name="task"></textarea>
            </div>

            <input class="btn btn-outline-primary" type="submit" name="submit">
        </div>
    </div>
</form>