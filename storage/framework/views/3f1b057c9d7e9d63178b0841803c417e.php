


<?php $__env->startSection('css'); ?>
<style>

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin'); ?>

<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Permission</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>">Home</a></li>
            <li class="breadcrumb-item active">Permission</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Permission</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
                        Add Permission
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table class="table table-bordered dataTable">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Guard</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key + 1); ?></td>
                    <td><?php echo e($permission->name); ?></td>
                    <td>
                        <?php echo e($permission->guard_name); ?>

                    </td>
                    <td>
                        <form method="POST"  action="<?php echo e(route('permissions.destroy', $permission->id)); ?>" class="d-inline delete-form">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="button"
                                    class="bg-transparent border-0 p-0 shadow-none js-delete-btn"
                                    data-name="<?php echo e($value->title ?? 'this item'); ?>">
                                <i class="fas fa-trash text-danger mr-3"></i>
                            </button>
                        </form>

                        <button type="button"
                                data-toggle="modal"
                                data-target="#modal-lg-<?php echo e($permission->id); ?>"
                                class="bg-transparent border-0 p-0 focus:outline-none shadow-none">
                            <i class="fas fa-edit text-success mr-3"></i>
                        </button>
                    </td>
                </tr>

                <div class="modal fade" id="modal-lg-<?php echo e($permission->id); ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Update Permission</h3>
                                    </div>
                                    
                                    <form class="form-horizontal" method="POST" action="<?php echo e(route('permissions.update', $permission->id)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <div class="card-body">                
                                            <div class="form-group row">
                                                <label for="nane" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                <input type="text" name="name" placeholder="Name" id="name" class="form-control" value="<?php echo e($permission->name); ?>" required>
                                                </div>
                                            </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-info">Update</button>
                                            <button type="button" class="btn btn-default float-right"  data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- /.card -->
        </div>
    </div>
</div>



<div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Create Permission</h3>
                    </div>
                    
                    <form class="form-horizontal" method="POST" action="<?php echo e(route('permissions.store')); ?>">
                        <?php echo csrf_field(); ?> 
                        <div class="card-body">                
                            <div class="form-group row">
                                <label for="nane" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                <input type="text" name="name" placeholder="Name" id="name" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Save</button>
                            <button type="button" class="btn btn-default float-right"  data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/admin/roles/permissions.blade.php ENDPATH**/ ?>