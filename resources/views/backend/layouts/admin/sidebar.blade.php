<!-- BEGIN MENUBAR-->
<div id="menubar" class="menubar-inverse ">
				<div class="menubar-fixed-panel">
					<div>
						<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
							<i class="fa fa-bars"></i>
						</a>
					</div>
					<div class="expanded">
						<a href="{{ route('dashboard.index') }}">
							<span class="text-lg text-bold text-primary ">MATERIAL&nbsp;ADMIN</span>
						</a>
					</div>
				</div>
				<div class="menubar-scroll-panel">



					<!-- BEGIN MAIN MENU -->
					<ul id="main-menu" class="gui-controls">

						 <!-- BEGIN DASHBOARD -->
						<li>
							<a href="{{ route('dashboard.index') }}" class="active">
								<div class="gui-icon"><i class="md md-home"></i></div>
								<span class="title">Dashboard</span>
							</a>
						</li><!--end /menu-li -->
						<!-- END DASHBOARD -->

                        @role('SuperAdmin')

                            <li class="gui-folder expanded">
                                <a>
                                    <div class="gui-icon"><i class="md md-settings"></i></div>
                                    <span class="title">Admin</span>
                                </a>
                                <ul style="overflow: hidden; height: 84px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;">
                                    <li><a href="{{ route('user.index') }}"><span class="title">User</span></a></li>
                                    <li><a href="{{ route('role.index') }}"><span class="title">Role</span></a></li>
                                    <li><a href="{{ route('permission.index') }}"><span class="title">Permissions</span></a></li>
                                </ul><!--end /submenu -->
                            </li>
                        @endrole

						{{-- <li class="gui-folder">
							<a href="{{ route('menu.index') }}">
								<div class="gui-icon"><i class="md md-menu"></i></div>
								<span class="title">Menu</span>
							</a>

						</li> --}}

                        <li class="gui-folder">
							<a href="{{ route('page.index') }}">
								<div class="gui-icon"><i class="md md-pages"></i></div>
								<span class="title">Pages</span>
							</a>
						</li>


						<li class="gui-folder">
							<a href="{{ route('slider.index') }}" >
								<div class="gui-icon"><i class="md md-image"></i></div>
								<span class="title">Sliders</span>
							</a>
						</li>

                        <li class="gui-folder">
							<a href="{{ route('category.index') }}">
								<div class="gui-icon"><i class="md md-folder-special"></i></div>
								<span class="title">Category</span>
							</a>
						</li>

                         <li class="gui-folder">
							<a href="{{ route('subcategory.index') }}">
								<div class="gui-icon"><i class="fa fa-puzzle-piece fa-fw"></i></div>
								<span class="title">Sub-Category</span>
							</a>
						</li>

						<li class="gui-folder">
							<a href="{{ route('brand.index') }}">
								<div class="gui-icon"><i class="md md-attach-money"></i></div>
								<span class="title">Brand</span>
							</a>
						</li>

                        <li class="gui-folder">
							<a href="{{ route('product.index') }}">
								<div class="gui-icon"><i class="fa fa-shopping-cart"></i></div>
								<span class="title">Product</span>
							</a>
						</li>

						<li class="gui-folder">
							<a href="{{ route('view-order') }}" >
								<div class="gui-icon"><i class="fa fa-shopping-cart"></i></div>
								<span class="title">Orders</span>
							</a>
						</li>

						<li class="gui-folder">
							<a href="{{ route('training.index') }}" >
								<div class="gui-icon"><i class="fa fa-mortar-board"></i></div>
								<span class="title">Trainings</span>
							</a>
						</li>

						<li class="gui-folder">
							<a href="{{ route('contact.index') }}" >
								<div class="gui-icon"><i class="fa fa-phone"></i></div>
								<span class="title">Contact</span>
							</a>
						</li>

						{{-- <li class="gui-folder">
							<a href="{{ route('testimonial.index') }}" >
								<div class="gui-icon"><i class="md md-speaker-notes"></i></div>
								<span class="title">Testimonials</span>
							</a>
						</li> --}}



						{{-- <li class="gui-folder">
							<a>
								<div class="gui-icon"><i class="md md-image"></i></div>
								<span class="title">Gallery</span>
							</a>

							<ul>
								<li><a href="{{ route('gallery.index') }}" ><span class="title">View All Gallery</span></a></li>

							</ul>

							<ul>
								<li><a href="{{ route('album.index') }}" ><span class="title">View All Album</span></a></li>

							</ul>
						</li> --}}



                        {{-- <li class="gui-folder">
							<a href="{{ route('testimonial.index') }}" >
								<div class="gui-icon"><i class="md md-speaker-notes"></i></div>
								<span class="title">Testimonials</span>
							</a>
						</li> --}}









				</div><!--end .menubar-scroll-panel-->
			</div><!--end #menubar-->
			<!-- END MENUBAR -->
