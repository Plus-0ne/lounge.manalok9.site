<div class="header d-flex flex-wrap" style="z-index: 1;">
	<div class="col-12 col-sm-12 col-md-12 col-lg-3 text-sm-center text-md-start d-flex flex-wrap justify-content-center justify-content-md-start">
		<div class="img-content my-auto">
			<img src="{{ asset('img/META_LOGO.svg') }}">
		</div>
		<div class="header-text my-auto">
			Admin
		</div>
	</div>
	<div class="my-sm-4 my-lg-auto px-5 col-12 col-sm-12 col-md-12 col-lg-6">
		<input class="form-control" type="text" name="" placeholder="Search">
	</div>
	<div class="nav-btn-icon col-12 col-sm-12 col-md-12 col-lg-3 d-flex flex-wrap justify-content-end my-lg-auto">
		<div class="menu-toggle" style="margin-right: auto;">
			<i class="menu-icon action-icon mdi mdi-format-align-justify"></i>
		</div>
		<div class="" style="margin-left: 18px;">
			<i class="action-icon mdi mdi-bell"></i>
		</div>
		<div class="" style="margin-left: 18px;">
			<a class="a-links" href="#"><i class="action-icon mdi mdi-cog"></i></a>
		</div>
		<div class="" style="margin-left: 18px;">
			<a class="a-links" href="{{ route('admin.logout') }}"><i class="action-icon mdi mdi-logout"></i></a>
		</div>
	</div>
</div>