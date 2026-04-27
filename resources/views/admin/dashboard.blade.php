@extends('admin.layouts.master')




@section('admin')

@if(session('success'))
  <div class="alert alert-success">
    {{ session('success') }}
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger">
    {{ session('error') }}
  </div>
@endif


<div class="container-fluid">
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>{{ $slider_count }}</h3>

          <p> Sliders </p> 
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="{{ route('sliders.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3>{{ $story_count }}</h3>

          <p> Reports </p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{ route('stories.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3>{{ $sponsor_count }}</h3>

          <p>Images</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="{{ route('sponsors.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>{{ $campaign_count }}</h3>

          <p>Pages</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="{{ route('campaigns.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>

  <!-- Sentry Issues Panel -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card card-danger card-outline">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-exclamation-triangle text-danger"></i> 
            Recent Sentry Errors ({{ config('services.sentry_api.project_slug', 'saingo') }})
          </h3>
          <div class="card-tools">
            <a href="https://sentry.io/organizations/{{ config('services.sentry_api.org_slug', 'malcacorp') }}/issues/?project={{ config('services.sentry_api.project_slug', 'php-laravel-f8') }}" target="_blank" class="btn btn-sm btn-outline-danger">
              View All in Sentry <i class="fas fa-external-link-alt"></i>
            </a>
          </div>
        </div>
        <div class="card-body p-0">
          @if(isset($sentry_issues) && is_array($sentry_issues) && count($sentry_issues) > 0)
            <div class="table-responsive">
              <table class="table table-striped table-valign-middle m-0">
                <thead>
                  <tr>
                    <th>Issue</th>
                    <th>Events</th>
                    <th>Users Affected</th>
                    <th>First Seen</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sentry_issues as $issue)
                  <tr>
                    <td>
                      <div class="d-flex flex-column">
                        <span class="text-bold text-danger">{{ $issue['title'] ?? 'Unknown Error' }}</span>
                        <span class="text-muted text-sm text-truncate" style="max-width: 400px;" title="{{ $issue['culprit'] ?? '' }}">{{ $issue['culprit'] ?? '' }}</span>
                      </div>
                    </td>
                    <td>
                      <span class="badge bg-warning text-dark">{{ $issue['count'] ?? 0 }}</span>
                    </td>
                    <td>
                      <span class="badge bg-info">{{ $issue['userCount'] ?? 0 }}</span>
                    </td>
                    <td>
                      <span class="text-muted text-sm">
                        {{ isset($issue['firstSeen']) ? \Carbon\Carbon::parse($issue['firstSeen'])->diffForHumans() : 'N/A' }}
                      </span>
                    </td>
                    <td>
                      <a href="{{ $issue['permalink'] ?? '#' }}" target="_blank" class="btn btn-sm btn-default">
                        View <i class="fas fa-arrow-right"></i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @else
            <div class="p-4 text-center text-muted">
              <i class="fas fa-check-circle text-success mb-2" style="font-size: 2.5rem;"></i>
              <h5>All clear!</h5>
              <p>No recent unresolved errors found, or Sentry is currently unreachable.</p>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

{{--
 <form action="{{ route('campaign.gallery.migrate.old') }}"
      method="POST"
      onsubmit="return confirm('This will migrate ALL old gallery data. Continue?')">
    @csrf
    <button type="submit" class="btn btn-warning mb-3">
        <i class="fas fa-database"></i>
        Migrate Old Data
    </button>
</form>
--}}
</div>

@endsection 