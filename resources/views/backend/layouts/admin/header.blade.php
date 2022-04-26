
		<!-- BEGIN HEADER-->
		<header id="header" >
			<div class="headerbar">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="headerbar-left">
					<ul class="header-nav header-nav-options">
						<li class="header-nav-brand" >
							<div class="brand-holder">
								{{-- <a href="{{route('homepage')}}">
                                    <img alt="Image" src="{{asset('assets/images/logo.png')}}" class="logo-color">
								</a> --}}
							</div>
						</li>
						<li>
							<a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
								<i class="fa fa-bars"></i>
							</a>
						</li>
					</ul>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="headerbar-right">

					<ul class="header-nav header-nav-profile">
						<li class="dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                                <img alt="Image" src="{{asset('assets/images/logo.png')}}" class="logo-color">
								<span class="profile-info">
									{{ auth()->user()->name }}

								</span>
							</a>
							<ul class="dropdown-menu animation-dock">

								<!-- <li><a href="../../html/pages/profile.html">My profile</a></li> -->
								<li>
									<a href="{{route('setting.index')}}">
										<i class="md md-settings"></i>
										Settings
									</a>
								</li>
								<li>
									<a href="{{url('/logout')}}">
										<i class="md md-settings-power text-danger"></i>
										Logout
                           			 </a>
                        		</li>
							</ul><!--end .dropdown-menu -->
						</li><!--end .dropdown -->
					</ul><!--end .header-nav-profile -->

				</div><!--end #header-navbar-collapse -->
			</div>
		</header>
		<!-- END HEADER-->

