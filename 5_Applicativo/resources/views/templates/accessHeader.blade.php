<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fyt</title>

    <link href="{{ asset('../css/catalog.css') }}" rel="stylesheet">
    <link href="{{ asset('../css/shoe.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('../js/catalog.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-light fixed-top" style="background-color: #e3f2fd">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="/" class="navbar-brand">Home</a>
                <a href="/catalog" class="navbar-brand">Catalog</a>
            </div>
            <div class="ml-auto">
                <?php if(isset($_SESSION['user'])): ?>
                <a class="nav-link" href="/logout">Log Out</a>                
                <?php endif; ?>
            </div>
        </div>
    </nav>