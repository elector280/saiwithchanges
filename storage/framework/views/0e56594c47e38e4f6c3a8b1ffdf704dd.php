<div class="modal fade" id="modal-default-<?php echo e($img->id); ?>">
  <div class="modal-dialog">
    <form class="modal-content" method="POST"
          action="<?php echo e(route('campaign.gallery.update', [$campaign, $img])); ?>"
          enctype="multipart/form-data">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>

      <div class="modal-header">
        <h5 class="modal-title">Edit Image</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">

        
        <div class="mb-3">
          <img src="<?php echo e(asset('storage/gallery_image/'.$img->image)); ?>"
               class="border rounded img-fluid edit-preview-img"
               style="width:100%; max-height:260px; object-fit:cover;">
        </div>

       <?php $__currentLoopData = App\Models\Language::where('active',1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($language->language_code === $locale): ?>
            <?php $langCode = $language->language_code;  ?>

            <div class="form-group">
                <label>Title (<?php echo e($language->title); ?>)</label>
                <input type="text"
                    name="title[<?php echo e($langCode); ?>]"
                    value="<?php echo e(old('title.' . $langCode, $img->getTitle($langCode))); ?>"
                    class="form-control" required>
            </div>

            <div class="form-group"> 
                <label>Alt Text (<?php echo e($language->title); ?>)</label>
                <input type="text" name="alt_text[<?php echo e($langCode); ?>]"
                    value="<?php echo e(old('alt_text.' . $langCode, $img->getDirectValue('alt_text', $langCode))); ?>"
                    class="form-control" required>
            </div>
            <div class="form-group">
                <label>Captions (<?php echo e($language->title); ?>)</label>
                <input type="text" name="caption[<?php echo e($langCode); ?>]"
                    value="<?php echo e(old('caption.' . $langCode, $img->getDirectValue('caption', $langCode))); ?>"
                    class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tags (<?php echo e($language->title); ?>)</label>
                <input type="text" name="tags[<?php echo e($langCode); ?>]"
                    value="<?php echo e(old('tags.' . $langCode, $img->getDirectValue('tags', $langCode))); ?>"
                    class="form-control" required>
            </div>

            <div class="form-group">
                <label>Description (<?php echo e($language->title); ?>)</label>
                <textarea name="description[<?php echo e($langCode); ?>]"
                        class="form-control" required><?php echo e(old('description.' . $langCode, $img->getDescription($langCode))); ?></textarea>
            </div>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>




        <div class="form-group">
          <label>Replace image (optional)</label>
          <input type="file" name="image" class="form-control" accept="image/*">
          <small class="text-muted">Max 5MB (leave empty to keep current)</small>
        </div>
        <div class="form-group">
            <label>Image SEO Url (Slug)</label>
            <input type="text" name="slug" class="form-control" value="<?php echo e($img->slug); ?>" placeholder="e.g. sai-children" required>
        </div>

        <div class="form-group">
            <label>Image Credit / Copyright</label>
            <input type="text" name="credit_copyrights" class="form-control" value="<?php echo e($img->credit_copyrights); ?>" placeholder="Image Credit / Copyright" required>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>

    </form>
  </div>
</div>
<?php /**PATH /home/saingo/public_html/resources/views/admin/campaign_gallery/edit_modal.blade.php ENDPATH**/ ?>