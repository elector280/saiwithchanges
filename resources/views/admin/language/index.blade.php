 @extends('admin.layouts.master')

@section('css')
  {{--    switch button--}}
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

@endsection


@section('admin')
 <br>
    <!-- Main content -->
    <section class="content">
      {{-- <div class="row justify-content-center">
         <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                  <h5>Default Language</h5>
              </div>
                <div class="card-body">
                <form class="form-horizontal" action="{{ route('admin.envKeyUpdate')}}" method="POST">
                    @csrf
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-8">
                          <select class="form-control" name="DEFAULT_LANGUAGE" data-selected="{{ env('DEFAULT_LANGUAGE') }}">
                                @foreach ($activeLanguages as $key => $language)
                                    <option value="{{ $language->language_code }}" @if(env('DEFAULT_LANGUAGE') == $language->language_code) selected @endif>
                                        {{ $language->title }}
                                    </option>
                                @endforeach
                            </select>
                              </div>
                              <div class="col-md-4">
                                <button type="submit" class="btn btn-info">Save</button>
                            </div>
                          </div>
                    </div>
                </form>
            </div>
            </div>
         </div>
      </div> --}}
      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Languages</h3>  

          <div class="card-tools">
             {{-- <a class="btn btn-primary btn-xs" href="{{ route('admin.languageCreate')}}">Add new Language</a> --}}
          </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered nowrap dataTable">
                <thead>
                  <tr>
                    <th style="width: 10px">#SL</th>
                    <th>Action</th>
                    <th>Tilte</th>
                    <th>Language Code</th>
                    <th>Country flag</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = (($languages->currentPage() - 1) * $languages->perPage() + 1); ?>
                  @foreach($languages as $lng)
                  <tr>
                    <td style="width: 10px">{{$i++}}</td>
                    <td style="width: 80px">
                        <div class="dropdown show">
                          <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </a>

                          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                              <a href="{{ route('admin.languageTranslatoins',$lng)}}" title="Tranlation" class="dropdown-item"><i class="fa fa-language"></i> Tranlation</a>
                              
                              <a title="Edit" href="{{ route('admin.languageEdit',$lng) }}" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                              {{--
                              <form action="{{ route('admin.languageDelete',$lng) }}" method="post" onclick="return confirm('Are you sure to delete?')">
                                @csrf
                                <button type="submit" title="Delete"  class="dropdown-item"><i class="fa fa-trash"></i> Delete</button>
                              </form>  
                              --}}
                          </div>
                    </td>
                    <td>{{$lng->title}}</td>
                    <td>{{$lng->language_code}}</td>
                   
                    <td>
                      @if($lng->country_flag)
                      <img src="{{ asset('storage/country_flag/'.$lng->country_flag) }}" style="height:40px;border-radius:6px;">
                      @else
                      <span class="text-muted">No image</span>
                      @endif
                    </td>
                    <td>
                        <input type="checkbox" name="toogle" data-size="small" data-url="{{route('admin.languageStatus')}}" value="{{ $lng->id }}" data-toggle="toggle" data-size="sm" {{$lng->active==1 ? 'checked' : '' }} data-on="On"  data-off="Off" data-onstyle="success" data-offstyle="danger">
                    </td>
                  </tr>  
                  @endforeach
                </tbody>
               </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          {{$languages->render()}}
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->

@endsection 


@section('js')
{{--switch--}}
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>

    <script>
        $( document ).ready(function() {
            $('input[name=toogle]').change(function(){
                var that = $( this );
                var url  = that.attr('data-url');
                var id   = that.val()
                var mode = that.prop('checked');
                $.ajax({
                    url : url,
                    type: "POST",
                    data:{
                        _token:'{{csrf_token()}}',
                        mode:mode,
                        id:id,
                    },
                    success:function(response){
                        if(response.status){
                            alert(response.msg);
                        }
                        else{
                            alert('please try again');
                        }
                    }
                })
            });
        });
    </script>
@endsection 