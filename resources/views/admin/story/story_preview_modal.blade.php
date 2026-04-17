<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-eye mr-1"></i> Preview Before Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-lg-8">
            <div class="border rounded p-3">
              <h3 id="pvTitle" class="mb-2"></h3>
              <p id="pvShort" class="text-muted mb-3"></p>
              <div id="pvDesc" class="border-top pt-3 overflow-hidden"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="border rounded p-3">
              <div class="mb-2"><strong>Status:</strong> <span id="pvStatus"></span></div>
              <div class="mb-2"><strong>Slug:</strong> <span id="pvSlug"></span></div>
              <div class="mb-2"><strong>Published:</strong> <span id="pvPublished"></span></div>
              <div class="mb-2"><strong>SEO Title:</strong> <div class="text-muted" id="pvSeoTitle"></div></div>
              <div class="mb-2"><strong>Meta Desc:</strong> <div class="text-muted" id="pvMetaDesc"></div></div>
              <div class="mb-2"><strong>Tags:</strong> <span id="pvTags"></span></div>

              <div class="mt-3">
                <strong>Featured Image (selected):</strong>
                <div class="mt-2">
                  <img id="pvImage" src="" alt="" style="max-width:100%;border-radius:8px;display:none;">
                  <div id="pvImageEmpty" class="text-muted">No new image selected</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="confirmUpdate" class="btn btn-primary">
          <i class="fas fa-save mr-1"></i> Confirm save
        </button>
      </div>

    </div>
  </div>
</div>