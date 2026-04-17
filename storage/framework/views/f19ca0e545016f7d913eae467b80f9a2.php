

<?php $__env->startSection('title', 'Mini Campaign Preview'); ?>

<?php $__env->startSection('meta'); ?>
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo e(config('app.name')); ?>">
    <meta property="og:locale" content="en_US">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">

    <?php if(!empty($cam->og_title) || !empty($cam->title)): ?>
        <meta property="og:title" content="<?php echo e($cam->og_title ?: $cam->title); ?>">
    <?php endif; ?>

    <?php if(!empty($cam->og_description) || !empty($cam->meta_description)): ?>
        <meta property="og:description" content="<?php echo e($cam->og_description ?: $cam->meta_description); ?>">
    <?php endif; ?>

    <?php if(!empty($cam->og_image_url)): ?>
        <meta property="og:image" content="<?php echo e($cam->og_image_url); ?>">
        <meta property="og:image:secure_url" content="<?php echo e($cam->og_image_url); ?>">
        <meta property="og:image:alt" content="<?php echo e($cam->og_title ?: $cam->title); ?>">
    <?php elseif(!empty($cam->cover_image_url)): ?>
        <meta property="og:image" content="<?php echo e($cam->cover_image_url); ?>">
        <meta property="og:image:secure_url" content="<?php echo e($cam->cover_image_url); ?>">
        <meta property="og:image:alt" content="<?php echo e($cam->og_title ?: $cam->title); ?>">
    <?php endif; ?>

    <meta name="twitter:card" content="summary_large_image">

    <?php if(!empty($cam->og_title) || !empty($cam->title)): ?>
        <meta name="twitter:title" content="<?php echo e($cam->og_title ?: $cam->title); ?>">
    <?php endif; ?>

    <?php if(!empty($cam->og_description) || !empty($cam->meta_description)): ?>
        <meta name="twitter:description" content="<?php echo e($cam->og_description ?: $cam->meta_description); ?>">
    <?php endif; ?>

    <?php if(!empty($cam->og_image_url)): ?>
        <meta name="twitter:image" content="<?php echo e($cam->og_image_url); ?>">
    <?php elseif(!empty($cam->cover_image_url)): ?>
        <meta name="twitter:image" content="<?php echo e($cam->cover_image_url); ?>">
    <?php endif; ?>

    <?php if(!empty($cam->canonical_url)): ?>
        <link rel="canonical" href="<?php echo e($cam->canonical_url); ?>">
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('frontend'); ?>
<style>
    .preview-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffe69c;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
    }

    .mc-thumb {
        height: 64px;
        width: 96px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>

<section class="py-4 bg-light border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="preview-badge mb-2 mb-md-0">
                <i class="fas fa-eye"></i> Preview Mode — Not Published
            </div>

            <div class="small text-muted">
                Status: <?php echo e(($cam->status ?? '0') == '1' ? 'Published' : 'Draft'); ?>

                <?php if(!empty($cam->start_date)): ?>
                    | Start: <?php echo e(\Carbon\Carbon::parse($cam->start_date)->format('M d, Y h:i A')); ?>

                <?php endif; ?>
                <?php if(!empty($cam->end_date)): ?>
                    | End: <?php echo e(\Carbon\Carbon::parse($cam->end_date)->format('M d, Y h:i A')); ?>

                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section id="top" class="pt-4 pb-10 bg-[#f5f5f5] -mt-10 md:-mt-36 relative z-0">
    <div class="relative rounded-sm overflow-hidden shadow-lg bg-no-repeat bg-cover bg-center"
         style="<?php echo e(!empty($cam->cover_image_url) ? "background-image: url('".$cam->cover_image_url."');" : ''); ?> height: 600px; background-color:#e5e7eb;">
        <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-[2fr,1fr] gap-6"></div>
    </div>
</section>

<section class="pb-20 -mt-48 relative z-10">
    <div class="max-w-7xl md:mx-auto grid lg:grid-cols-1 gap-6">

        <article id="mainDiv" class="mainDiv overflow-visible space-y-12-">

            <div class="bg-white shadow-md border border-gray-200 overflow-hidden md:mx-0 rounded-[4px]">

                <div class="relative bg-[#D94647] text-white px-5 md:px-8 py-2 pb-1 overflow-hidden">
                    <h2 class="text-[22px] sm:text-[26px] md:text-[34px] lg:text-[40px]
                            font-bold uppercase leading-tight">
                        <?php echo e($cam->title); ?>

                    </h2>

                    <div class="mt-1 flex flex-wrap gap-2">
                        <?php if(!empty($cam->slug)): ?>
                            <span class="inline-flex items-center gap-2 bg-white/15 px-3 py-1 rounded-full text-[12px] uppercase tracking-wider">
                                <i class="fa-solid fa-link"></i> <?php echo e($cam->slug); ?>

                            </span>
                        <?php endif; ?>

                        <?php if(!empty($cam->tag_line)): ?>
                            <span class="inline-flex items-center gap-2 bg-yellow-400 text-black px-3 py-1 rounded-full text-[12px] uppercase tracking-wider">
                                <i class="fa-solid fa-bolt"></i> <?php echo e($cam->tag_line); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="px-5 md:px-8 pt-2 pb-2">

                    <?php if(!empty($cam->short_description)): ?>
                        <div class="mt-1 text-[14px] sm:text-[15px] md:text-[16px] text-gray-500 leading-relaxed prose max-w-none">
                            <?php echo $cam->short_description; ?>

                        </div>
                    <?php endif; ?>

                    <?php if(!empty($cam->view_project_url)): ?>
                        <a href="<?php echo e($cam->view_project_url); ?>" target="_blank"
                           class="mt-1 inline-block text-[13px] font-semibold text-[#f04848] hover:underline">
                            <?php echo e(translate('Visit Website')); ?> &gt;
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bg-white shadow-md border border-gray-200 overflow-hidden rounded-[4px]">
                <div class="px-5 md:px-8 py-2">
                    <div class="mt-2 space-y-6 text-[15px] leading-relaxed text-gray-600">
                        <?php if(!empty($cam->paragraph_one)): ?>
                            <div class="prose max-w-none">
                                <?php echo $cam->paragraph_one; ?>

                            </div>
                        <?php endif; ?>

                        <?php if(!empty($cam->paragraph_two)): ?>
                            <div class="prose max-w-none">
                                <?php echo $cam->paragraph_two; ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if(!empty($cam->donation_box)): ?>
                <div class="bg-white shadow-md border border-gray-200 overflow-hidden rounded-[4px]">
                    <div class="px-5 md:px-8 py-5">
                        <div class="prose max-w-none">
                            <?php echo $cam->donation_box; ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="bg-white shadow-md border border-gray-200 overflow-hidden rounded-[4px]">
                <div class="px-5 md:px-8 py-5">
                    <h4 class="font-bold mb-3">SEO / Social Summary</h4>

                    <div class="grid md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <div><strong>Meta Title:</strong> <?php echo e($cam->meta_title ?: 'N/A'); ?></div>
                            <div class="mt-2"><strong>Meta Description:</strong> <?php echo e($cam->meta_description ?: 'N/A'); ?></div>
                            <div class="mt-2"><strong>Canonical:</strong> <?php echo e($cam->canonical_url ?: 'N/A'); ?></div>
                        </div>

                        <div>
                            <div><strong>OG Title:</strong> <?php echo e($cam->og_title ?: 'N/A'); ?></div>
                            <div class="mt-2"><strong>OG Description:</strong> <?php echo e($cam->og_description ?: 'N/A'); ?></div>
                            <div class="mt-2">
                                <strong>OG Image:</strong>
                                <?php if(!empty($cam->og_image_url)): ?>
                                    <div class="mt-2">
                                        <img src="<?php echo e($cam->og_image_url); ?>" class="mc-thumb" alt="OG Preview">
                                    </div>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </article>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/admin/canpaign/minicampaign_front_preview.blade.php ENDPATH**/ ?>