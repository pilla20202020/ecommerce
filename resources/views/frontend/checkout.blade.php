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
                        <li><a href="{{route('checkout')}}">checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>         
</div>
<!--breadcrumbs area end-->


<!--Checkout page section-->
<div class="Checkout_section">
   <div class="container">
        <div class="row">
           <div class="col-12">
                <div class="user-actions">
                    <h3> 
                        
                        <i class="fa fa-file-o" aria-hidden="true"></i>
                        Returning customer?
                        <a class="Returning" href="#" data-toggle="collapse" data-target="#checkout_login" aria-expanded="true">Click here to login</a>     

                    </h3>
                     <div id="checkout_login" class="collapse" data-parent="#accordion">
                        <div class="checkout_info">
                            <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing & Shipping section.</p>  
                            <form action="{{ route('customer-login') }}" method="POST">
                                @csrf
                                <div class="form_group">
                                    <label>Username or email <span>*</span></label>
                                    <input type="text" class="form-control" id="singin-email"
                                    name="email" placeholder="Email Address *"
                                    required value="{{old('email')}}"/>
                                </div>
                                <div class="form_group">
                                    <label>Password  <span>*</span></label>
                                    <input type="password" class="form-control" id="singin-password"
                                    name="password" placeholder="Password *" required />
                                </div> 
                                <div class="form_group">
                                    <button class="btn btn-dark btn-block btn-rounded"
                                    type="submit">Login</button>
                                </div>
                            </form>          
                        </div>
                    </div>    
                </div>
                
           </div>
        </div>
        <div class="checkout_form">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <form action="{{ route('order') }}" class="form" method="POST" id="myform">
                        @csrf
                        <h3>Billing Details</h3>
                        <div class="row">
                            @if (Auth::guard('customer')->user())
                                <div class="col-lg-6 mb-20">
                                    <label>Full Name <span>*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                    value="{{ Auth::guard('customer')->user()->name }}"/>
                                </div>
                            @else
                                <div class="col-lg-6 mb-20">
                                    <label>First Name <span>*</span></label>
                                    <input name="name" type="text">    
                                </div>
                            @endif

                            <div class="col-12 mb-20">
                                <label>Address  <span>*</span></label>
                                <input name="address" placeholder="House number and street name" type="text">     
                            </div>

                            <div class="col-12 mb-20">
                                <label>Town / City <span>*</span></label>
                                <input name="city" placeholder="House number and street name" type="text">     
                            </div> 
                           
                            <div class="col-lg-6 mb-20">
                                <label>Phone<span>*</span></label>
                                <input name="phone" placeholder="House number and street name" type="text">     


                            </div> 
                             <div class="col-lg-6 mb-20">
                                <label> Email Address   <span>*</span></label>
                                <input type="text" name="email" class="form-control" required
                                value=""/>

                            </div> 
                           
                            
                            <div class="col-12">
                                <div class="order-notes">
                                     <label for="order_note">Order Notes</label>
                                    <textarea name="order_note" id="order_note" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                </div>    
                            </div>     	    	    	    	    	    	    
                        </div>
                       
                        </div>
                        <div class="col-lg-6 col-md-6">
                                <h3>Your order</h3> 
                                <div class="order_table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($carts as $cart)
                                            <tr>
                                                <td> {{$cart->product->title}}<strong> × {{$cart->quantity}}</strong></td>
                                                <td> Rs.{{$cart->amount}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Cart Subtotal</th>
                                                <td>Rs. {{$total}}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td><strong>Rs. {{setting('shipping_charge')}}</strong></td>
                                            </tr>
                                            <tr class="order_total">
                                                <th>Order Total</th>
                                                <td><strong>Rs. {{$total_amount}}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>     
                                </div>
                                <div class="payment_method">
                                    <h3>Shipping Details</h3>
                                    <div class="payment accordion radio-type sumnary-shipping">
                                        <h4 class="summary-subtitle ls-m pb-3">Preferred Delivery Date</h4>
                                        <div class="select-box">
                                            <select id="preferred_delivery_date" name="preferred_delivery_date" class="form-control">
                                                <option value="">Select Delivery Date</option>
                                                <option value="Sunday">Sunday</option>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                            </select>
                                        </div>

                                        <h4 class="summary-subtitle ls-m pb-3">Delivery Time Slot</h4>
                                        <div class="select-box" id="timeslot" >
                                            <select  class="form-control"  name="timeslot">
                                                <option value="">Select Time Slot</option>
                                                <option value="12pm-3pm">12pm-3pm</option>
                                                <option value="3pm-6pm">3pm-6pm</option>
                                                <option value="6pm-12am">6pm-12am</option>
                                            
                                            </select>
                                        </div>

                                        <h4 class="summary-subtitle ls-m pb-3">Payment Method</h4>
                                        <div class="select-box" id="timeslot" >
                                            <select  class="form-control"  name="payment_method">
                                                <option value="">Select Payment Method</option>
                                                <option value="cash-on-delivery">Cash on Delivery </option>
                                                {{-- <option value="esewa">Esewa</option> --}}
                                            
                                            </select>
                                        </div>
                                    
                                    </div>

                                    <div class="order_button">
                                        <button  type="submit">Proceed to Pay</button> 
                                    </div>    
                                </div>        
                        </div>
                    </form>
            </div> 
        </div> 
    </div>       
</div>
<!--Checkout page section end-->

@endsection