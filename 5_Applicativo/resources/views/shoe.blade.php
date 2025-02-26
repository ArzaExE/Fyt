<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="{{ asset('../css/shoe.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-light fixed-top" style="background-color: #e3f2fd">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="/" class="navbar-brand">Home</a>
                <a href="/catalogo" class="navbar-brand">Catalogo</a>
            </div>
            <div class="ml-auto">
                <?php if(!isset($_SESSION['user'])): ?>
                <a class="nav-link" href="/login">Log In</a>
                <a class="nav-link" href="/signup">Sign Up</a>
                <?php else: ?>
                <a class="nav-link" href="/logout">Log Out</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <h1>Shoe Details</h1>
        <img src="{{ request()->query('img') }}" alt="Shoe Image">
    </div>

    <a href="/catalogo"><button>Torna al catalogo</button></a>

    </div>
</body>
</html>