@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h2 class="m-0">Add Product Page</h2>

                            <div class="card-tools">
                                <a href="{{ route('product.all') }}" class="btn btn-sm btn-primary">Product list</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('product.store') }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Type</label>
                                    <div class="form-group col-sm-10">
                                        <select name="type" id="" class="form-control">
                                            <option value="" disabled selected>Select type</option>
                                            <option value="best_selling"> Best sellings</option>
                                            <option value="features_product"> Feature Products </option>
                                            <option value="new_arrival"> New Arrivals</option>
                                        </select>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Product Name</label>
                                    <div class="form-group col-sm-10">
                                        <input name="name" class="form-control" type="text" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Short description</label>
                                    <div class="form-group col-sm-10">
                                        {{-- <input name="short_description" class="form-control" type="text"> --}}
                                        <textarea name="short_description" class="form-control" rows="2" required></textarea>
                                        @error('short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Product Details</label>
                                    <div class="form-group col-sm-10">
                                        {{-- <input name="product_details" class="form-control" type="text"> --}}
                                        <textarea name="product_details" id="summernote" class="form-control" rows="5" required></textarea>
                                        @error('product_details')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Product Price</label>
                                    <div class="form-group col-sm-10">
                                        <input name="price" class="form-control" type="number" required>
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Selling Price</label>
                                    <div class="form-group col-sm-10">
                                        <input name="selling_price" class="form-control" type="number"
                                            placeholder="Enter Amount [0-999999, and max 2 digits after decimal point]"
                                            required>
                                        @error('selling_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Old Price</label>
                                    <div class="form-group col-sm-10">
                                        <input name="old_price" class="form-control" type="number"
                                            placeholder="Enter Amount [0-999999, and max 2 digits after decimal point]">
                                        @error('old_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Product Image</label>
                                    <div class="form-group col-sm-10">
                                        <input name="image" class="form-control" type="file" required>
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="gallery_image" class="col-sm-2 col-form-label">Product Galllery Image</label>
                                    <div class="form-group col-sm-10">
                                        <input name="gallery_image[]" class="form-control" type="file" id="gallery_image" multiple>
                                        @error('gallery_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                               <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Reviews</label>

                                    <div class="col-sm-10">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle mb-0" id="reviewTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20%;">Name</th>
                                                        <th style="width: 10%;">Rating</th>
                                                        <th style="width: 25%;">Profile (Image)</th>
                                                        <th>Text</th>
                                                        <th style="width: 120px;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="reviewTbody">
                                                    <!-- Default Row -->
                                                    <tr class="review-row">
                                                        <td>
                                                            <input type="text" name="user_name[]" class="form-control" placeholder="Enter user name" >
                                                        </td>
                                                        <td>
                                                            <input type="number" name="rating[]" class="form-control" placeholder="Max-5 "  min="1" max="5">
                                                        </td>

                                                        <td>
                                                            <input type="file" name="profile[]" class="form-control" accept="image/*" >
                                                        </td>

                                                        <td>
                                                            <input type="text" name="text" class="form-control" placeholder="Write review text" >
                                                        </td>

                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-success btn-sm add-row">
                                                                + <!-- or <i class="bi bi-plus-lg"></i> -->
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm remove-row ms-1">
                                                                - <!-- or <i class="bi bi-dash-lg"></i> -->
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Example error (optional): you can customize validation keys in controller) --}}
                                        @error('name.*')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                        @error('profile.*')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        @error('text.*')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Supplier Name </label>
                                    <div class="col-sm-10">
                                        <select name="supplier_id" class="form-select" aria-label="Default select example"
                                            required>
                                            <option selected="">Open this select menu</option>
                                            @foreach ($supplier as $supp)
                                                <option value="{{ $supp->id }}">{{ $supp->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Unit Name </label>
                                    <div class="col-sm-10">
                                        <select name="unit_id" class="form-select" aria-label="Default select example"
                                            required>
                                            <option selected="">Open this select menu</option>
                                            @foreach ($unit as $uni)
                                                <option value="{{ $uni->id }}">{{ $uni->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('unit_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Category Name </label>
                                    <div class="col-sm-10">
                                        <select name="category_id" class="form-select" aria-label="Default select example"
                                            required>
                                            <option selected="">Open this select menu</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end row -->
                                <!-- end row -->
                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Product">
                            </form>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>




    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    supplier_id: {
                        required: true,
                    },
                    unit_id: {
                        required: true,
                    },
                    category_id: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Your Product Name',
                    },
                    supplier_id: {
                        required: 'Please Select One Supplier',
                    },
                    unit_id: {
                        required: 'Please Select One Unit',
                    },
                    category_id: {
                        required: 'Please Select One Category',
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tbody = document.getElementById("reviewTbody");

            // create a new row template
            function createRow() {
                const tr = document.createElement("tr");
                tr.className = "review-row";
                tr.innerHTML = `
                    <td>
                        <input type="text" name="user_name[]" class="form-control" placeholder="Enter user name" required>
                    </td>
                    <td>
                        <input type="text" name="rating[]" class="form-control" placeholder="Max - 5" required min="1" max="5">
                    </td>
                    <td>
                        <input type="file" name="profile[]" class="form-control" accept="image/*" required>
                    </td>
                    <td>
                        <input type="text" name="text[]" class="form-control" placeholder="Write review text" required>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm add-row">+</button>
                        <button type="button" class="btn btn-danger btn-sm remove-row ms-1">-</button>
                    </td>
                `;
                return tr;
            }

            // Event delegation for add/remove buttons
            tbody.addEventListener("click", function (e) {
                const addBtn = e.target.closest(".add-row");
                const removeBtn = e.target.closest(".remove-row");

                if (addBtn) {
                    tbody.appendChild(createRow());
                }

                if (removeBtn) {
                    const rows = tbody.querySelectorAll(".review-row");
                    const currentRow = removeBtn.closest(".review-row");

                    // prevent removing the last row (optional safety)
                    if (rows.length > 1) {
                        currentRow.remove();
                    } else {
                        // If you want: just clear inputs instead of removing last row
                        currentRow.querySelectorAll("input").forEach(input => {
                            input.value = "";
                        });
                    }
                }
            });
        });
    </script>


@endsection
