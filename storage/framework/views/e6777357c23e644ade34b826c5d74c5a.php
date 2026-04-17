<section class="pb-16 bg-white">
    <div class="max-w-7xl px-4 md:px-0 mx-auto text-center">
        <h2 class="text-[18px] md:text-2xl font-bold uppercase text-[#d93832]">
            <?php echo e(translate('OUR SPONSORS')); ?>

        </h2>

        <?php
            $sponsor = App\Models\Sponsor::where('type', 'sponsors')->latest()->get();
        ?>

        <?php if($sponsor->count()): ?>
        <div class="mt-6 sponsor-marquee overflow-hidden">
            <div class="sponsor-track flex items-center gap-8 md:gap-10" id="sponsorTrack">
                
                <?php $__currentLoopData = $sponsor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="<?php echo e(asset('storage/company_logo/'.$item->company_logo)); ?>"
                        alt="<?php echo e($item->company_name); ?>"
                        class="object-contain w-auto h-8 md:h-10 shrink-0" />
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php $__currentLoopData = $sponsor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="<?php echo e(asset('storage/company_logo/'.$item->company_logo)); ?>"
                        alt="<?php echo e($item->company_name); ?>"
                        class="object-contain w-auto h-8 md:h-10 shrink-0" />
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH C:\Users\MalcaCorp\Desktop\proyecto\public_html\resources\views/frontend/includes/our_sponsors.blade.php ENDPATH**/ ?>