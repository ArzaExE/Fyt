<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="<?php echo e(asset('../css/css.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
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

    <table>
        <tr>
            <td><a href="#"><img id="prova" src="<?php echo e(asset('img/s1.jpg')); ?>" alt="Test1"></a></td>
            <td><a href="#"><img id="prova" src="<?php echo e(asset('img/s2.jpg')); ?>" alt="Test2"></a></td>
            <td><a href="#"><img id="prova" src="<?php echo e(asset('img/s3.jpg')); ?>" alt="Test3"></a></td>
            <td><a href="#"><img id="prova" src="<?php echo e(asset('img/s4.jpg')); ?>" alt="Test4"></a></td>
            <td><a href="#"><img id="prova" src="<?php echo e(asset('img/s5.jpg')); ?>" alt="Test5"></a></td>
        </tr>
    </table>

    </div>
</body>
</html><?php /**PATH D:\Scuola\TERZA\M306\Progetto 2 M306\Fyt\5_Applicativo\Fyt\resources\views/catalogo.blade.php ENDPATH**/ ?>