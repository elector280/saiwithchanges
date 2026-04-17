

<?php $__env->startSection('title', 'Mini Campaign Template'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .mini-thumb {
        height: 46px;
        width: 72px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    .mini-thumb-placeholder {
        height: 46px;
        width: 72px;
        border-radius: 8px;
        border: 1px dashed #ced4da;
        background: #f8f9fa;
        color: #6c757d;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .mini-title {
        font-weight: 600;
        color: #212529;
        line-height: 1.35;
    }

    .mini-subtext {
        font-size: 12px;
        color: #6c757d;
    }

    .action-icon-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: 1px solid #e9ecef;
        background: #fff;
        margin-right: 6px;
        transition: all .15s ease-in-out;
    }

    .action-icon-btn:hover {
        background: #f8f9fa;
        transform: translateY(-1px);
    }

    .bulk-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .table td,
    .table th {
        vertical-align: middle !important;
    }

    .page-headline {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .summary-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        font-size: 12px;
        color: #495057;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 36px;
        margin-bottom: 12px;
        color: #adb5bd;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin'); ?>
<?php
    $locale = session('locale', config('app.locale'));
?>

<div class="container-fluid pt-3">
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-3">
        <div class="mb-3 mb-md-0">
            <div class="page-headline">Mini Campaign Templates</div>
            <div class="small">
                <a href="<?php echo e(url('/dashboard')); ?>" class="text-primary">Dashboard</a>
                <span class="text-muted mx-1">/</span>
                <span class="text-muted">Mini Campaign Templates</span>
            </div>
        </div>

        <div class="d-flex flex-wrap align-items-center">
            <a href="<?php echo e(route('campaigns.miniCampaignCreate')); ?>" class="btn btn-success mr-2 mb-2 mb-md-0 w3-round-large">
                <i class="fas fa-plus mr-1"></i> Add New
            </a>
        </div>
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

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle mr-1"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card w3-round-large">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h3 class="card-title mb-0">Mini Campaign Template List</h3>
                </div>

                <div class="d-flex align-items-center flex-wrap mt-2 mt-md-0">
                    <div class="mr-2 mb-2 mb-md-0">
                        <?php echo $__env->make('admin.layouts.locale', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>

                    <span class="summary-chip">
                        <i class="far fa-file-alt"></i>
                        Total: <?php echo e($miniCampaigns->total()); ?>

                    </span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="bulk-bar">
                <div class="d-flex align-items-center flex-wrap">
                    <button type="button" id="bulkDeleteBtn" class="btn btn-outline-danger btn-sm mr-2">
                        <i class="fas fa-trash mr-1"></i> Delete Selected
                    </button>

                    <span class="mini-subtext">
                        Select multiple rows to perform bulk delete.
                    </span>
                </div>

                <div class="mini-subtext">
                    Showing <?php echo e($miniCampaigns->firstItem() ?? 0); ?>–<?php echo e($miniCampaigns->lastItem() ?? 0); ?> of <?php echo e($miniCampaigns->total()); ?>

                </div>
            </div>

            <?php if($miniCampaigns->count()): ?>
                <div class="table-responsive">
                    <table id="dataTable" class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th width="10">
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th width="70">SL</th>
                                <th width="110">Cover</th>
                                <th>Title</th>
                                <th width="120">Status</th>
                                <th width="190" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $i = (($miniCampaigns->currentPage() - 1) * $miniCampaigns->perPage()) + 1;
                            ?>

                            <?php $__currentLoopData = $miniCampaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $title = method_exists($item, 'getDirectValue')
                                        ? ($item->getDirectValue('title', $locale) ?: $item->getDirectValue('title', 'en'))
                                        : (is_array($item->title) ? ($item->title[$locale] ?? $item->title['en'] ?? 'Untitled') : $item->title);

                                    $slug = is_array($item->slug ?? null)
                                        ? ($item->slug[$locale] ?? $item->slug['en'] ?? null)
                                        : ($item->slug ?? null);

                                    $frontUrl = $slug ? route('miniCampaign', $slug) : null;
                                ?>

                                <tr>
                                    <td>
                                        <input type="checkbox" class="row-checkbox" value="<?php echo e($item->id); ?>">
                                    </td>

                                    <td class="text-center">
                                        <?php echo e($i++); ?>

                                    </td>

                                    <td>
                                        <?php if($item->cover_image): ?>
                                            <img src="<?php echo e(asset('storage/cover_image/' . $item->cover_image)); ?>"
                                                 alt="Cover Image"
                                                 class="mini-thumb">
                                        <?php else: ?>
                                            <div class="mini-thumb-placeholder">
                                                No image
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div class="mini-title">
                                            <?php echo e($title ?: 'Untitled'); ?>

                                        </div>
                                        <div class="mini-subtext mt-1">
                                            ID: <?php echo e($item->id); ?>

                                            <?php if($slug): ?>
                                                <span class="mx-1">•</span>
                                                Slug: <?php echo e($slug); ?>

                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?php if((int) $item->status === 1): ?>
                                            <span class="badge badge-success px-2 py-1">Published</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary px-2 py-1">Draft</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-center">
                                        <a href="<?php echo e(route('campaigns.miniCampaignShow', $item->id)); ?>"
                                           class="action-icon-btn"
                                           title="View in admin">
                                            <i class="fas fa-eye text-primary"></i>
                                        </a>

                                        <?php if($frontUrl): ?>
                                            <a href="<?php echo e($frontUrl); ?>"
                                               target="_blank"
                                               class="action-icon-btn"
                                               title="View on frontend">
                                                <i class="fas fa-external-link-alt text-success"></i>
                                            </a>
                                        <?php endif; ?>

                                        <a href="<?php echo e(route('campaigns.miniCampaignEdit', $item->id)); ?>"
                                           class="action-icon-btn"
                                           title="Edit">
                                            <i class="fas fa-edit text-success"></i>
                                        </a>

                                        <form method="POST"
                                              action="<?php echo e(route('campaigns.miniCampaignDestroy', $item->id)); ?>"
                                              class="d-inline delete-form">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="button"
                                                    class="action-icon-btn border-0 js-delete-btn"
                                                    title="Delete"
                                                    data-name="<?php echo e($title ?? 'this item'); ?>">
                                                <i class="fas fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="mt-3">
                        <?php echo e($miniCampaigns->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="far fa-folder-open"></i>
                    <div class="h5 mb-2">No mini campaign templates found</div>
                    <div class="mb-3">Create your first mini campaign template to get started.</div>
                    <a href="<?php echo e(route('campaigns.miniCampaignCreate')); ?>" class="btn btn-success">
                        <i class="fas fa-plus mr-1"></i> Add New
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function () {

    $('#checkAll').on('click', function () {
        $('.row-checkbox').prop('checked', this.checked);
    });

    $(document).on('click', '.row-checkbox', function () {
        if (!$(this).prop('checked')) {
            $('#checkAll').prop('checked', false);
        } else if ($('.row-checkbox:checked').length === $('.row-checkbox').length) {
            $('#checkAll').prop('checked', true);
        }
    });

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
                } else {
                    alert(response.message || 'Unable to delete selected items.');
                }
            },
            error: function () {
                alert('Something went wrong while deleting selected items.');
            }
        });
    });

    $(document).on('click', '.js-delete-btn', function () {
        const form = $(this).closest('form');
        const name = $(this).data('name') || 'this item';

        if (confirm(`Are you sure you want to delete "${name}"?`)) {
            form.submit();
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/admin/canpaign/mini_campaign_index.blade.php ENDPATH**/ ?>