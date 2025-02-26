<!-- Header -->
@include('templates.accessHeader')

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-4 border p-4 rounded">
        <h1 class="text-center mb-4">Login</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Username">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Password">
            </div>
            <p>Dont have an account? <span><a href="/signup">Click here</a></span></p>
            <button type="submit" class="btn btn-primary w-100">Accedi</button>
        </form>
    </div>
</div>

<!-- Footer -->
@include('templates.footer')