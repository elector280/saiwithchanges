 <?php
    $currentLocale = session('locale', config('app.locale'));
    $languages = App\Models\Language::where('active', 1)->get();
?>

<div class="btn-group btn-group-sm mr-2" role="group" aria-label="Language toggle">

    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <form action="<?php echo e(route('languageUpdateStatus', $language)); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <button
                type="submit"
                class="btn btn-sm
                    <?php echo e($currentLocale === $language->language_code 
                        ? 'btn-primary' 
                        : 'btn-outline-primary'); ?>">
                <?php echo e(strtoupper($language->language_code)); ?>

            </button>
        </form>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div><?php /**PATH /home/saingo/public_html/resources/views/admin/layouts/locale.blade.php ENDPATH**/ ?>