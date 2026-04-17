


<?php $__env->startSection('css'); ?>
<style>

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin'); ?>

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Blog Posts</h1>
    </div>
</div>

<div class="container-fluid mt-3">

    <?php if(session('success')): ?>
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="icon fas fa-check mr-1"></i>
            <?php echo e(session('success')); ?>


            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <script>
            setTimeout(function () {
                $('#success-alert').alert('close');
            }, 5000);
        </script>
    <?php endif; ?>


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Blog Posts</h3>
            <div class="card-tools">
                <?php echo $__env->make('admin.layouts.locale', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <a href="<?php echo e(route('stories.create')); ?>" class="btn btn-md btn-success"> <i class="fas fa-plus"></i> Add new</a>
                <a href="javascript:void(0)" id="bulkDeleteBtn" class="btn btn-md btn-danger">
                    <i class="fas fa-trash"></i> Bulk Delete
                </a>
            </div>
        </div>
       <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered dataTable nowrap" style="width:100%">
                    <thead>
                            <th width="10px">
                                <input type="checkbox" id="checkAll">
                            </th>
                            <th>#</th>
                            <th>Title</th>
                            <th>Featured Image</th>
                            <th>Project status</th>
                            <th>Action</th>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $stories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><input type="checkbox" class="row-checkbox" value="<?php echo e($value->id); ?>"></td>
                            <td style="width: 30px; text-align: center;">
                               <?php echo e($loop->iteration); ?>

                            </td>
                            <!-- <td>
                                <?php if(!empty($value->campaign_id)): ?>
                                <a href="<?php echo e(route('campaigns.show', $value->campaign_id)); ?>" class="btn btn-sm btn-primary">
                                    <?php echo e($value->campaign_id); ?>

                                </a>
                                <?php endif; ?>
                            </td> -->
                            <td title="<?php echo e($value->title); ?>">
                                <a href="<?php echo e(session('locale', config('app.locale')) === 'es' ? route('blogDetailsEs', $value->slug) : route('blogDetails', $value->slug)); ?>" target="_blank">
                                    <?php echo e(\Illuminate\Support\Str::limit($value->title, 50, '')); ?>

                                </a>
                            </td>
                            <td>
                                <?php if($value->image): ?>
                                    <img src="<?php echo e(asset('storage/story_image/'.$value->image)); ?>" style="height:40px;border-radius:6px;">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($value->status); ?></td>
                            <td>
                                <form action="<?php echo e(route('story.toggleStatus', $value)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit"
                                            class="bg-transparent border-0 p-0 m-0 shadow-none focus:outline-none
                                                text-secondary hover:text-primary cursor-pointer"
                                            title="Toggle Status">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </form>
                                
                                <a href="<?php echo e(route('stories.show', $value->id)); ?>" class="bg-transparent border-0 p-0 focus:outline-none shadow-none" title="Show on backend">
                                    <i class="fas fa-eye text-success mr-3 ml-3"></i>
                                </a>
                                
                                <a href="<?php echo e(session('locale', config('app.locale')) === 'es' ? route('blogDetailsEs', $value->slug) : route('blogDetails', $value->slug)); ?>" class="bg-transparent border-0 p-0 focus:outline-none shadow-none" title="View Live" target="_blank">
                                    <i class="fas fa-eye text-red mr-3"></i>
                                </a>

                                <a href="<?php echo e(route('stories.edit', $value->id)); ?>" class="bg-transparent border-0 p-0 focus:outline-none shadow-none">
                                    <i class="fas fa-edit text-success mr-3"></i>
                                </a>


                                <form method="POST"  action="<?php echo e(route('stories.destroy', $value->id)); ?>" class="d-inline delete-form">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="button"
                                            class="bg-transparent border-0 p-0 shadow-none js-delete-btn"
                                            data-name="<?php echo e($value->title ?? 'this item'); ?>">
                                        <i class="fas fa-trash text-danger mr-3"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>






<?php $__env->startSection('js'); ?>



<script>
$(document).ready(function () {

    // ✅ Select All
    $('#checkAll').on('click', function () {
        $('.row-checkbox').prop('checked', this.checked);
    });

    // ✅ Uncheck select all if any unchecked
    $(document).on('click', '.row-checkbox', function () {
        if (!$(this).prop('checked')) {
            $('#checkAll').prop('checked', false);
        }
    });

    // ✅ Bulk delete
    $('#bulkDeleteBtn').on('click', function () {

        let ids = [];

        $('.row-checkbox:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            alert('Please select at least one item.');
            return;
        }

        if (!confirm('Are you sure you want to delete selected items?')) {
            return;
        }

        $.ajax({
            url: "<?php echo e(route('stories.bulk-delete')); ?>",
            type: "POST",
            data: {
                _token: "<?php echo e(csrf_token()); ?>",
                ids: ids
            },
            success: function (response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                }
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });

});
</script>

<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/admin/story/index.blade.php ENDPATH**/ ?>