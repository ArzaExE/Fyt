<form action="" method="POST">
    @csrf
    <div class="mb-3">
        <input type="text" class="form-control" name="username" placeholder="Username" required>
    </div>
    <div class="mb-3">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
    </div>
    <p>Don't have an account? <span><a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal">Click here</a></span></p>
    <button type="submit" class="btn btn-primary w-100">Login</button>
</form>
