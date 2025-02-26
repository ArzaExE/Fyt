<!-- Header -->
<?php echo $__env->make('templates.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="w-100 vh-100 d-flex align-items-center justify-content-center p-3 mb-2 bg-light text-dark">
    <h1>Home Fyt</h1>
    <img src="<?php echo e(asset('img/Logo.png')); ?>" alt="Logo">
    <p>Oggi è il <?php echo e(date('d/m/Y')); ?></p>
</div>

<!-- Footer -->
<?php echo $__env->make('templates.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Scuola\TERZA\M306\Progetto 2 M306\Fyt\5_Applicativo\resources\views/home.blade.php ENDPATH**/ ?>