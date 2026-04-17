


<?php $__env->startSection('css'); ?>
<style>

</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin'); ?>
<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h1 class="m-0">Media</h1>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="<?php echo e(url('/admin')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">
            <a href="<?php echo e(route('admin.media.index')); ?>">Media</a>
          </li>
          <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="breadcrumb-item">
              <a href="<?php echo e(route('admin.media.index', ['folder_id' => $bc->id])); ?>"><?php echo e($bc->name); ?></a>
            </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <?php if(session('success')): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?php echo e(session('success')); ?>

        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-header">
        <div class="d-flex flex-wrap" style="gap:8px;">
          <button class="btn btn-primary btn-sm" id="btnUpload">
            <i class="fas fa-cloud-upload-alt mr-1"></i> Upload
          </button>

          <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#modalFolder">
            <i class="far fa-folder mr-1"></i> Add Folder
          </button>

          <button class="btn btn-outline-secondary btn-sm" id="btnMove" disabled>
            <i class="fas fa-arrows-alt mr-1"></i> Move
          </button>

          <button class="btn btn-outline-danger btn-sm" id="btnDelete" disabled>
            <i class="far fa-trash-alt mr-1"></i> Delete
          </button>

          <button class="btn btn-outline-secondary btn-sm" id="btnRefresh">
            <i class="fas fa-sync mr-1"></i>
          </button>
        </div>
      </div>

      <div class="card-body">
        <div class="row">
          
          <div class="col-lg-9">
            <div class="border rounded p-2" style="min-height:480px;">
              <div class="text-muted mb-2">Media Library</div>

              <div class="row">
                <?php $__currentLoopData = $folders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-3 col-sm-4 col-6 mb-3">
                    <div class="media-item border rounded p-2 h-100"
                        style="cursor:pointer;"
                        onclick="openFolder(<?php echo e($f->id); ?>, event)">
                      <div class="d-flex align-items-center">
                        <i class="fas fa-folder fa-2x text-secondary mr-2"></i>
                        <div class="flex-grow-1">
                          <div class="font-weight-bold text-truncate"><?php echo e(Str::limit($f->name, 18)); ?></div>
                          <div class="text-muted small">Folder</div>
                        </div>
                      </div>

                      <a class="stretched-link-"
                         href="<?php echo e(route('admin.media.index', ['folder_id' => $f->id])); ?>"></a>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-3 col-sm-4 col-6 mb-3">
                    <div class="media-item border rounded p-2 h-100"
                         data-type="file" data-id="<?php echo e($file->id); ?>"
                         style="cursor:pointer;"
                         onclick="selectItem(event, 'file', <?php echo e($file->id); ?>)">
                      <?php if($file->isImage()): ?>
                        <img src="<?php echo e(asset('storage/'.$file->path)); ?>" class="img-fluid rounded" style="height:110px; width:100%; object-fit:cover;">
                      <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center bg-light rounded"
                             style="height:110px;">
                          <i class="far fa-file fa-3x text-secondary"></i>
                        </div>
                      <?php endif; ?>
                      <div class="mt-2 text-truncate small"><?php echo e($file->original_name); ?></div>
                      <div class="text-muted small"><?php echo e(number_format($file->size/1024, 0)); ?> KB</div>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if($folders->count()===0 && $files->count()===0): ?>
                  <div class="col-12">
                    <div class="text-center text-muted py-5">
                      No items found in this folder.
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>

          
          <div class="col-lg-3">
            <div class="border rounded p-2" style="min-height:480px;">
              <div class="text-muted mb-2">Details</div>

              <div id="previewBox" class="text-center mb-2">
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:180px;">
                  <i class="fas fa-info-circle fa-2x text-muted"></i>
                </div>
              </div>

              <div class="form-group">
                <label class="small mb-1">Title</label>
                <input class="form-control form-control-sm" id="detailTitle" readonly>
              </div>

              <div class="small text-muted">
                <div><span class="font-weight-bold">Type:</span> <span id="detailType">-</span></div>
                <div><span class="font-weight-bold">Size:</span> <span id="detailSize">-</span></div>
                <div><span class="font-weight-bold">Public URL:</span> <a href="#" target="_blank" id="detailUrl" style="word-break:break-all;">-</a></div>
                <div><span class="font-weight-bold">Last Modified:</span> <span id="detailUpdated">-</span></div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</section>


<div class="modal fade" id="modalFolder" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="<?php echo e(route('admin.media.folder.create')); ?>">
      <?php echo csrf_field(); ?>
      <input type="hidden" name="parent_id" value="<?php echo e($folderId); ?>">
      <div class="modal-header">
        <h5 class="modal-title">Create Folder</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Folder Name</label>
          <input name="name" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" type="submit">Create</button>
      </div>
    </form>
  </div>
</div>


<input type="file" id="uploadInput" multiple class="d-none" />


<div class="modal fade" id="modalMove" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Move Item</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Destination Folder</label>
          <select class="form-control" id="moveTarget">
            <option value="">Root</option>
            <?php $__currentLoopData = $allFolders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $af): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($af->id); ?>"><?php echo e($af->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
        <div class="text-muted small">Selected item will be moved.</div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary" id="confirmMove">Move</button>
      </div>
    </div>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
  let selected = null; // {type, id}
  let currentUrl = '';

  // ✅ same as: asset('storage/'.$file->path)
  const STORAGE_BASE = `<?php echo e(asset('storage')); ?>`;

  function setButtons(enabled){
    document.getElementById('btnMove').disabled = !enabled;
    document.getElementById('btnDelete').disabled = !enabled;
  }

  function openFolder(folderId, e){
    if (e) {
      e.preventDefault();
      e.stopPropagation();
    }
    window.location.href = `<?php echo e(route('admin.media.index')); ?>?folder_id=${folderId}`;
  }

  async function selectItem(e, type, id){
    e.preventDefault();
    e.stopPropagation();

    // highlight
    document.querySelectorAll('.media-item').forEach(el => el.classList.remove('border-primary'));
    e.currentTarget.classList.add('border-primary');

    selected = {type, id};
    setButtons(true);

    const res = await fetch(`<?php echo e(url('/admin/media/item')); ?>/${type}/${id}`);
    const data = await res.json();

    document.getElementById('detailTitle').value = data.title || '';
    document.getElementById('detailType').innerText = data.mime || data.type || '-';
    document.getElementById('detailSize').innerText = data.size ? Math.round(data.size/1024) + ' KB' : '-';
    document.getElementById('detailUpdated').innerText = data.updated_at || '-';

    // ✅ build url like your grid
    let fileUrl = '';
    if (data.path) fileUrl = `${STORAGE_BASE}/${data.path}`;

    // public url text
    const urlEl = document.getElementById('detailUrl');
    if (fileUrl) {
      currentUrl = fileUrl;
      urlEl.href = fileUrl;
      urlEl.innerText = 'Copy Link'; // you wanted copy link
    } else {
      currentUrl = '';
      urlEl.href = '#';
      urlEl.innerText = '-';
    }

    // copy link on click
    urlEl.onclick = function(ev){
      if (!currentUrl) return;
      ev.preventDefault();
      copyText(currentUrl);
    };

    // preview
    const previewBox = document.getElementById('previewBox');
    if (fileUrl && (data.mime || '').startsWith('image/')) {
      previewBox.innerHTML = `<img src="${fileUrl}" class="img-fluid rounded"
                              style="max-height:180px; width:100%; object-fit:contain;">`;
    } else {
      previewBox.innerHTML = `<div class="bg-light rounded d-flex align-items-center justify-content-center"
                              style="height:180px;">
                                <i class="far fa-file fa-3x text-muted"></i>
                              </div>`;
    }
  }

  function copyText(text){
    if (navigator.clipboard && window.isSecureContext) {
      navigator.clipboard.writeText(text);
      alert('Link copied');
      return;
    }
    // fallback
    const temp = document.createElement('input');
    temp.value = text;
    document.body.appendChild(temp);
    temp.select();
    document.execCommand('copy');
    document.body.removeChild(temp);
    alert('Link copied');
  }

  document.getElementById('btnRefresh').addEventListener('click', () => location.reload());

  // Upload
  document.getElementById('btnUpload').addEventListener('click', () => {
    document.getElementById('uploadInput').click();
  });

  document.getElementById('uploadInput').addEventListener('change', async (e) => {
    const files = e.target.files;
    if (!files.length) return;

    const fd = new FormData();
    fd.append('folder_id', '<?php echo e($folderId); ?>'); // root হলে backend 0->null করবে
    for (const f of files) fd.append('files[]', f);
    fd.append('_token', '<?php echo e(csrf_token()); ?>');

    const res = await fetch(`<?php echo e(route('admin.media.upload')); ?>`, { method:'POST', body: fd });
    // if (!res.ok) {
    //   alert('Upload failed.');
    //   return;
    // }
    location.reload();
  });

  

  // Move
  document.getElementById('btnMove').addEventListener('click', () => {
    if (!selected) return;
    $('#modalMove').modal('show');
  });

  document.getElementById('confirmMove').addEventListener('click', async () => {
    if (!selected) return;

    const fd = new FormData();
    fd.append('_token', '<?php echo e(csrf_token()); ?>');
    fd.append('type', selected.type);
    fd.append('id', selected.id);
    fd.append('target_folder_id', document.getElementById('moveTarget').value);

    const res = await fetch(`<?php echo e(route('admin.media.move')); ?>`, { method:'POST', body: fd });
    const data = await res.json().catch(()=>({ok:false}));

    if (!res.ok || !data.ok) {
      alert(data.message || 'Move failed.');
      return;
    }
    location.reload();
  });

  // Delete
  document.getElementById('btnDelete').addEventListener('click', async () => {
    if (!selected) return;
    if (!confirm('Are you sure you want to delete this item?')) return;

    const res = await fetch(`<?php echo e(route('admin.media.delete')); ?>`, {
      method: 'DELETE',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
      body: JSON.stringify(selected),
    });
    const data = await res.json().catch(()=>({ok:false}));

    if (!res.ok || !data.ok) {
      alert(data.message || 'Delete failed.');
      return;
    }
    location.reload();
  });

  setButtons(false);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/saingo/public_html/resources/views/admin/media/index.blade.php ENDPATH**/ ?>