<!-- Header -->
<?php echo $__env->make('templates.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="container" style="margin-top: 100px;">
    <h1>Shoe Details</h1>
    <img id="shoe" src="<?php echo e(request()->query('img')); ?>" alt="Shoe Image">
    <a href="/catalog"><button>Torna al catalogo</button></a>
</div>

<!-- Footer -->
<?php echo $__env->make('templates.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Scuola\TERZA\M306\Progetto 2 M306\Fyt\5_Applicativo\resources\views/shoe.blade.php ENDPATH**/ ?>