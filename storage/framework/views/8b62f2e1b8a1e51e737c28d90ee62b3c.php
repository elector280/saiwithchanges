


<?php $__env->startSection('css'); ?>
<style>

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin'); ?>

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pages</h1>
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
            <h3 class="card-title">Pages</h3>
            <div class="card-tools">
                <?php echo $__env->make('admin.layouts.locale', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <a href="<?php echo e(route('campaigns.create')); ?>" class="btn btn-md btn-success"> <i class="fas fa-plus"></i> Add New</a>
                <a href="javascript:void(0)" id="bulkDeleteBtn" class="btn btn-md btn-danger">
                    <i class="fas fa-trash"></i> Bulk Delete
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered nowrap dataTable" style="width:100%">
                    <thead>
                        <tr>
                            <th width="10px">
                                <input type="checkbox" id="checkAll">
                            </th>

                            <th>Sl</th>
                            <th>Project Image</th>
                            <th>Project Title</th>
                            <!--<th>Slug</th>-->
                            <th>Project Status</th>
                            <!-- <th> Footer Image </th> -->
                            <th>Project Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                         <?php $i = (($campaigns->currentPage() - 1) * $campaigns->perPage() + 1); ?>
                        <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $currentLocale = session('locale', config('app.locale'));
                                    $campaignPath = $currentLocale === 'es'
                                        ? ($value->getTranslation('path', 'es', false) ?: $value->getTranslation('path', 'en', false))
                                        : ($value->getTranslation('path', 'en', false) ?: $value->getTranslation('path', 'es', false));

                                    $campaignSlug = $currentLocale === 'es'
                                        ? ($value->getTranslation('slug', 'es', false) ?: $value->getTranslation('slug', 'en', false))
                                        : ($value->getTranslation('slug', 'en', false) ?: $value->getTranslation('slug', 'es', false));

                                    $campaignPath = is_string($campaignPath) ? trim($campaignPath) : '';
                                    $campaignSlug = is_string($campaignSlug) ? trim($campaignSlug) : '';

                                    $campaignUrl = null;

                                    if ($campaignPath !== '' && $campaignSlug !== '') {
                                        $campaignUrl = $currentLocale === 'es'
                                            ? route('campaignsdetailsEsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug])
                                            : route('campaignsdetailsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug]);
                                    }
                                ?>
                        <tr>
                           <td width="10px">
                                <input type="checkbox" class="row-checkbox" value="<?php echo e($value->id); ?>">
                            </td>
                            <td style="width: 30px; text-align: center;">
                                 <?php echo e($i++); ?>

                            </td>
                             <td>
                                <?php if($value->hero_image): ?>
                                    <img src="<?php echo e(asset('storage/hero_image/'.$value->hero_image)); ?>" style="height:40px;border-radius:6px;">
                                    <!-- <img src="<?php echo e(asset('storage/hero_image/'.$value->hero_image)); ?>" style="height:40px;border-radius:6px;"> -->
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><a href="<?php echo e($campaignUrl); ?>" target="blanl"><?php echo e($value->title); ?></a></td>
                            <!--<td><?php echo e($value->slug); ?></td>-->
                            <td><?php echo e($value->status); ?></td>
                            <!-- <td>
                                <?php if($value->footer_image): ?>
                                    <img src="<?php echo e(asset('storage/footer_image/'.$value->footer_image)); ?>" style="height:40px;border-radius:6px;">
                                <?php else: ?>
                                    <span class="text-muted">No image</span>
                                <?php endif; ?>
                            </td> -->
                            <td>
                                <?php echo e($value->type); ?>

                            </td>
                            <td>
                                <form action="<?php echo e(route('campaigns.toggleStatus', $value)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                    <button type="submit"
                                            class="bg-transparent border-0 p-0 m-0 shadow-none focus:outline-none
                                                text-secondary hover:text-primary cursor-pointer"
                                            title="Toggle Status">
                                        <i class="fas fa-sync"></i>
                                    </button>
                                </form>


                                <a href="<?php echo e(route('campaigns.show', $value->id)); ?>" class="mr-3 ml-3"><i class="fas fa-eye"></i></a>
                                
                                <a href="<?php echo e(session('locale', config('app.locale')) === 'es' ? route('campaignsdetailsEsDyn', ['path' => $value->path, 'slug' => $value->slug]) : route('campaignsdetailsDyn', ['path' => $value->path, 'slug' => $value->slug])); ?>" class="bg-transparent border-0 p-0 focus:outline-none shadow-none" title="View Live" target="_blank">
                                    <i class="fas fa-eye text-red mr-3"></i>
                                </a>
                                
                                <a href="<?php echo e(route('campaigns.edit', $value->id)); ?>" class="bg-transparent border-0 p-0 focus:outline-none shadow-none">
                                    <i class="fas fa-edit text-success mr-3"></i>
                                </a>

                                <form method="POST"
                                    action="<?php echo e(route('campaigns.destroy', $value->id)); ?>"
                                    class="d-inline delete-form">
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
            url: "<?php echo e(route('campaigns.bulk-delete')); ?>",
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
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/admin/canpaign/index.blade.php ENDPATH**/ ?>