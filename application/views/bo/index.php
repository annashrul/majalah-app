<!DOCTYPE html>
<html>
    <head>
    <?php $this->load->view('bo/head'); ?>
    </head>
    <body class="fixed-left">
        <!-- Begin page -->
        <div id="wrapper">

            <?php $this->load->view('bo/topbar'); ?>

			<?php $this->load->view('bo/'.$content); ?>
			
			<?php $this->load->view('bo/side_menu'); ?>
			
			<?php $this->load->view('bo/footer'); ?>
			
		</div>
        <!-- END wrapper -->
		
    </body>
	
</html>

