@extends('admin.layouts.master')

@section('css')
<style>
  .btn-xs{ padding:.18rem .55rem; font-size:.78rem; border-radius:.18rem; }
  .table td, .table th{ vertical-align: middle; }
  .table-name a{ color:#2a78d1; text-decoration:none; font-weight:600; }
  .table-name a:hover{ text-decoration:underline; }
  .bread-actions .btn{ margin-right:6px; }
  .table-actions .btn{ margin-left:6px; }

  /* Bread button colors like reference */
  .btn-bread-browse{ background:#f0ad4e; color:#fff; border-color:#f0ad4e; }
  .btn-bread-browse:hover{ background:#ec971f; border-color:#ec971f; color:#fff; }

  .btn-bread-edit{ background:#f7f7f7; border:1px solid #dcdcdc; color:#6c757d; }
  .btn-bread-edit:hover{ background:#ececec; color:#343a40; }

  .btn-bread-delete{ background:#d9534f; border-color:#d9534f; color:#fff; }
  .btn-bread-delete:hover{ background:#c9302c; border-color:#c9302c; color:#fff; }

  .btn-add-bread{ background:#fff; border:1px solid #e5e5e5; color:#6c757d; }
  .btn-add-bread:hover{ background:#f8f9fa; color:#343a40; }

  .thead-light th{ font-weight:600; }
  .page-title-icon{ font-size:28px; margin-right:10px; color:#6c757d; }
</style>
@endsection

@section('admin')

<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h1 class="m-0">
          <i class="fas fa-bread-slice page-title-icon"></i>
          BREAD
        </h1>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Bread</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
    @endif

    <div class="card">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead class="thead-light">
              <tr>
                <th style="width:55%;">Table Name</th>
                <th class="text-right" style="width:45%;">BREAD/CRUD Actions</th>
              </tr>
            </thead>

            <tbody>
              @forelse($tables as $t)
                @php $hasBread = in_array($t, $breadTables ?? []); @endphp

                <tr>
                  <td class="table-name">
                    <a href="javascript:void(0)">{{ $t }}</a>
                  </td>


                  <td class="text-right" style="white-space:nowrap;">
                    @if($hasBread)
                        @php $browseRoute = $breadRoutes[$t] ?? null; @endphp

                        @if($browseRoute && \Illuminate\Support\Facades\Route::has($browseRoute))
                            <a href="{{ route($browseRoute) }}" class="btn btn-xs btn-bread-browse">
                            <i class="fas fa-list mr-1"></i> Browse
                            </a>
                        @else
                            <span class="text-danger small">Browse route not set</span>
                        @endif
                        @else
                        <button type="button" class="btn btn-xs btn-add-bread">
                            <i class="fas fa-plus mr-1"></i> Add BREAD to this table
                        </button>
                    @endif
                  </td>
                </tr>

              @empty
                <tr>
                  <td colspan="2" class="text-center text-muted py-5">
                    No tables found.
                  </td>
                </tr>
              @endforelse
            </tbody>

          </table>
        </div>
      </div>
    </div>

  </div>
</section>

@endsection
