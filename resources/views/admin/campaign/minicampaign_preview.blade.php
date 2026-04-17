<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-eye mr-1"></i> Preview Mini Campaign</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <div class="row">

          <div class="col-lg-8">
            <div class="border rounded p-3">
              <h3 id="pvTitle" class="mb-2"></h3>
              <div class="text-muted mb-2"><strong>Slug:</strong> <span id="pvSlug"></span></div>
              <div class="text-muted mb-3"><strong>CTA URL:</strong> <a id="pvCta" href="#" target="_blank" rel="noopener noreferrer"></a></div>

              <hr>

              <div class="mb-3">
                <div class="font-weight-bold mb-1">Short Description</div>
                <div id="pvShort"  class="border-top pt-3 overflow-hidden"></div>
              </div>

              <div class="mb-3">
                <div class="font-weight-bold mb-1">Paragraph One</div>
                <div id="pvP1"  class="border-top pt-3 overflow-hidden"></div>
              </div>

              <div class="mb-3">
                <div class="font-weight-bold mb-1">Paragraph Two</div>
                <div id="pvP2"  class="border-top pt-3 overflow-hidden"></div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="border rounded p-3">
              <div class="mb-2"><strong>Status:</strong> <span id="pvStatus"></span></div>
              <div class="mb-2"><strong>Start:</strong> <span id="pvStart"></span></div>
              <div class="mb-2"><strong>End:</strong> <span id="pvEnd"></span></div>

              <hr>

              <div class="mb-2">
                <strong>Cover Image:</strong>
                <div class="mt-2">
                  <img id="pvCoverImg" style="max-width:100%;border-radius:8px;display:none;">
                  <div id="pvCoverEmpty" class="text-muted">No cover image selected</div>
                </div>
              </div>

              <div class="mt-3">
                <strong>OG Image:</strong>
                <div class="mt-2">
                  <img id="pvOgImg" style="max-width:100%;border-radius:8px;display:none;">
                  <div id="pvOgEmpty" class="text-muted">No OG image selected</div>
                </div>
              </div>

              <hr>

              <div class="mb-2"><strong>Meta Title:</strong> <div id="pvMetaTitle" class="text-muted"></div></div>
              <div class="mb-2"><strong>Meta Desc:</strong> <div id="pvMetaDesc" class="text-muted"></div></div>
              <div class="mb-2"><strong>OG Title:</strong> <div id="pvOgTitle" class="text-muted"></div></div>
              <div class="mb-2"><strong>OG Desc:</strong> <div id="pvOgDesc" class="text-muted"></div></div>
              <div class="mb-2"><strong>Canonical:</strong> <div id="pvCanonical" class="text-muted"></div></div>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="confirmSave" class="btn btn-primary">
          <i class="fas fa-save mr-1"></i> Confirm Save
        </button>
      </div>

    </div>
  </div>
</div>

<style>
/* ✅ Summernote HTML preview overflow fix */
#pvShort, #pvP1, #pvP2 {
  overflow: hidden;
  word-wrap: break-word;
}
#pvShort img, #pvP1 img, #pvP2 img {
  max-width: 100% !important;
  height: auto !important;
  display: block;
}
</style>
