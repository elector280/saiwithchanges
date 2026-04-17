<!-- Preview Modal -->
<style>
    /* Preview content wrapper (Summernote HTML) */
    #pvSummary, #pvStandard, #pvProblem, #pvSolution, #pvImpact, #pvDesc {
        overflow: hidden;
        word-wrap: break-word;
    }

    /* Make all images responsive inside preview */
    #pvSummary img, #pvStandard img, #pvProblem img, #pvSolution img, #pvImpact img, #pvDesc img {
        max-width: 100% !important;
        height: auto !important;
        display: block;
    }

    /* Prevent tables/iframes from overflowing */
    #pvSummary table, #pvStandard table, #pvProblem table, #pvSolution table, #pvImpact table, #pvDesc table {
        width: 100% !important;
    }

    #pvSummary iframe, #pvStandard iframe, #pvProblem iframe, #pvSolution iframe, #pvImpact iframe, #pvDesc iframe {
        max-width: 100% !important;
    }

</style>
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-eye mr-1"></i> Preview Before Save</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">

        <div class="row">
          <div class="col-lg-8">
            <div class="border rounded p-3">
              <h3 id="pvTitle" class="mb-2"></h3>
              <div class="text-muted mb-3" id="pvSubTitle"></div>

              <hr>

              <div class="mb-3">
                <div class="font-weight-bold mb-1">Summary</div>
                <div id="pvSummary" class="border-top pt-3 overflow-hidden"></div>
              </div>

              <div class="mb-3">
                <div class="font-weight-bold mb-1">Standard Webpage Content</div>
                <div id="pvStandard" class="border-top pt-3 overflow-hidden"></div>
              </div>

              <div class="mb-3">
                <div class="font-weight-bold mb-1">Problem</div>
                <div id="pvProblem" class="border-top pt-3 overflow-hidden"></div>
              </div>

              <div class="mb-3">
                <div class="font-weight-bold mb-1">Solution</div>
                <div id="pvSolution" class="border-top pt-3 overflow-hidden"></div>
              </div>

              <div class="mb-3">
                <div class="font-weight-bold mb-1">Impact</div>
                <div id="pvImpact class="border-top pt-3 overflow-hidden""></div>
              </div>

              <div class="mb-3">
                <div class="font-weight-bold mb-1">Google Description</div>
                <div id="pvGoogleDesc" class="text-muted"></div>
              </div>

              <div class="mb-3">
                <div class="font-weight-bold mb-1">Short Description</div>
                <div id="pvShortDesc" class="text-muted"></div>
              </div>

            </div>
          </div>

          <div class="col-lg-4">
            <div class="border rounded p-3">
              <div class="mb-2"><strong>Slug:</strong> <span id="pvSlug"></span></div>
              <div class="mb-2"><strong>Type:</strong> <span id="pvType"></span></div>
              <div class="mb-2"><strong>Show Home:</strong> <span id="pvShowHome"></span></div>
              <div class="mb-2"><strong>Status:</strong> <span id="pvStatus"></span></div>
              <div class="mb-2"><strong>Navbar:</strong> <span id="pvNavbar"></span></div>
              <div class="mb-2"><strong>Position:</strong> <span id="pvPosition"></span></div>
              <div class="mb-2"><strong>Footer Color:</strong> <span id="pvBgColor"></span></div>

              <hr>

              <div class="mb-2"><strong>SEO Title:</strong> <div id="pvSeoTitle" class="text-muted"></div></div>
              <div class="mb-2"><strong>SEO Description:</strong> <div id="pvSeoDesc" class="text-muted"></div></div>

              <hr>

              <div class="mt-2">
                <strong>Hero Image (selected):</strong>
                <div class="mt-2">
                  <img id="pvHeroImg" src="" alt="" style="max-width:100%;border-radius:8px;display:none;">
                  <div id="pvHeroImgEmpty" class="text-muted">No image selected</div>
                </div>
              </div>
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
<?php /**PATH /home/saingo/public_html/resources/views/admin/canpaign/preview.blade.php ENDPATH**/ ?>