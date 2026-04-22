<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SAI | @yield('title', 'Dashboard') </title>


  <link rel="icon" type="image/png" href="{{ asset('storage/favicon/'.$setting->favicon) }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('backend-asset') }}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('backend-asset') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('backend-asset') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('backend-asset') }}/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backend-asset') }}/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('backend-asset') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('backend-asset') }}/plugins/daterangepicker/daterangepicker.css">
  <!-- TinyMCE -->

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('backend-asset/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend-asset/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('backend-asset/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">


  <!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<style>
* {
    font-family: anthropicSans, "anthropicSans Fallback", system-ui, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}
/* Force horizontal scroll */
.dataTables_wrapper {
    width: 100%;
    overflow-x: auto;
}

table.dataTable {
    width: 100% !important;
}

 /* Select2 height fix */
    .select2-container--default .select2-selection--single {
        height: 38px !important; /* Bootstrap default */
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    /* Text vertically center */
    .select2-container--default .select2-selection--single 
    .select2-selection__rendered {
        line-height: 24px;
    }

    /* Arrow center */
    .select2-container--default .select2-selection--single 
    .select2-selection__arrow {
        height: 36px;
    }

    
    label {
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #374151
    }

    .table-label {
        font-size: 14px !important;
        font-weight: 500 !important;
        color: #374151
    }

    .main-page-heading{
        font-size: 18px !important;
        font-weight: 600 !important;
        color: #374151
    }
    .header-title{
        font-size: 16px !important;
        font-weight: 600 !important;
        color: #374151
    }

    

        
        .seo-divider {
    position: relative;
    text-align: center;
    margin: 12px 0 20px 0;
}

.seo-divider::before,
.seo-divider::after {
    content: '';
    position: absolute;
    top: 50%;
    width: calc(50% - 35px);
    height: .5px;
    background-color: #cbbaba; /* AdminLTE danger color */
    transform: translateY(-50%);
}

.seo-divider::before {
    left: 0;
}

.seo-divider::after {
    right: 0;
}

.seo-divider span {
    display: inline-block;
    position: relative;
    z-index: 1;
    padding: 0 12px;
    background: #fff; /* card-body bg */
    color: #6c757d;
    font-size: 11px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1px;
    line-height: 1;
}

</style>

  @yield('css')


</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('images/logo/logo.png') }}" alt="AdminLTELogo" height="60" width="60">
  </div>
  

    @include('admin.layouts.navbar')


    @include('admin.layouts.aside')




  <div class="content-wrapper">
    <section class="content">

      @yield('admin')

    </section>
  </div>


    @include('admin.layouts.footer')

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('backend-asset') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('backend-asset') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backend-asset') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{ asset('backend-asset') }}/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{ asset('backend-asset') }}/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{ asset('backend-asset') }}/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{ asset('backend-asset') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('backend-asset') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ asset('backend-asset') }}/plugins/moment/moment.min.js"></script>
<script src="{{ asset('backend-asset') }}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('backend-asset') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- TinyMCE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        tinymce.init({
            selector: '.summernote, .tinymce, #summernote',
            height: 400,
            plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
            toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | image | help',
            content_style: 'body { font-family: anthropicSans, "anthropicSans Fallback", system-ui, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; font-size: 14px; }',
            images_upload_url: '{{ route("tinymce.upload") }}',
            automatic_uploads: true,
            relative_urls: false,
            remove_script_host: false,
            document_base_url: '{{ url("/") }}/',
            file_picker_types: 'image',
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        });
    });
</script>
<!-- overlayScrollbars -->
<script src="{{ asset('backend-asset') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend-asset') }}/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('backend-asset') }}/dist/js/pages/dashboard.js"></script>

<script src="{{ asset('backend-asset/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>


<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- Select2 -->
<script src="{{ asset('backend-asset/plugins/select2/js/select2.full.min.js') }}"></script>

<!-- donor box -->
<script src="https://donorbox.org/widget.js" paypalExpress="true"></script>

<script>
$(document).ready(function () {
    $('.dataTable').DataTable({
        scrollX: true,          // 🔥 horizontal scroll
        autoWidth: false,
        responsive: false,      // ❌ responsive OFF (scroll ব্যবহার করবো)
        pageLength: 10,
    });
});
</script>


<script>
  $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        })
    })

</script>


<script>
    $(document).on('click', '.js-delete-btn', function () {
        let form = $(this).closest('.delete-form');
        let name = $(this).data('name');

        Swal.fire({
            title: 'Are you sure?',
            html: 'You want to delete <b>' + name + '</b>?<br>This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                confirmButton: 'btn btn-danger ml-2',
                cancelButton: 'btn btn-default'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>


@yield('js')

</body>
</html>
