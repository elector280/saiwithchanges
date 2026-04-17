@extends('admin.layouts.master')

@section('css')
<style>
  .db-table-name{ font-weight:600; }
  .btn-xs{ padding:.2rem .45rem; font-size:.78rem; }
  .modal-body{ max-height: 70vh; overflow:auto; }
</style>
@endsection

@section('admin')

<div class="content-header">
  <div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <h1 class="m-0">Database</h1>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Database</li>
        </ol>
      </div>

      <div>
        <!-- <a href="javascript:void(0)" class="btn btn-success btn-sm">
          <i class="fas fa-plus mr-1"></i> Create New Table
        </a> -->
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
      <div class="card-header">
        <h3 class="card-title">
          <i class="fas fa-database mr-1"></i> Database Tables
        </h3>
      </div>

      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover table-striped mb-0">
            <thead class="thead-light">
              <tr>
                <th style="width:60%;">Table Name</th>
                <th class="text-right">Table Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($tables as $t)
                <tr>
                  <td>
                    <a href="javascript:void(0)" class="db-table-name"
                       onclick="openTable('{{ $t }}')">
                      {{ $t }}
                    </a>
                  </td>

                  <td class="text-right">
                    <button type="button"
                            class="btn btn-warning btn-xs"
                            onclick="openTable('{{ $t }}')">
                      <i class="far fa-eye mr-1"></i> View
                    </button>

                    {{--
                    <button type="button"
                            class="btn btn-info btn-xs"
                            onclick="openTable('{{ $t }}')">
                      <i class="far fa-edit mr-1"></i> Edit
                    </button>

                    <form action="{{ route('admin.database.destroy', $t) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete table: {{ $t }} ?');">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger btn-xs" type="submit">
                        <i class="far fa-trash-alt mr-1"></i> Delete
                      </button>
                    </form>
                    --}}
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="2" class="text-center text-muted py-5">No tables found.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</section>

{{-- ✅ Table Fields Modal (like screenshot) --}}
<div class="modal fade" id="modalTable" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white">
          <i class="fas fa-table mr-2"></i>
          <span id="modalTableName">table</span>
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div id="tableLoading" class="text-center text-muted py-4" style="display:none;">
          <i class="fas fa-spinner fa-spin mr-1"></i> Loading...
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-sm mb-0">
            <thead class="thead-light">
              <tr>
                <th>Field</th>
                <th>Type</th>
                <th>Null</th>
                <th>Key</th>
                <th>Default</th>
                <th>Extra</th>
              </tr>
            </thead>
            <tbody id="modalColumnsBody">
              {{-- injected by js --}}
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

@endsection

@section('js')
<script>
  async function openTable(tableName){
    $('#modalTable').modal('show');
    document.getElementById('modalTableName').innerText = tableName;

    const body = document.getElementById('modalColumnsBody');
    const loading = document.getElementById('tableLoading');
    body.innerHTML = '';
    loading.style.display = 'block';

    try {
      const url = `{{ url('/admin/database/table') }}/${encodeURIComponent(tableName)}`;
      const res = await fetch(url, { headers: { 'Accept': 'application/json' }});
      const data = await res.json();

      loading.style.display = 'none';

      if(!res.ok || !data.ok){
        body.innerHTML = `<tr><td colspan="6" class="text-center text-danger">
            ${data.message || 'Failed to load table.'}
          </td></tr>`;
        return;
      }

      if(!data.columns || data.columns.length === 0){
        body.innerHTML = `<tr><td colspan="6" class="text-center text-muted">No columns found.</td></tr>`;
        return;
      }

      const rows = data.columns.map(c => {
        const nul = (c.is_nullable === 'YES') ? 'YES' : 'NO';
        const key = c.col_key || '';
        const def = (c.col_default === null || typeof c.col_default === 'undefined') ? '' : c.col_default;
        const extra = c.extra || '';
        return `
          <tr>
            <td>${escapeHtml(c.field)}</td>
            <td>${escapeHtml(c.type)}</td>
            <td>${nul}</td>
            <td>${escapeHtml(key)}</td>
            <td>${escapeHtml(String(def))}</td>
            <td>${escapeHtml(extra)}</td>
          </tr>
        `;
      }).join('');

      body.innerHTML = rows;

    } catch (e) {
      loading.style.display = 'none';
      body.innerHTML = `<tr><td colspan="6" class="text-center text-danger">Error loading table.</td></tr>`;
    }
  }

  function escapeHtml(str){
    return String(str)
      .replaceAll('&', '&amp;')
      .replaceAll('<', '&lt;')
      .replaceAll('>', '&gt;')
      .replaceAll('"', '&quot;')
      .replaceAll("'", '&#039;');
  }
</script>
@endsection
