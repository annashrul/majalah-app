<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
	<div class="sidebar-inner slimscrollleft">
		<div class="user-details">
			<div class="pull-left">
				<img src="<?=base_url().'assets/images/'.'user-default.png'?>" alt="" class="thumb-md img-circle">
			</div>
			<div class="user-info">
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?=$this->user?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href=""><i class="md md-face-unlock"></i> Profile</a></li>
						<li><a href="<?=base_url().'site/logout'?>"><i class="md md-settings-power"></i> Logout</a></li>
					</ul>
				</div>
				
				<p class="text-muted m-0">Administrator</p>
			</div>
		</div>
		<!--- Divider -->
		<div id="sidebar-menu">
			<ul>
				<li><a href="<?=base_url().'site/dashboard'?>" class="waves-effect <?=($page=='dashboard')?'active':null?>"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
				<li><a href="<?=base_url().'masterdata/user_list'?>" class="waves-effect <?=($page=='dashboard')?'active':null?>"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
                <li><a href="<?=base_url().'masterdata/berita'?>" class="waves-effect <?=($page=='berita')?'active':null?>"><i class="fa fa-list"></i><span>Berita</span></a></li>
                <li><a href="<?=base_url().'masterdata/kategori_berita'?>" class="waves-effect <?=($page=='kategori_berita')?'active':null?>"><i class="fa fa-list"></i><span>Kategori</span></a></li>
                <li><a href="<?=base_url().'masterdata/edisi'?>" class="waves-effect <?=($page=='edisi')?'active':null?>"><i class="fa fa-list"></i><span>Edisi</span></a></li>
                <li><a href="<?=base_url().'masterdata/lokasi'?>" class="waves-effect <?=($page=='lokasi')?'active':null?>"><i class="fa fa-map-marker"></i><span>Lokasi</span></a></li>

			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- Left Sidebar End -->


