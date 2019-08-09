	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<link rel="shortcut icon" type="image/png" href="" />
	<title>title</title>
	<!-- Base Css Files -->
	<link href="<?=base_url().'assets/'?>css/bootstrap.min.css" rel="stylesheet" />
	<!-- Font Icons -->
	<link href="<?=base_url().'assets/'?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link href="<?=base_url().'assets/'?>assets/ionicon/css/ionicons.min.css" rel="stylesheet" />
	<link href="<?=base_url().'assets/'?>css/material-design-iconic-font.min.css" rel="stylesheet" />
	<!-- animate css -->
	<link href="<?=base_url().'assets/'?>css/animate.css" rel="stylesheet" />
	<!-- Waves-effect -->
	<link href="<?=base_url().'assets/'?>css/waves-effect.css" rel="stylesheet" />
	<!-- DataTables -->
    <link href="<?=base_url().'assets/'?>assets/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
	<!-- Responsive-table -->
    <link href="<?=base_url().'assets/'?>assets/responsive-table/rwd-table.min.css" rel="stylesheet" type="text/css" media="screen"/>
	<!-- sweet alerts -->
	<link href="<?=base_url().'assets/'?>assets/sweet-alert/sweet-alert.min.css" rel="stylesheet" />
	<!-- Plugins css-->
	<link href="<?=base_url().'assets/'?>assets/tagsinput/jquery.tagsinput.css" rel="stylesheet" />
	<link href="<?=base_url().'assets/'?>assets/toggles/toggles.css" rel="stylesheet" />
	<link href="<?=base_url().'assets/'?>assets/timepicker/bootstrap-timepicker.min.css" rel="stylesheet" />
	<link href="<?=base_url().'assets/'?>assets/timepicker/bootstrap-datepicker.min.css" rel="stylesheet" />
	<link href="<?=base_url().'assets/'?>assets/colorpicker/colorpicker.css" rel="stylesheet" type="text/css" />
	<link href="<?=base_url().'assets/'?>assets/jquery-multi-select/multi-select.css"  rel="stylesheet" type="text/css" />
	<link href="<?=base_url().'assets/'?>assets/select2/select2.css" rel="stylesheet" type="text/css" />
	<!-- Custom Files -->
	<link href="<?=base_url().'assets/'?>css/helper.css" rel="stylesheet" type="text/css" />
	<link href="<?=base_url().'assets/'?>css/style.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?=base_url().'assets/'?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
	<!--<link href="<?/*=base_url().'assets/'*/?>css/bootstrap-datetimepicker.css" rel="stylesheet" />-->

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->

    <!--daterangepicker-->
    <link rel="stylesheet" type = "text/css" href="<?=base_url().'assets/'?>assets/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type = "text/css" href="<?=base_url().'assets/'?>plugins/tagInput/bootstrap-tagsinput.css">
    <!--<script src="<?/*=base_url().'assets/'*/?>assets/daterangepicker/moment.js"></script>
    <script src="<?/*=base_url().'assets/'*/?>assets/daterangepicker/daterangepicker.js"></script>-->

    <script src="<?=base_url().'assets/'?>js/jquery.min.js"></script>
    <script src="<?=base_url().'assets/'?>js/bootstrap.min.js"></script>
    <script src="<?=base_url().'assets/'?>js/modernizr.min.js"></script>

    <script src="<?=base_url().'assets/'?>assets/jQuery-autocomplete/jquery.autocomplete.js" type="text/javascript"></script>
    <link rel="stylesheet" type = "text/css" href="<?=base_url().'assets/'?>assets/auto-complete/jquery.autocomplete.css" />
	<script src="<?=base_url().'assets/'?>assets/auto-complete/jquery.autocomplete.js" type="text/javascript"></script>
    <script src="//cdn.ckeditor.com/4.9.2/full/ckeditor.js"></script>

	<!--Daterangepicker-->
	<script src="<?=base_url().'assets/'?>assets/daterangepicker/moment.js" type="text/javascript"></script>
	<script src="<?=base_url().'assets/'?>assets/daterangepicker/daterangepicker.js" type="text/javascript"></script>

	<!--Chart Js-->
	<script src="<?=base_url().'assets/'?>assets/chartjs/Chart.js"></script>

    <link href="<?=base_url().'assets/'?>assets/notifications/notification.css" rel="stylesheet" />

    <!-- Form Validation -->
    <script type="text/javascript" src="<?=base_url().'assets/'?>assets/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?=base_url().'assets/'?>assets/jquery-validation/additional-methods.min.js"></script>
    <script src="<?=base_url().'assets/'?>plugins/tagInput/bootstrap-tagsinput.min.js"></script>

	<style>
		.daterange { position: relative; text-align: center }
		.daterange i {
			position: absolute; bottom: 10px; right: 24px; top: auto; cursor: pointer;
		}

		.width-uang {
			width: 95px;
			text-align: right;
		}

		.width-diskon {
			width: 50px;
			text-align: center;
		}

		input[type=number]::-webkit-inner-spin-button,
		input[type=number]::-webkit-outer-spin-button {
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			margin: 0;
		}

		input[type=number] {
			-moz-appearance:textfield;
		}

		.table_check {
			border-collapse:collapse;
		}
		.td_check {
			padding: -8px -8px -8px -8px;
		}
		.label_check {
			display:block;
			margin: -8px;
			padding: 8px 8px 8px 8px;
		}

		.datepicker table tr.week:hover{
			background: #eee;
		}

		.datepicker table tr.week-active,
		.datepicker table tr.week-active td,
		.datepicker table tr.week-active td:hover,
		.datepicker table tr.week-active.week td,
		.datepicker table tr.week-active.week td:hover,
		.datepicker table tr.week-active.week,
		.datepicker table tr.week-active:hover{
			background-color: #006dcc;
			background-image: -moz-linear-gradient(top, #0088cc, #0044cc);
			background-image: -ms-linear-gradient(top, #0088cc, #0044cc);
			background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
			background-image: -webkit-linear-gradient(top, #0088cc, #0044cc);
			background-image: -o-linear-gradient(top, #0088cc, #0044cc);
			background-image: linear-gradient(top, #0088cc, #0044cc);
			background-repeat: repeat-x;
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
			border-color: #0044cc #0044cc #002a80;
			border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
			filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
			color: #fff;
			text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		}
		.label_colom {
			position:  absolute;
			left: 0;
			top: 0; /* set these so Chrome doesn't return 'auto' from getComputedStyle */
			background: transparent;
			border: 0px  solid rgba(0,0,0,0.5);
		}


        /* Absolute Center Spinner */
        /*Loading*/
        .first-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1050;
            background: rgba(168, 168, 168, .5)
        }
        .first-loader img {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px
        }

        .autocomplete-suggestions { border: 1px solid #999; background: #fff; cursor: default; overflow: auto; }
        .autocomplete-suggestion { padding: 10px 5px; font-size: 1.2em; white-space: nowrap; overflow: hidden; }
        .autocomplete-selected { background: #f0f0f0; }
        .autocomplete-suggestions strong { font-weight: normal; color: #3399ff; }
        .autocomplete-loading { background:url('<?=base_url().'assets/images/spin.svg'?>') no-repeat right center }

        @media only screen and (max-width: 600px) {
            .logo-top-bar {
                margin-left: 300%;
            }
        }
	</style>

	<script type="text/javascript" src="<?=base_url().'assets/'?>assets/barcode/jquery-barcode.js"></script>

    <script>
        var img_url = '<img src="<?=base_url().'/assets/images/spin.svg'?>">';
        function dynamic_ajax(url,req=null,func_req){
            $.ajax({
                url : "<?=base_url()?>"+url,
                type:"POST",
                dataType : "JSON",
                data:req?req:null,
                beforeSend: function() {$('body').append('<div class="first-loader">'+img_url+'</div>')},
                complete: function() {$('.first-loader').remove()},
                success:func_req,
            });
            return;
        }
    </script>
