

<?php $__env->startSection('admin'); ?>
<section class="content-header">
  <div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h1 class="m-0">Gallery</h1>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Gallery Editor</li>
        </ol>
      </div>

      <form class="d-flex" method="GET" action="<?php echo e(route('campaign.gallery.index')); ?>">
        <div class="input-group input-group-sm" style="width: 260px;">
          <input type="text" name="q" value="<?php echo e($q); ?>" class="form-control" placeholder="Search campaign...">
          <div class="input-group-append">
            <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <?php if(session('success')): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
    <?php endif; ?>

    <div class="row">
      <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <div class="card card-outline card-danger">
            <div class="card-body p-2">
              <div style="height:160px; overflow:hidden; border-radius:4px;">
                <!-- <img src="<?php echo e(asset('storage/hero_image/'.$campaign->hero_image)); ?>" style="width:100%; height:160px; object-fit:cover;" alt=""> -->
                    <img src="<?php echo e(asset('storage/hero_image/'.$campaign->hero_image)); ?>"
                    style="width:100%; height:160px; object-fit:cover;"
                    alt="<?php echo e($campaign->title); ?>" title="<?php echo e($campaign->title); ?>"> 
              </div> 

              <div class="mt-2">
                <div class="font-weight-bold text-truncate" title="<?php echo e($campaign->title); ?>">
                  <?php echo e($campaign->title); ?>

                </div>
                <small class="text-muted">ID: <?php echo e($campaign->id); ?></small>
              </div>

              <a href="<?php echo e(route('campaign.gallery.edit', $campaign)); ?>"
                 class="btn btn-danger btn-block btn-sm mt-2">
                EDIT PROJECT GALLERY
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="d-flex justify-content-center">
    <?php echo e($campaigns->links('pagination::bootstrap-4')); ?>

    </div>

  </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/admin/campaign_gallery/index.blade.php ENDPATH**/ ?>