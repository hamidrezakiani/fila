<!-- __BLOCK__ --><?php if(filled($brand = filament()->getBrandName())): ?>
    <div
        <?php echo e($attributes->class([
                'fi-logo text-xl font-bold leading-5 tracking-tight text-gray-950 dark:text-white',
            ])); ?>

    >
        <?php echo e($brand); ?>

    </div>
<?php endif; ?> <!-- __ENDBLOCK__ -->
<?php /**PATH C:\xampp\htdocs\filament\vendor\filament\filament\src\/../resources/views/components/logo.blade.php ENDPATH**/ ?>