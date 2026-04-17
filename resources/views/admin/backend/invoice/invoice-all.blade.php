@extends('admin.admin_master')
@section('admin')


 <div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Order All</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->              
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('invoice.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right"><i class="fas fa-plus-circle">Add Order</i></a><br><br>
                        <h4 class="card-title">Order All Data </h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Customer Name</th>
                                <th>Order No</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>change status</th>
                                <th>Paid</th>
                                <th>Amount</th>
                                
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($allData as $key => $item)
                                <tr>
                                    <td> {{ $i++}} </td>
                                    <td> {{ $item['payment']['customer']['name'] }} </td>                          
                                    <td> {{ $item->invoice_no }} </td>                          
                                    <td> {{ date('d-m-Y', strtotime($item->date)) }} </td>                         
                                    <td> {{ $item->description }} </td>                        
                                    <td>
                                        <select class="form-control order-status"
                                                data-id="{{ $item->id }}">
                                            <option value="1" {{ $item->order_status == 1 ? 'selected' : '' }}>Pending</option>
                                            <option value="2" {{ $item->order_status == 2 ? 'selected' : '' }}>In progress</option>
                                            <option value="3" {{ $item->order_status == 3 ? 'selected' : '' }}>Shipping</option>
                                            <option value="4" {{ $item->order_status == 4 ? 'selected' : '' }}>Delivery</option>
                                            <option value="5" {{ $item->order_status == 5 ? 'selected' : '' }}>Complete</option>
                                        </select>
                                    </td>
                                    <td>
                                        @if($item->payment->paid_status == 'full_due')
                                        <a href="{{ route('admin.paid', $item->id) }}" class="btn btn-md btn-success">Click for Paid</a>
                                        @else
                                        <span class="btn btn-md btn-primary">Paid</span>
                                        @endif 
                                    </td>
                                                            
                                    <td> ৳ {{ $item['payment']['total_amount'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
</div>
 


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).on('change', '.order-status', function () {
  const invoiceId = $(this).data('id');
  const status    = $(this).val();

  $.ajax({
    url: "{{ url('/admin/invoice') }}/" + invoiceId + "/status",
    type: "POST",
    data: { order_status: status },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (res) {
      console.log(res.message);
      // চাইলে toast/alert দেখাতে পারো
    },
    error: function (xhr) {
      alert('Status update failed!');
      console.log(xhr.responseText);
    }
  });
});
</script>

@endsection