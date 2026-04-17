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
                            <form method="post" action="{{ route('product.update', $product->id) }}" id="myForm"
                                enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id" value="{{ $product->id }}">

                                 <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Type</label>
                                    <div class="form-group col-sm-10">
                                        <select name="type" id="" class="form-control" required>
                                            <option value="" disabled selected>Select type</option>
                                            <option value="best_selling" {{ $product->type == 'best_selling' ? 'selected' : ''}}> Best sellings</option>
                                            <option value="features_product" {{ $product->type == 'features_product' ? 'selected' : ''}}> Feature Products </option>
                                            <option value="new_arrival" {{ $product->type == 'new_arrival' ? 'selected' : ''}}> New Arrivals</option>
                                        </select>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Product Name </label>
                                    <div class="form-group col-sm-10">
                                        <input name="name" value="{{ $product->name }}" class="form-control"
                                            type="text" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end row -->

                                
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Short description</label>
                                    <div class="form-group col-sm-10">
                                        <textarea name="short_description" class="form-control" rows="2" >{{ old('short_description', $product->short_description) }}</textarea>
                                        @error('short_description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Product Details</label>
                                    <div class="form-group col-sm-10">
                                        <textarea name="product_details" id="summernote" class="form-control" rows="5" required>{{ old('product_details', $product->product_details) }}</textarea>
                                        @error('product_details')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Product Price</label>
                                    <div class="form-group col-sm-10">
                                        <input name="price" value="{{ $product->price }}" class="form-control"
                                            type="number" required>
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
                                            value="{{ $product->selling_price }}" required>
                                        @error('selling_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Old Price</label>
                                    <div class="form-group col-sm-10">
                                        <input name="old_price" class="form-control" type="number"
                                            placeholder="Enter Amount [0-999999, and max 2 digits after decimal point]"
                                            value="{{ $product->old_price }}" required>
                                        @error('old_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Current Image</label>
                                    <div class="form-group col-sm-10">
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                            class="img-thumbnail" width="150">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Upload New Image</label>
                                    <div class="form-group col-sm-10">
                                        <input type="file" class="form-control" id="image" name="image"
                                            placeholder="Upload Image">
                                        @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Product Gallery Image</label>
                                    <div class="col-sm-10">

                                        {{-- Existing gallery images --}}
                                        @if(isset($product) && $product->images && $product->images->count())
                                            <div class="d-flex flex-wrap gap-2 mb-2">
                                                @foreach($product->images as $img)
                                                    <div class="border rounded p-2 text-center" style="width:110px;" id="imgBox{{ $img->id }}">
                                                        <img src="{{ asset($img->gallery_image) }}" class="img-fluid rounded"
                                                            style="height:100px; object-fit:cover; width:100%;" alt="gallery">

                                                        <div class="form-check mt-2">
                                                            <a href="javascript:void(0)"
                                                            class="form-check-label small text-danger fw-semibold galleryDeleteLink"
                                                            data-id="{{ $img->id }}">
                                                                Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Add new gallery images --}}
                                        <input name="gallery_image[]" class="form-control" type="file" multiple>

                                        @error('gallery_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('gallery_image.*')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                        <div class="form-text">
                                            JPG/PNG/WEBP, max 2MB per image.
                                        </div>
                                    </div>
                                </div>


                                {{-- ===================== CURRENT REVIEWS (Show) ===================== --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">
                                        Current Reviews
                                    </label>

                                    <div class="col-sm-10">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 60px;" class="text-center">#</th>
                                                        <th style="width: 160px;">Image</th>
                                                        <th style="width: 200px;">Name</th>
                                                        <th style="width: 50px;">Rating</th>
                                                        <th>Text</th>
                                                        <th style="width: 140px;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                @forelse ($reviews as $k => $review)
                                                    <tr id="reviewRow{{ $review->id }}">
                                                        <td class="text-center">{{ $k + 1 }}</td>

                                                        <td>
                                                            @if($review->review_image)
                                                                <img src="{{ asset($review->review_image) }}" class="img-thumbnail" width="120" alt="review">
                                                            @else
                                                                <span class="text-muted small">No image</span>
                                                            @endif
                                                        </td>

                                                        <td><div class="fw-semibold">{{ $review->user_name }}</div></td>
                                                        <td><div class="fw-semibold">{{ $review->rating }}</div></td>
                                                        <td><div class="text-muted">{{ $review->text }}</div></td>

                                                        <td class="text-center">
                                                            <a href="javascript:void(0)"
                                                            class="text-danger fw-semibold reviewDeleteLink"
                                                            data-url="{{ route('reviews.destroy', $review->id) }}"
                                                            data-id="{{ $review->id }}">
                                                                delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted">No reviews found.</td>
                                                    </tr>
                                                @endforelse
                                                </tbody>

                                            </table>
                                        </div>

                                        <div class="text-muted small">
                                            * Tick “Delete” to remove existing reviews on update.
                                        </div>
                                    </div>
                                </div>


                                {{-- ===================== ADD NEW REVIEWS (Dynamic Table) ===================== --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">
                                        Add New Reviews
                                    </label>

                                    <div class="col-sm-10">
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle mb-0" id="reviewTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width: 20%;">Name</th>
                                                        <th style="width: 10%;">Rating</th>
                                                        <th style="width: 25%;">Profile Image (PNG/JPG/WEBP)</th>
                                                        <th>Text</th>
                                                        <th style="width: 130px;" class="text-center">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="reviewTbody">
                                                    <tr class="review-row">
                                                        <td>
                                                            <input type="text" name="user_name[]" class="form-control"
                                                                placeholder="Enter name">
                                                        </td>
                                                        <td>
                                                            <input type="number" name="rating[]" class="form-control" placeholder="Max-5"  min="1" max="5">
                                                        </td>

                                                        <td>
                                                            <input type="file" name="profile[]" class="form-control" accept="image/*">
                                                        </td>

                                                        <td>
                                                            <input type="text" name="text[]" class="form-control"
                                                                placeholder="Write review text">
                                                        </td>

                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-success btn-sm add-row">+</button>
                                                            <button type="button" class="btn btn-danger btn-sm remove-row ms-1">-</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Array validation error show (optional) --}}
                                        @error('user_name.*')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                        @error('text.*')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        @error('profile.*')
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
                                                <option value="{{ $supp->id }}"
                                                    {{ $supp->id == $product->supplier_id ? 'selected' : '' }}>
                                                    {{ $supp->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Unit Name </label>
                                    <div class="col-sm-10">
                                        <select name="unit_id" class="form-select" aria-label="Default select example"
                                            required>
                                            <option selected="">Open this select menu</option>
                                            @foreach ($unit as $uni)
                                                <option value="{{ $uni->id }}"
                                                    {{ $uni->id == $product->unit_id ? 'selected' : '' }}>
                                                    {{ $uni->name }}</option>
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
                                        <select name="category_id" class="form-select"
                                            aria-label="Default select example" required>
                                            <option selected="">Open this select menu</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}"
                                                    {{ $cat->id == $product->category_id ? 'selected' : '' }}>
                                                    {{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end row -->
                                <input type="submit" class="btn btn-info waves-effect waves-light"
                                    value="Update Product">
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
                    mobile_no: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                },
                messages: {
                    name: {
                        required: 'Please Enter Your Name',
                    },
                    mobile_no: {
                        required: 'Please Enter Your Mobile no',
                    },
                    email: {
                        required: 'Please Enter Your Email',
                    },
                    address: {
                        required: 'Please Enter Your Address',
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

            function createRow() {
                const tr = document.createElement("tr");
                tr.className = "review-row";
                tr.innerHTML = `
                    <td>
                        <input type="text" name="user_name[]" class="form-control" placeholder="Enter name">
                    </td>
                    <td>
                        <input type="text" name="rating[]" class="form-control" placeholder="Max 5">
                    </td>
                    <td>
                        <input type="file" name="profile[]" class="form-control" accept="image/*">
                    </td>
                    <td>
                        <input type="text" name="text[]" class="form-control" placeholder="Write review text">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm add-row">+</button>
                        <button type="button" class="btn btn-danger btn-sm remove-row ms-1">-</button>
                    </td>
                `;
                return tr;
            }

            tbody.addEventListener("click", function (e) {
                const addBtn = e.target.closest(".add-row");
                const removeBtn = e.target.closest(".remove-row");

                if (addBtn) {
                    tbody.appendChild(createRow());
                }

                if (removeBtn) {
                    const rows = tbody.querySelectorAll(".review-row");
                    const current = removeBtn.closest(".review-row");

                    // last row remove prevent (optional)
                    if (rows.length > 1) {
                        current.remove();
                    } else {
                        current.querySelectorAll("input").forEach(i => i.value = "");
                    }
                }
            });
        });
    </script>
<script>
const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.addEventListener('click', async (e) => {
    const link = e.target.closest('.galleryDeleteLink');


    if (!link) return;

    const id = link.dataset.id;
    if (!confirm('Are you sure you want to delete this image?')) return;

    const url = `{{ url('/admin/product/gallery-image') }}/${id}`;

    try {
        const res = await fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
            }
        });

        if (!res.ok) {
            alert('Delete failed!');
            return;
        }

        // remove from UI
        const box = document.getElementById('imgBox' + id);
        if (box) box.remove();

    } catch (err) {
        console.error(err);
        alert('Something went wrong!');
    }
});
</script>

<script>
document.addEventListener('click', async (e) => {
  const link = e.target.closest('.reviewDeleteLink');
  if (!link) return;

  e.preventDefault(); // ✅ stop navigation

  const url = link.dataset.url;
  const id  = link.dataset.id;

  if (!url || !id) {
    alert('Delete URL/ID missing!');
    return;
  }

  if (!confirm('Are you sure you want to delete this review?')) return;

  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  const csrf = csrfMeta ? csrfMeta.getAttribute('content') : null;

  try {
    const res = await fetch(url, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json'
      }
    });

    // ✅ handle CSRF/session expired
    if (res.status === 419) {
      alert('Session expired. Please refresh the page.');
      return;
    }

    const data = await res.json().catch(() => ({}));

    if (!res.ok || data.ok !== true) {
      alert(data.message || 'Delete failed!');
      return;
    }

    // remove row
    const row = document.getElementById('reviewRow' + id);
    if (row) row.remove();

  } catch (err) {
    console.error(err);
    alert('Network/Error occurred!');
  }
});
</script>


@endsection
