@extends ('frontend.layouts.app')
@section('content')

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="index.html">home</a></li>
                            <li><a href="my-account.html">my account</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->


    <!-- my account start  -->
    <section class="main_content_area">
        <div class="container">
            <div class="account_dashboard">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <!-- Nav tabs -->
                        <div class="dashboard_tab_button">
                            <ul role="tablist" class="nav flex-column dashboard-list">
                                <li><a href="#dashboard" data-toggle="tab" class="nav-link active">Dashboard</a></li>
                                <li> <a href="#orders" data-toggle="tab" class="nav-link">Orders</a></li>
                                <li><a href="#address" data-toggle="tab" class="nav-link">Addresses</a></li>

                                <li><a href="{{ route('customer-logout') }}"  class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Log out
                                </a></li>
                                <form id="logout-form" action="{{ route('customer-logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade show active" id="dashboard">
                                <h3>Dashboard </h3>
                                <p>From your account dashboard. you can easily check &amp; view your <a href="#">recent orders</a>, manage your <a href="#">shipping and billing addresses</a> and <a href="#">Edit your password and account details.</a></p>
                            </div>
                            <div class="tab-pane fade" id="orders">
                                <h3>Orders</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Order Number</th>
                                                <th>Date of Order</th>
                                                <th>Order Status</th>
                                                <th>Total</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $key =>$item)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$item->order_number}}</td>
                                                    <td>{{$item->created_at}}</td>
                                                    <td>
                                                        @if($item->status == "confirmed")
                                                            <span class="success">Confirmed</span>
                                                        @elseif($item->status == "delivered")
                                                            <span class="success">Delivered</span>
                                                        @elseif($item->status == "cancelled")
                                                            <span class="success">Cancelled</span>
                                                        @else
                                                            <span class="success">Pending</span>
                                                        @endif

                                                    </td>
                                                    <td>Rs.{{$item->total_amount}}</td>
                                                    <td><button type="button" class="view-items" data-toggle="modal" data-target="#viewItems" data-id="{{$item->id}}">
                                                        View
                                                    </button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="address">
                               <p>The following addresses will be used on the checkout page by default.</p>
                                <h4 class="billing-address">Billing address</h4>

                                <p><strong>{{Auth::guard('customer')->user()->address}}</strong></p>

                                <a href="{{ route('edit-address', Auth::guard('customer')->user()->id) }}" class="btn btn-link btn-secondary btn-underline">Edit <i
                                    class="far fa-edit"></i></a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- my account end   -->
    <!-- View Order -->
    <div class="modal fade" id="viewItems" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLongTitle">List of Order Items</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Title</th>
                            <th>Rate</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody id="order_body">

                    </tbody>
                </table>
            </div>

        </div>
        </div>
    </div>
    <!-- View Order -->


@endsection

@push('scripts')

<script>
    $(document).on('click','.view-items',function(e){
       e.preventDefault();
       var order_id = Number($(this).data('id'));
       $.ajax({
           url: "{{route('view-order-items')}}",
           method: 'get',
           data: {
               _token: '{{csrf_token()}}',
               order_id: order_id,
           },
           success:function(response){
                if(typeof(response) != 'object'){
                    response = JSON.parse(response)
                }
                if(response.status){
                    var tbody_html = "";
                    $.each(response.data, function(key, order_items){
                        tbody_html += "<tr>";
                        tbody_html += "<td>"+order_items.name+"</td>";
                        tbody_html += "<td>"+order_items.rate+"</td>";
                        tbody_html += "<td>"+order_items.quantity+"</td>";
                        tbody_html += "<td>"+order_items.amount+"</td>";
                        tbody_html += "</tr>";
                    });
                    $('#order_body').html(tbody_html);
                    $('#viewItems').modal('show');
                }
            }
       })
   });
</script>
@endpush
