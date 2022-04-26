 <!--footer area start-->
 <footer class="footer_widgets">
    <div class="container">  
        <div class="footer_top">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="widgets_container contact_us">
                        <a href="{{ route('homepage') }}"><img src="{{ asset('assets/images/logo.png') }}" width="40%" alt=""></a>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero vulputate rutrum. Morbi ornare lectus quis justo gravida semper. Nulla tellus mi, vulputate adipiscing cursus eu, suscipit id nulla.
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="widgets_container widget_menu pt-5">
                        <h3>Quick Links</h3>
                        <div class="footer_menu">
                            <ul>
                                <li><a href="{{ route('homepage') }}">Home</a></li>
                                <li><a href="{{ route('about') }}"> About</a></li>
                                <li><a href="{{ route('contact') }}">Contact</a></li>
                    
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="widgets_container contact_us pt-5">
                        <h3>Contact Us</h3>
                        <div class="footer_contact">
                            <ul>
                                <li><i class="ion-ios-location"></i><span>Address:</span>{{setting('address')}}</li>
                                <li><i class="ion-ios-telephone"></i><span>Call Us:</span> <a href="tel:{{setting('phone')}}">{{setting('phone')}}</a></li>
                                <li><i class="ion-android-mail"></i><span>Email:</span> <a href="mailto:{{setting('email')}}">{{setting('email')}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                

            </div>
        </div>
    </div>     
</footer>
<!--footer area end-->

     <!-- modal area start-->
     <div class="modal fade" id="productquickview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal_body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-12">
                                <div class="modal_tab">  
                                    <div class="tab-content product-details-large">
                                        <div class="tab-pane fade show active" id="tab1" role="tabpanel" >
                                            <div class="modal_tab_img">
                                                <div id="pro-1" class="tab-pane fade show active">
                                                    <img src="" id="viewproductimage" alt="">
                                                </div>    
                                            </div>
                                        </div>
                                       
                                    </div>
                                    
                                </div>  
                            </div> 
                            <div class="col-lg-7 col-md-7 col-sm-12">
                                <div class="modal_right">
                                    <div class="modal_title mb-10">
                                        <h2 id="productheading"></h2> 
                                    </div>
                                    <div class="modal_price mb-10">
                                        <span id="productprice" ></span>    
                                    </div>
                                    <div class="modal_description mb-15">
                                        <p id="productdescription"></p>    
                                    </div> 
                                    {{-- <div class="variants_selects">
                                       
                                        <div class="variants_color">
                                           <h2>color</h2>
                                           <select class="select_option">
                                               <option selected value="1">purple</option>
                                               <option value="1">violet</option>
                                               <option value="1">black</option>
                                               <option value="1">pink</option>
                                               <option value="1">orange</option>
                                           </select>
                                        </div>
                                        
                                    </div> --}}
                                     
                                </div>    
                            </div>    
                        </div>     
                    </div>
                </div>    
            </div>
        </div>
    </div>
    <!-- modal area end-->
    