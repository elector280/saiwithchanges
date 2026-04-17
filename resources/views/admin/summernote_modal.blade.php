
<div class="modal fade" id="snImageModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:640px;">
    <div class="modal-content">
      <div class="modal-header py-2">
        <h5 class="modal-title mb-0">Insert/edit image</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Source</label>
          <div class="col-sm-9">
            <div class="input-group">
              <input type="text" id="sn_src" class="form-control" placeholder="https://...">

              <div class="input-group-append">
                <button type="button" class="btn btn-outline-secondary" id="sn_pick_btn" title="Browse">
                  <i class="fa fa-folder-open"></i>
                </button>
              </div>
            </div>

            <!-- hidden file input -->
            <input type="file" id="sn_file" accept="image/*" style="display:none;">
          </div>
        </div>


        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Image description</label>
          <div class="col-sm-9">
            <input type="text" id="sn_alt" class="form-control" placeholder="Alt text">
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Image Title</label>
          <div class="col-sm-9">
            <input type="text" id="sn_title" class="form-control" placeholder="Title">
          </div>
        </div>

        <div class="form-group row align-items-center">
          <label class="col-sm-3 col-form-label">Dimensions</label>
          <div class="col-sm-9">
            <div class="form-row align-items-center">
              <div class="col-4">
                <input type="number" id="sn_w" class="form-control" placeholder="W">
              </div>
              <div class="col-auto px-2">×</div>
              <div class="col-4">
                <input type="number" id="sn_h" class="form-control" placeholder="H">
              </div>
              <div class="col-auto">
                <div class="form-check ml-2">
                  <input class="form-check-input" type="checkbox" id="sn_keep_ratio" checked>
                  <label class="form-check-label" for="sn_keep_ratio">Constrain proportions</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 col-form-label">Caption</label>
          <div class="col-sm-9">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="sn_caption">
              <label class="form-check-label" for="sn_caption">Enable caption</label>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer py-2">
        <button type="button" class="btn btn-primary" id="sn_ok">Ok</button>
        <button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


