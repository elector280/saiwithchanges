@extends('admin.layouts.master')
@section('admin')

    <div class="py-4 container-fluid">

        {{-- Header --}}
        <div class="mb-3 d-flex align-items-center justify-content-between">
            <div class="gap-3 d-flex align-items-center">
                <i class="fas fa-bars text-muted fa-2x"></i>

                <h4 class="mb-0 font-weight-bold text-secondary">
                    Menu Builder ({{ $menu->name ?? 'primary' }})
                </h4>

                <a href="javascript:void(0)" class="btn btn-success font-weight-bold" id="btnOpenAddModal">
                    <i class="mr-2 fas fa-plus"></i> New Menu Item
                </a>
            </div>

            <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary btn-sm font-weight-bold">EN</button>
                <button type="button" class="text-white btn btn-info btn-sm font-weight-bold">ES</button>
            </div>
        </div>

        {{-- How To Use --}}
        <div class="mb-4 alert alert-primary" style="border-radius:8px;">
            <h5 class="mb-1 font-weight-bold">How To Use:</h5>
            <div>
                You can output this menu anywhere on your site by calling
                <code class="px-2 py-1 ml-1 text-white" style="background:#e74c3c;border-radius:6px;">
                    menu('{{ $menu->slug ?? 'primary' }}')
                </code>
            </div>
        </div>

        {{-- Instruction --}}
        <div class="pb-3 mb-3 border-bottom">
            <p class="mb-0 text-secondary" style="opacity:.6;font-style:italic;font-size:18px;">
                Drag and drop the menu items below to re-arrange them.
            </p>
        </div>

        {{-- Menu List --}}
        <div class="shadow-sm card">
            <div class="card-body">

                @if ($menu && $menu->items && $menu->items->count())
                    <div id="menu-sortable" class="d-flex flex-column" style="gap:12px;">

                        @foreach ($menu->items as $item)
                            <div class="bg-white border rounded" data-id="{{ $item->id }}">

                                <div class="p-3 d-flex align-items-center justify-content-between menu-handle"
                                    style="cursor:move;user-select:none;">
                                    <div class="d-flex align-items-center" style="gap:10px;">
                                        <span class="font-weight-bold text-uppercase">{{ $item->label }}</span>
                                        <small class="text-muted text-uppercase">{{ $item->label }}</small>
                                    </div>

                                    <div class="d-flex" style="gap:8px;">
                                        <a href="javascript:void(0)"
                                            class="btn btn-primary btn-sm font-weight-bold btn-edit-item"
                                            data-id="{{ $item->id }}" data-label="{{ $item->label }}"
                                            data-url="{{ $item->url }}" data-route="{{ $item->route_name }}">
                                            <i class="mr-1 fas fa-edit"></i> Edit
                                        </a>




                                        <button type="button"
                                            class="btn btn-danger btn-sm font-weight-bold btn-delete-item"
                                            data-id="{{ $item->id }}">
                                            <i class="mr-1 fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>

                                {{-- Children --}}
                                <div class="px-3 pb-3">
                                    <div class="ml-0 ml-md-5 d-flex flex-column child-sortable"
                                        data-parent="{{ $item->id }}" style="gap:10px;">

                                        @if ($item->children && $item->children->count())
                                            @foreach ($item->children as $child)
                                                <div class="p-3 bg-white border rounded d-flex align-items-center justify-content-between menu-handle"
                                                    data-id="{{ $child->id }}" style="cursor:move;user-select:none;">

                                                    <div class="d-flex align-items-center" style="gap:10px;">
                                                        <span class="font-weight-bold">{{ $child->label }}</span>
                                                        <small class="text-muted"
                                                            style="font-style:italic;">{{ $child->label }}</small>
                                                    </div>

                                                    <div class="d-flex" style="gap:8px;">
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-primary btn-sm font-weight-bold btn-edit-item"
                                                            data-id="{{ $child->id }}" data-label="{{ $child->label }}"
                                                            data-url="{{ $item->url }}"
                                                            data-route="{{ $item->route_name }}">
                                                            <i class="mr-1 fas fa-edit"></i> Edit
                                                        </a>

                                                        <button type="button"
                                                            class="btn btn-danger btn-sm font-weight-bold btn-delete-item"
                                                            data-id="{{ $child->id }}">
                                                            <i class="mr-1 fas fa-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <button id="saveOrderBtn" type="button" class="btn btn-dark">Save Order</button>
                        <span id="save_msg" class="ml-2 small"></span>
                    </div>
                @else
                    <div class="mb-0 alert alert-warning">No menu items found.</div>
                @endif

            </div>
        </div>

        {{-- ADD MODAL (Bootstrap 4) --}}
        <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Menu Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="add_menu_id" value="{{ $menu->id ?? '' }}">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>Label *</label>
                                <input type="text" class="form-control" id="add_label" placeholder="e.g. About Us">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Parent</label>
                                <select class="form-control" id="add_parent_id">
                                    <option value="">Root</option>
                                    @if ($menu && $menu->items)
                                        @foreach ($menu->items as $root)
                                            <option value="{{ $root->id }}">{{ $root->label }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>URL</label>
                                <input type="text" class="form-control" id="add_url" placeholder="/reports">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Route Name</label>
                                <input type="text" class="form-control" id="add_route_name"
                                    placeholder="users.index">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Route Params</label>
                                <input type="text" class="form-control" id="add_route_params" placeholder='{"id":1}'>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Icon</label>
                                <input type="text" class="form-control" id="add_icon" placeholder="fas fa-home">
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Active</label>
                                <select class="form-control" id="add_is_active">
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div id="add_msg" class="small"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success font-weight-bold" id="btnCreateItem">Save</button>
                    </div>

                </div>
            </div>
        </div>

        {{-- EDIT MODAL (Bootstrap 4) --}}
        <div class="modal fade" id="editItemModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Menu Item</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="edit_item_id">
                        <div class="mb-3">
                            <label>Label</label>
                            <input type="text" class="form-control" id="edit_item_label" placeholder="e.g. About Us">
                        </div>

                        <div class="mb-3">
                            <label>URL</label>
                            <input type="text" class="form-control" id="edit_item_url" placeholder="/reports">
                        </div>

                        <div class="mb-3">
                            <label>Route Name</label>
                            <input type="text" class="form-control" id="edit_item_routename"
                                placeholder="users.index">
                        </div>
                        <div id="edit_msg" class="small"></div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary font-weight-bold" id="btnUpdateItem">Save</button>
                    </div>

                </div>
            </div>
        </div>

        {{-- DELETE MODAL (Bootstrap 4) --}}
        <div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title text-danger">Delete Menu Item</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete this item?
                        <input type="hidden" id="delete_item_id">
                        <div id="delete_msg" class="mt-2 small"></div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-danger font-weight-bold" id="btnConfirmDelete">Yes, Delete</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        $(function() {

            const CSRF = $('meta[name="csrf-token"]').attr('content');

            const STORE_URL = "menu-items/store";
            const UPDATE_URL = "menu-items/update";
            const DELETE_URL = "menu-items/delete";
            const SAVEORDER_URL = "menu-items/save-order";

            // ===== DRAG ROOT =====
            const rootEl = document.getElementById('menu-sortable');
            if (rootEl) {
                new Sortable(rootEl, {
                    animation: 150,
                    draggable: '> div',
                    handle: '.menu-handle',
                    ghostClass: 'bg-light'
                });
            }

            // ===== DRAG CHILD =====
            document.querySelectorAll('.child-sortable').forEach(function(childEl) {
                new Sortable(childEl, {
                    animation: 150,
                    draggable: '> div',
                    handle: '.menu-handle',
                    ghostClass: 'bg-light',
                    group: {
                        name: 'children',
                        pull: true,
                        put: true
                    }
                });
            });

            function buildOrderPayload() {
                const payload = [];
                if (!rootEl) return payload;

                Array.from(rootEl.children).forEach((rootWrapper, rootIndex) => {
                    const rootId = rootWrapper.getAttribute('data-id');
                    if (!rootId) return;

                    payload.push({
                        id: parseInt(rootId),
                        parent_id: null,
                        sort_order: rootIndex + 1
                    });

                    const childContainer = rootWrapper.querySelector('.child-sortable');
                    if (childContainer) {
                        Array.from(childContainer.children).forEach((childItem, childIndex) => {
                            const childId = childItem.getAttribute('data-id');
                            if (!childId) return;
                            payload.push({
                                id: parseInt(childId),
                                parent_id: parseInt(rootId),
                                sort_order: childIndex + 1
                            });
                        });
                    }
                });

                return payload;
            }

            // ===== SAVE ORDER =====
            $('#saveOrderBtn').on('click', function() {
                $('#save_msg').html('Saving...');

                $.ajax({
                    url: SAVEORDER_URL,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        items: buildOrderPayload()
                    }),
                    success: function() {
                        $('#save_msg').html('<span class="text-success">Saved!</span>');
                    },
                    error: function(xhr) {
                        $('#save_msg').html('<span class="text-danger">Save failed</span>');
                        console.log(xhr.responseText);
                    }
                });
            });

            // ===== OPEN ADD MODAL =====
            $('#btnOpenAddModal').on('click', function() {
                $('#add_msg').html('');
                $('#add_label').val('');
                $('#add_url').val('');
                $('#add_route_name').val('');
                $('#add_route_params').val('');
                $('#add_icon').val('');
                $('#add_parent_id').val('');
                $('#add_is_active').val('1');
                $('#addItemModal').modal('show');
            });

            // ===== CREATE ITEM =====
            $('#btnCreateItem').on('click', function() {
                const payload = {
                    menu_id: $('#add_menu_id').val(),
                    label: $('#add_label').val(),
                    parent_id: $('#add_parent_id').val() || null,
                    url: $('#add_url').val() || null,
                    route_name: $('#add_route_name').val() || null,
                    route_params: $('#add_route_params').val() || null,
                    icon: $('#add_icon').val() || null,
                    is_active: $('#add_is_active').val()
                };

                $.ajax({
                    url: STORE_URL,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    success: function() {
                        $('#add_msg').html(
                            '<div class="text-success">Created! Reloading...</div>');
                        setTimeout(() => window.location.reload(), 400);
                    },
                    error: function(xhr) {
                        $('#add_msg').html('<div class="text-danger">Create failed</div>');
                        console.log(xhr.responseText);
                    }
                });
            });

            // ===== OPEN EDIT MODAL =====
            $(document).on('click', '.btn-edit-item', function() {
                $('#edit_msg').html('');

                $('#edit_item_id').val($(this).data('id'));
                $('#edit_item_label').val($(this).data('label') || '');
                $('#edit_item_url').val($(this).data('url') || '');
                $('#edit_item_routename').val($(this).data('route') || '');

                $('#editItemModal').modal('show');
            });


            // ===== UPDATE ITEM =====
            $('#btnUpdateItem').on('click', function() {
                const payload = {
                    id: $('#edit_item_id').val(),
                    label: $('#edit_item_label').val(),
                    url: $('#edit_item_url').val(),
                    route_name: $('#edit_item_routename').val()
                };

                $.ajax({
                    url: UPDATE_URL,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    success: function() {
                        $('#edit_msg').html(
                            '<div class="text-success">Updated! Reloading...</div>');
                        setTimeout(() => window.location.reload(), 400);
                    },
                    error: function(xhr) {
                        $('#edit_msg').html('<div class="text-danger">Update failed</div>');
                        console.log(xhr.responseText);
                    }
                });
            });

            // ===== OPEN DELETE MODAL =====
            $(document).on('click', '.btn-delete-item', function() {
                $('#delete_msg').html('');
                $('#delete_item_id').val($(this).data('id'));
                $('#deleteItemModal').modal('show');
            });

            // ===== CONFIRM DELETE =====
            $('#btnConfirmDelete').on('click', function() {
                const payload = {
                    id: $('#delete_item_id').val()
                };

                $.ajax({
                    url: DELETE_URL,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    success: function() {
                        $('#delete_msg').html(
                            '<div class="text-success">Deleted! Reloading...</div>');
                        setTimeout(() => window.location.reload(), 400);
                    },
                    error: function(xhr) {
                        $('#delete_msg').html('<div class="text-danger">Delete failed</div>');
                        console.log(xhr.responseText);
                    }
                });
            });

        });
    </script>
@endsection
