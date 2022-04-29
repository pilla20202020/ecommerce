@extends('backend.layouts.admin.admin')

@section('title', 'Orders')

@section('content')
<section>
    <div class="section-body">
        <div class="card">
            <div class="card-head">
                <header class="text-capitalize">Orders</header>
               
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mr-3 mb-3" data-toggle="modal" data-target="#paymentModal">
                    Update Payment Status
                </button>
                <table id="example" class="table table-hover display">
                    <thead>
                    <tr>
                        <th width="5%">SN</th>
                        <th width="15%">Order Number</th>
                        <th width="15%">Customer Name</th>
                        <th width="15%">Phone</th>
                        <th width="15%">Total Amount</th>
                        <th width="15%">Date of Order</th>
                        <th width="15%">Payment Method</th>
                        <th width="15%">Payment Status</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $key =>$order)
                        <tr>
                            <td class="text-center pt-2">
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" name="ordercheckbox" data-checkboxes="mygroup" class="custom-control-input" id="{{$order->id}}" value="{{$order->id}}">
                                    <label for="{{$order->id}}" class="custom-control-label">&nbsp;</label>
                                </div>
                            </td>
                            <td>{{$order->order_number}}</td>
                            <td>{{$order->customer->name}}</td>
                            <td>{{$order->customer->phone}}</td>
                            <td>Rs.{{$order->total_amount}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->payment_method}}</td>
                            <td>{{$order->payment_status}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Payment Status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">                               
                <div class="form-group col-12">
                    <select  name="payment_status" class="form-control paymentstatus" required>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary btn-orderstatus">Save changes</button>
        </div>
      </div>
    </div>
  </div>

@stop

@push('scripts')
<script>
    $(document).ready(function() {
        $('.btn-orderstatus').on('click',function() {
            var order = [];
            var incr=0;
            $('input[name="ordercheckbox"]:checked').each(function() {
                if (this.checked) {
                    order[incr]=(this.value);
                    incr++;
                }
            
            });
            var paymentstatus = $('.paymentstatus').val();

            $.ajax({
                url: "{{route('update-payment-status')}}",
                method: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    order_id: order,
                    paymentstatus: paymentstatus,
                },
                success:function(data){
                    window.location.reload();
                }
                
            })
        })
    });
</script>
@endpush