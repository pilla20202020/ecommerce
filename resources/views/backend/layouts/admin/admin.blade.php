<!DOCTYPE html>
<html lang="en">
<head>
<title>{{ config('app.name') }} - @yield('title', 'Page')</title>


		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">

        <meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link rel="shortcut icon" type="image/x-icon" href="http://127.0.0.1:8000/assets/images/kclogo.jpg">
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/css/theme-default/bootstrap.css?1422792965') }}" />
		<link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/css/theme-default/font-awesome.min.css?1422529194') }}" />
		<link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/css/theme-default/material-design-iconic-font.min.css?1421434286') }}" />
		<link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/css/theme-default/libs/rickshaw/rickshaw.css?1422792967') }}" />
		<link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/css/theme-default/libs/morris/morris.core.css?1420463396') }}" />


		<link rel="stylesheet" href="{{ asset('backend/assets/css/materialadmin-bootstrap.css') }}">
  		  <link rel="stylesheet" href="{{ asset('backend/assets/css/materialadmin.css') }}">

		<link rel="stylesheet" href="{{ asset('backend/assets/css/font-awesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/assets/css/material-design-iconic-font.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/assets/css/libs/toastr/toastr.min.css') }}">
		<link rel="stylesheet" href="{{ asset('backend/assets/css/app.css') }}">
		<link rel="stylesheet"href="{{ asset('backend/assets/css/dropify.min.css') }}">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
		<link type="text/css" rel="stylesheet" href="{{ asset('backend/assets/css/libs/nestable/nestable.css') }}"/>
		<link rel="stylesheet" href="{{ asset('backend/assets/css/libs/select2/select2.css') }}">
    	<link type="text/css" rel="stylesheet"
          href="{{asset('backend/assets/css/bootstrap-datetimepicker.min.css')}}"/>

		<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
		@stack('styles')

</head>
<body class="menubar-hoverable header-fixed ">

    @if (auth()->guest())
        @yield('guest')
    @else
        <!-- BEGIN HEADER -->
        @include('backend.layouts.admin.header')
        <!-- END HEADER -->
        <!-- BEGIN BASE -->
        <div id="base">
            <div id="content">
                @yield('content')
            </div>

            @include('backend.layouts.admin.sidebar')
        </div>
        <!-- END BASE -->
    @endif

        </div>
       <!-- END BASE -->
        @include('backend.layouts.admin.footer')

       <!-- BEGIN JAVASCRIPT -->
    <script src="{{ asset('backend/assets/js/libs/jquery/jquery-1.11.2.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/jquery/jquery-migrate-1.2.1.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/bootstrap/bootstrap.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/spin.js/spin.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/autosize/jquery.autosize.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/moment/moment.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/flot/jquery.flot.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/flot/jquery.flot.time.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/flot/jquery.flot.resize.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/flot/jquery.flot.orderBars.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/flot/jquery.flot.pie.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/flot/curvedLines.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/jquery-knob/jquery.knob.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/sparkline/jquery.sparkline.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/nanoscroller/jquery.nanoscroller.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/d3/d3.min.js') }}"></script>
		<script src="{{ asset('backend/assets/js/libs/d3/d3.v3.js') }}"></script>
		<script src="{{ asset('backend/assets/js/core/source/App.js') }}"></script>
		<script src="{{ asset('backend/assets/js/core/source/AppNavigation.js') }}"></script>
		<script src="{{ asset('backend/assets/js/core/source/AppOffcanvas.js') }}"></script>
		<script src="{{ asset('backend/assets/js/core/source/AppCard.js') }}"></script>
		<script src="{{ asset('backend/assets/js/core/source/AppForm.js') }}"></script>
		<script src="{{ asset('backend/assets/js/core/source/AppNavSearch.js') }}"></script>
		<script src="{{ asset('backend/assets/js/core/source/AppVendor.js') }}"></script>
		<script src="{{ asset('backend/assets/js/core/demo/Demo.js') }}"></script>
		<script src="{{ asset('backend/assets/js/core/demo/DemoDashboard.js') }}"></script>

		<script src="{{ asset('backend/assets/js/dropify.min.js') }}"></script>
		<script src="{{asset('backend/assets/js/bootstrap-datetimepicker.min.js')}}"></script>
		<script src="{{asset('backend/assets/js/altair_admin_common.js')}}"></script>
		<!-- END JAVASCRIPT -->
		<script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
		<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
		<script>
			$(document).ready(function(){
				$('#teamsection').on('change', function() {
				if ( this.value == 'management-team')
				{
					$("#positioncontent").show();
				}
				else
				{
					$("#positioncontent").hide();
				}
				});
			});
            $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        </script>
		<!-- <script  >
			$(document).ready(function () {


				$(function () {
					$('.my-ckeditor').each(function (e) {
						CKEDITOR.replace(this.id, {

							filebrowserUploadMethod: 'form'
						});
					});
				});
			});

    </script> -->

	<script src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
		<script>
			$(function () {
				$('.ckeditor').each(function (e) {
				});
			});
		</script>

@stack('scripts')

</body>
</html>
