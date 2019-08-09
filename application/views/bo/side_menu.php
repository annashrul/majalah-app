<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
	<div class="sidebar-inner slimscrollleft">
		<div class="user-details">
			<div class="pull-left">
				<img src="<?=base_url().'assets/images/'.'user-default.png'?>" alt="" class="thumb-md img-circle">
			</div>
			<div class="user-info">
				<div class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">NAMA <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href=""><i class="md md-face-unlock"></i> Profile</a></li>
						<li><a href=""><i class="md md-settings-power"></i> Logout</a></li>
					</ul>
				</div>
				
				<p class="text-muted m-0">Administrator</p>
			</div>
		</div>
		<!--- Divider -->
		<div id="sidebar-menu">
			<ul>
				<li>
					<a href="<?=base_url()?>" class="waves-effect <?=($page=='dashboard')?'active':null?>"><i class="md md-home"></i><span>Dashboard</span></a>
				</li>
				<li class="has_sub">
					<?php $side_menu=null; $side_menu=array('0','berita','kategori_berita','edisi','lokasi'); ?>
					<a href="#" class="waves-effect <?=array_search($page, $side_menu)?'active':null?>"><i class="md md-now-widgets"></i><span>Master Data</span><span class="pull-right"><i class="md md-add"></i></span></a>
					<ul class="list-unstyled">
						<li class="<?=($page=='berita')?'active':null?>" ><a href="<?=base_url().'masterdata/berita'?>">Berita</a></li>
						<li class="<?=($page=='kategori_berita')?'active':null?>"><a href="<?=base_url().'masterdata/kategori_berita'?>">Kategori</a></li>
						<li class="<?=($page=='edisi')?'active':null?>"><a href="<?=base_url().'masterdata/edisi'?>">Edisi</a></li>
						<li class="<?=($page=='lokasi')?'active':null?>"><a href="<?=base_url().'masterdata/lokasi'?>">Lokasi</a></li>
					</ul>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!-- Left Sidebar End -->


