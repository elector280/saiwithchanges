

<?php $__env->startSection('css'); ?>
    <style>
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 12px;
        }

        @media (max-width: 1400px) {
            .gallery-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        @media (max-width: 1200px) {
            .gallery-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 992px) {
            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 576px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .gallery-item {
            border: 1px solid #e5e5e5;
            background: #fff;
            border-radius: 4px;
            overflow: hidden;
            cursor: grab;
            user-select: none;
            position: relative;
        }

        .gallery-thumb {
            width: 100%;
            height: 110px;
            object-fit: cover;
            display: block;
        }

        .gallery-caption {
            font-size: 12px;
            padding: 6px 8px;
            border-top: 1px solid #f1f1f1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .gallery-actions {
            position: absolute;
            top: 6px;
            right: 6px;
        }

        .gallery-actions .btn {
            padding: 2px 6px;
            font-size: 12px;
        }

        .add-tile {
            border: 2px dashed #cfe3ff;
            background: #f7fbff;
            border-radius: 6px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .add-tile i {
            font-size: 40px;
            color: #0d6efd;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin'); ?>
<?php  $locale = Session::get('locale', config('app.locale')); ?>
    <section class="content-header">
       <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>
                <h1 class="m-0">Editing gallery for campaign: <?php echo e($campaign->title); ?></h1>
                <small class="text-muted">
                    Drag and drop the images to re-order the elements.
                </small>
                <ol class="m-0 mt-2 breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('campaign.gallery.index')); ?>">Gallery Editor</a></li>
                    <li class="breadcrumb-item active"><?php echo e($campaign->title); ?></li>
                </ol>
            </div>

            <div>
                <?php echo $__env->make('admin.layouts.locale', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

            <div class="card card-outline card-primary">
                <div class="card-body">

                    <div class="gallery-grid" id="galleryGrid">

                        <div class="add-tile" id="openUpload">
                            <div class="text-center">
                                <i class="fas fa-plus-circle"></i>
                                <div class="mt-2 font-weight-bold">Add Image</div>
                            </div>
                        </div>

                        <?php $__currentLoopData = $campaign->galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="gallery-item position-relative" data-id="<?php echo e($img->id); ?>">

                                <?php
                                    // title JSON হলে locale অনুযায়ী text বের করো
                                    $title = $img->title;
                                    if (is_string($title)) {
                                        $d = json_decode($title, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($d)) {
                                            $title = $d[app()->getLocale()] ?? ($d['en'] ?? reset($d));
                                        }
                                    } elseif (is_array($title)) {
                                        $title = $title[app()->getLocale()] ?? ($title['en'] ?? reset($title));
                                    }

                                    $seoSlug =
                                        $img->slug ?: \Illuminate\Support\Str::slug($title ?: 'gallery-' . $img->id);
                                    $ext = pathinfo($img->image, PATHINFO_EXTENSION) ?: 'jpg';

                                     // 🔥 Image URL একবার ভ্যারিয়েবল এ রাখলাম
                                    $imageUrl = route('gallery.image', [
                                        'campaignSlug' => $campaign->slug['en'] ?? $campaign->slug,
                                        'imageSlug' => $img->slug,
                                        'ext' => $ext,
                                    ]);
                                ?>

                                <img src="<?php echo e(route('gallery.image', [
                                      'campaignSlug' => $campaign->slug['en'] ?? $campaign->slug,
                                      'imageSlug' => $img->slug,
                                      'ext' => $ext,
                                    ])); ?>"
                                    alt="<?php echo e($title ?? ''); ?>" class="gallery-thumb">





                               
                                <div style="position:absolute; top:8px; left:8px; right:8px; display:flex; justify-content:space-between; align-items:center; pointer-events:auto;">
                                    
                                    
                                    <button type="button" class="btn btn-primary btn-sm"
                                        data-toggle="modal"
                                        data-target="#modal-default-<?php echo e($img->id); ?>">
                                        <i class="fas fa-pen"></i>
                                    </button>

                                    
                                    <a href="<?php echo e(route('gallery.image.details', ['slug' => $img->slug ?? $img->id])); ?>" target="_blank"
                                    class="btn btn-info btn-sm" title="Preview Image">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="confirmDelete(<?php echo e($img->id); ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                </div>

                            </div>

                            <?php echo $__env->make('admin.campaign_gallery.edit_modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <button class="btn btn-primary" id="btnAddNew">
                            <i class="fas fa-plus"></i> ADD NEW IMAGE
                        </button>

                        <button class="btn btn-success" id="btnSave">
                            <i class="fas fa-save"></i> SAVE CHANGES
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </section>

    
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <form class="modal-content" method="POST" action="<?php echo e(route('campaign.gallery.store', $campaign)); ?>"
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">Add New Image</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <div class="modal-body">

                    <?php $__currentLoopData = App\Models\Language::where('active', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($language->language_code === $locale): ?>
                        <div class="form-group">
                            <label>Title (<?php echo e($language->title); ?>)</label>
                            <input type="text" name="title[<?php echo e($language->language_code); ?>]" class="form-control"
                                required placeholder="Enter title <?php echo e($language->language_code); ?>">
                        </div>

                          <div class="form-group"> 
                                <label>Alt Text (<?php echo e($language->title); ?>)</label>
                                <input type="text" name="alt_text[<?php echo e($language->language_code); ?>]"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Captions (<?php echo e($language->title); ?>)</label>
                                <input type="text" name="caption[<?php echo e($language->language_code); ?>]"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Tags (<?php echo e($language->title); ?>)</label>
                                <input type="text" name="tags[<?php echo e($language->language_code); ?>]"
                                    class="form-control" required>
                            </div>

                        <div class="form-group">
                            <label>Description (<?php echo e($language->title); ?>)</label>
                            <textarea name="description[<?php echo e($language->language_code); ?>]" id="description" class="form-control" required
                                placeholder="Enter title <?php echo e($language->language_code); ?>"></textarea>
                        </div> 
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="form-group">
                        <label>Select image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small class="text-muted">Max 5MB</small>

                    </div>
                    <div class="form-group">
                        <label>Image SEO Url (Slug)</label>
                        <input type="text" name="slug" class="form-control" placeholder="e.g. sai-children" required>
                    </div>

                    <div class="form-group">
                        <label>Image Credit / Copyright</label>
                        <input type="text" name="credit_copyrights" class="form-control" value="<?php echo e($img->credit_copyrights); ?>" placeholder="Image Credit / Copyright" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>



    
    <?php $__currentLoopData = $campaign->galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <form id="deleteForm<?php echo e($img->id); ?>" method="POST"
            action="<?php echo e(route('campaign.gallery.destroy', [$campaign, $img])); ?>" style="display:none;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
        </form>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
    <script>
        const grid = document.getElementById('galleryGrid');

        new Sortable(grid, {
            animation: 150,
            draggable: '.gallery-item',
        });

        function confirmDelete(id) {
            if (confirm('Delete this image?')) {
                document.getElementById('deleteForm' + id).submit();
            }
        }

        function openUploadModal() {
            $('#uploadModal').modal('show');
        }

        document.getElementById('openUpload').addEventListener('click', openUploadModal);
        document.getElementById('btnAddNew').addEventListener('click', openUploadModal);

        document.getElementById('btnSave').addEventListener('click', async function() {
            const items = Array.from(grid.querySelectorAll('.gallery-item'));
            const orders = items.map((el, idx) => ({
                id: parseInt(el.dataset.id, 10),
                sort_order: idx + 1
            }));

            try {
                const res = await fetch("<?php echo e(route('campaign.gallery.reorder', $campaign)); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>",
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        orders
                    })
                });

                if (!res.ok) {
                    const err = await res.json().catch(() => ({
                        message: 'Save failed'
                    }));
                    alert(err.message || 'Save failed');
                    return;
                }
                alert('Saved successfully!');
            } catch (e) {
                alert('Network error');
            }
        });
    </script>


    <script>
        document.querySelectorAll('input[type="file"][name="image"]').forEach(input => {
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;
                const modalBody = this.closest('.modal-body');
                const preview = modalBody.querySelector('.edit-preview-img');
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/admin/campaign_gallery/edit.blade.php ENDPATH**/ ?>