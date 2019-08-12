
<footer class="footer text-right">
	2017 ©
</footer>

<script>
	var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="<?=base_url().'assets/'?>js/waves.js"></script>
<script src="<?=base_url().'assets/'?>js/wow.min.js"></script>
<script src="<?=base_url().'assets/'?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?=base_url().'assets/'?>js/jquery.scrollTo.min.js"></script>
<script src="<?=base_url().'assets/'?>assets/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="<?=base_url().'assets/'?>assets/jquery-detectmobile/detect.js"></script>
<script src="<?=base_url().'assets/'?>assets/fastclick/fastclick.js"></script>
<script src="<?=base_url().'assets/'?>assets/jquery-slimscroll/jquery.slimscroll.js"></script>
<script src="<?=base_url().'assets/'?>assets/jquery-blockui/jquery.blockUI.js"></script>

<!-- sweet alerts -->
<!--<script src="<?/*=base_url().'assets/'*/?>assets/sweet-alert/sweet-alert.min.js"></script>
<script src="<?/*=base_url().'assets/'*/?>assets/sweet-alert/sweet-alert.init.js"></script>-->
<script src="<?=base_url().'assets/'?>assets/sweetalert2/sweetalert2.all.js"></script>


<!-- Counter-up -->
<script src="<?=base_url().'assets/'?>assets/counterup/waypoints.min.js" type="text/javascript"></script>
<script src="<?=base_url().'assets/'?>assets/counterup/jquery.counterup.min.js" type="text/javascript"></script>

<!-- CUSTOM JS -->
<script src="<?=base_url().'assets/'?>js/jquery.app.js"></script>


<!-- Todso -->
<script src="<?=base_url().'assets/'?>assets/tagsinput/jquery.tagsinput.min.js"></script>
<script src="<?=base_url().'assets/'?>assets/toggles/toggles.min.js"></script>
<script type="text/javascript" src="<?=base_url().'assets/'?>assets/colorpicker/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="<?=base_url().'assets/'?>assets/bootstrap3-editable/bootstrap-editable.js"></script>
<script type="text/javascript" src="<?=base_url().'assets/'?>assets/jquery-multi-select/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?=base_url().'assets/'?>assets/jquery-multi-select/jquery.quicksearch.js"></script>
<script src="<?=base_url().'assets/'?>assets/bootstrap-inputmask/bootstrap-inputmask.min.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url().'assets/'?>assets/spinner/spinner.min.js"></script>
<script src="<?=base_url().'assets/'?>assets/select2/select2.min.js" type="text/javascript"></script>

<script src="<?=base_url().'assets/'?>assets/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?=base_url().'assets/'?>assets/timepicker/bootstrap-datepicker.js"></script>
<script src="<?=base_url().'assets/'?>assets/datatables/jquery.dataTables.min.js"></script>
<!--<script src="<?/*=base_url().'assets/'*/?>js/bootstrap-datetimepicker.js"></script>-->
<script src="<?=base_url().'assets/'?>assets/datatables/dataTables.bootstrap.js"></script>
<script src="<?=base_url().'assets/'?>assets/responsive-table/rwd-table.min.js" type="text/javascript"></script>

<!--<script type="text/javascript" src="<?/*=base_url().'assets/'*/?>assets/jquery.validate/jquery.validate.min.js"></script>
<script src="<?/*=base_url().'assets/'*/?>assets/jquery.validate/form-validation-init.js"></script>-->

<script src="<?=base_url().'assets/'?>assets/notifications/notify.min.js"></script>
<script src="<?=base_url().'assets/'?>assets/notifications/notify-metro.js"></script>
<script src="<?=base_url().'assets/'?>assets/notifications/notifications.js"></script>
<!-- jvectormap -->
<script src="<?=base_url().'assets/'?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=base_url().'assets/'?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script type="text/javascript">
    document.addEventListener("mousewheel", function(event){
        if(document.activeElement.type === "number"){
            document.activeElement.blur();
        }
    });

    $(document).ready(function () {
        $('.table-responsive').on('show.bs.dropdown', function () {
            document.querySelector('style').textContent += "@media only screen and (max-width: 500px) {.dropdown-menu {position: relative !important}} @media only screen and (min-width: 500px) {.table-responsive {overflow: inherit !important;}}";
        }).on('hide.bs.dropdown', function () {
            document.querySelector('style').textContent += "@media only screen and (min-width: 500px) {.table-responsive {overflow: auto !important}}";
        })
    });

	jQuery(document).ready(function($) {

		$('.counter').counterUp({
			delay: 100,
			time: 1200
		});
		
		// Tags Input
		jQuery('#tags').tagsInput({width:'auto'});

		// Form Toggles
		jQuery('.toggle').toggles({on: true});

		// Time Picker
		jQuery('#timepicker').timepicker({defaultTIme: false});
		jQuery('#timepicker2').timepicker({showMeridian: false});
		jQuery('#timepicker3').timepicker({minuteStep: 15});

		// Date Picker
		jQuery('.datepicker').datepicker();
		jQuery('.datepicker-inline').datepicker();
		jQuery('.datepicker-multiple').datepicker({
			numberOfMonths: 3,
			showButtonPanel: true
		});
		

		$('.datepicker_date').datepicker({
			format: 'yyyy-mm-dd'
		});

		$('.datetimerange').daterangepicker(
			{
				timePicker: true,
				timePicker24Hour: true,
				timePickerIncrement: 5,
				locale: {
					format: 'YYYY-MM-DD H:mm'
				},
				startDate: moment(),
				endDate: moment()
			}
		);
		
		//colorpicker start
		$('.colorpicker-default').colorpicker({
			format: 'hex'
		});
		$('.colorpicker-rgba').colorpicker();


		//multiselect start

		$('#my_multi_select1').multiSelect();
		$('#my_multi_select2').multiSelect({
			selectableOptgroup: true
		});

		$('#my_multi_select3').multiSelect({
			selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
			selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
			afterInit: function (ms) {
				var that = this,
					$selectableSearch = that.$selectableUl.prev(),
					$selectionSearch = that.$selectionUl.prev(),
					selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
					selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

				that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
					.on('keydown', function (e) {
						if (e.which === 40) {
							that.$selectableUl.focus();
							return false;
						}
					});

				that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
					.on('keydown', function (e) {
						if (e.which == 40) {
							that.$selectionUl.focus();
							return false;
						}
					});
			},
			afterSelect: function () {
				this.qs1.cache();
				this.qs2.cache();
			},
			afterDeselect: function () {
				this.qs1.cache();
				this.qs2.cache();
			}
		});

		$('input[name=day]').datepicker( {
			format: "yyyy-mm-dd",
			minViewMode: 3,
			autoclose: true
		} );

		$('input[name=year]').datepicker( {
			format: "yyyy",
			minViewMode: 2,
			autoclose: true
		} );

		$('input[name=month]').datepicker( {
			format: "MM, yyyy",
			minViewMode: 1,
			autoclose: true
		} );

		$('input[name=week]').datepicker( {
			format: "yyyy-mm-dd",
			autoclose: true
		}).on('show', function(e){

			var tr = $('body').find('.datepicker-days table tbody tr');

			tr.mouseover(function(){
				$(this).addClass('week');
			});

			tr.mouseout(function(){
				$(this).removeClass('week');
			});

			calculate_week_range(e);

		}).on('hide', function(e){
			console.log('date changed');
			calculate_week_range(e);
		});

		var calculate_week_range = function(e){

			var input = e.currentTarget;

			// remove all active class
			$('body').find('.datepicker-days table tbody tr').removeClass('week-active');

			// add active class
			var tr = $('body').find('.datepicker-days table tbody tr td.active.day').parent();
			tr.addClass('week-active');

			// find start and end date of the week

			var date = e.date;
			var start_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
			var end_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);

			// make a friendly string

			var friendly_string = start_date.getFullYear() + '-' + (start_date.getMonth() + 1) + '-' + start_date.getDate()  + ' to '
				+ end_date.getFullYear() + '-' + (end_date.getMonth() + 1) + '-' + end_date.getDate();

			console.log(friendly_string);

			$(input).val(friendly_string);

		};

		$('.input-daterange').datepicker({
			format: "yyyy-mm-dd"
		});

		//spinner start
		$('#spinner1').spinner();
		$('#spinner2').spinner({disabled: true});
		$('#spinner3').spinner({value:0, min: 0, max: 10});
		$('#spinner4').spinner({value:0, step: 5, min: 0, max: 200});
		//spinner end

        // Select2
        jQuery(".select2").select2({
            width: '100%'
        });
	});

	$('.datepicker_date_from').datepicker({
		format: 'yyyy-mm-dd'
	}).on( "change", function() {
		$('.datepicker_date_to').datepicker({
			format: 'yyyy-mm-dd',
			startDate: get_date($(".datepicker_date_from").val())+'d'
		});
	});
	
	setTimeout(function(){ 
		$('.delay_datepicker_date_from').datepicker({
			format: 'yyyy-mm-dd'
		}).on( "change", function() {
			$('.datepicker_date_to').datepicker({
				format: 'yyyy-mm-dd',
				startDate: get_date($(".delay_datepicker_date_from").val())+'d'
			});
		});
	}, 2000);

	/*date range*/
	function get_daterange(type) {
		var output = null;
		$.ajax({
			url: "<?php echo base_url().'site/get_session_date/'?>" + type,
			type: "GET",
			async: false,
			success: function (res) {
				output = res;
			}
		});
		return output;
	}

	var startDate = get_daterange('startDate');
	var endDate = get_daterange('endDate');

	$('#daterange').daterangepicker({
		"showDropdowns": true,
		"ranges": {
			'Hari Ini': [moment(), moment()],
			'KemarIn': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
			'30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
			'Minggu Ini': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
			'Minggu Lalu': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
			'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
			'Tahun Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
		},
		"alwaysShowCalendars": true,
		"startDate": startDate,
		"endDate": endDate,
		"maxDate": moment(),
		"opens": "right"
	}, function(start, end, label) {
		console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
		$('#field-date').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
		after_change(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
	});
	
	$('#daterange_all').daterangepicker({
		"showDropdowns": true,
		"ranges": {
			'Hari Ini': [moment(), moment()],
			'KemarIn': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
			'30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
			'Minggu Ini': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
			'Minggu Lalu': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
			'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
			'Tahun Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
		},
		"alwaysShowCalendars": true,
		"startDate": startDate,
		"endDate": endDate,
		//"maxDate": moment(),
		"opens": "right"
	}, function(start, end, label) {
		console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
		$('#field-date').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
		after_change(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
	});
    $('.daterangesingle').daterangepicker(
        {
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            },
            singleDatePicker: true,
            startDate: moment()

        }
    );
	$('#daterange-right').daterangepicker({
		"showDropdowns": true,
		"ranges": {
			'Hari Ini': [moment(), moment()],
			'KemarIn': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
			'30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
			'Minggu Ini': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
			'Minggu Lalu': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
			'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
			'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
			'Tahun Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
		},
		"alwaysShowCalendars": true,
		"startDate": startDate,
		"endDate": endDate,
		"maxDate": moment(),
		"opens": "left"
	}, function(start, end, label) {
		console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
		$('#field-date').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
		after_change(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
	});

	function get_date(tanggal) {
		var sekarang = new Date();
		var pembanding = sekarang.getFullYear()+("0" + (sekarang.getMonth() + 1)).slice(-2)+("0" + (sekarang.getDate())).slice(-2);
		var get_selisih = parseInt(tanggal.replace(/-/g,'')) - parseInt(pembanding);

		if (get_selisih <= 0) {
			selisih = get_selisih.toString();
		} else {
			selisih = "+" + get_selisih.toString();
		}

		return selisih;
	}

    function set_date(periode, type) {
        var date = periode.split(" - ");
        if (type == 'datetimerange') {
            $('.'+type).daterangepicker(
                {
                    timePicker: true,
                    timePickerIncrement: 5,
                    locale: {
                        format: 'YYYY-MM-DD h:mm A'
                    },
                    startDate: moment(date[0]).format('YYYY-MM-DD h:mm A'),
                    endDate: moment(date[1]).format('YYYY-MM-DD h:mm A')
                }
            );
        } else if (type == 'daterangesingle') {
            $('.'+type).daterangepicker(
                {
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    singleDatePicker: true,
                    startDate: moment(date[0]).format('YYYY-MM-DD')
                }
            );
        } else if (type == 'daterange') {
            $('.'+type).daterangepicker(
                {
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    startDate: moment(date[0]).format('YYYY-MM-DD'),
                    endDate: moment(date[1]).format('YYYY-MM-DD')
                }
            );
        } else if (type == 'daterange2') {
            $('.'+type).daterangepicker(
                {
                    ranges: {
                        'Hari Ini': [moment(), moment()],
                        'KemarIn': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                        '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                        'Minggu Ini': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
                        'Minggu Lalu': [moment().subtract(1, 'weeks').startOf('isoWeek'), moment().subtract(1, 'weeks').endOf('isoWeek')],
                        'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                        'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                        'Tahun Ini': [moment().startOf('year'), moment().endOf('year')],
                        'Tahun Lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
                    },
                    locale: {
                        format: 'YYYY-MM-DD'
                    },
                    startDate: moment(date[0]).format('YYYY-MM-DD'),
                    endDate: moment(date[1]).format('YYYY-MM-DD')
                }
            );
        }
    }

	$('.angka_nominal').keyup(function(event) {

		// skip for arrow keys
		if(event.which >= 37 && event.which <= 40) return;

		// format number
		$(this).val(function(index, value) {
			return value
				.replace(/\D/g, "")
				.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
				;
		});
	});

    function send_message(message) {
        socket.emit('new message', message);
    }

    function to_rp(angka, param=null){
        if(angka != '' || angka != 0){
            var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
            var rev2    = '';
            for(var i = 0; i < rev.length; i++){
                rev2  += rev[i];
                if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
                    rev2 += ',';
                }
            }

            var dec		= parseFloat(angka, 10).toString().split('.');
            if(dec[1] > 0){ dec = dec[1]; } else { dec = '00'; }

            //return 'IDR : ' + rev2.split('').reverse().join('') + ',-';
            return rev2.split('').reverse().join('') + (param==null?'.' + dec:'');
        } else {
            //return 'IDR : ';
            return '0';
        }
    }

	function hapuskoma(str) {
        str = str.toString();
		while (str.search(",") >= 0) {
			str = (str + "").replace(',', '');
		}
		return str;
	}



	function cek_checkbox_checked(checkboxName) {
		var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked'), values = [];
		Array.prototype.forEach.call(checkboxes, function(el) {
			values.push(el.value);
		});
		return values;
	}
	
	function printDiv(divName){
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
		
		document.body.innerHTML = printContents;
		
		window.print();
		
		document.body.innerHTML = originalContents;
        window.onafterprint = location.reload();
		//location.reload();
	}

	function PrintOtherPage(tag, url) {
		$("<iframe>")                             // create a new iframe element
			.hide()                               // make it invisible
			.attr("src", url)                    // point the iframe to the page you want to print
			.appendTo(tag);                       // add iframe to the DOM to cause it to load the page
	}

    function isMoney(field, tipe='-'){
        var value = $("#"+field).val();

        if(value != '' && value != '0' && value != 0){
            var min = value.split("-");
            var dec = value.split(".");
            var str;

            str = hapusmin(dec[0]);

            str = hapuskoma(str).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

            if(tipe=='-' && min[0]=='' && min[1]!=undefined){
                str = '-' + hapusmin(str);
            }

            if(dec[1]!=undefined){
                str = str + '.' + hapusmin(hapuskoma(dec[1]));
            }

            $("#"+field).val(str);
        } else {
            $("#"+field).val('');
        }
    }

    function isNumber(evt, tipe='-') {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        // 48-57 = 0-9 / 96-105 = 0-9 (num pad)
        // 8 = backspace
        // 9 = tab
        // 37 = <-
        // 39 = ->
        // 46 = delete
        // 173 = - / 109 = - (num pad)
        // 190 = .
        // 17 + (65 + 67 + 86 + 88) = ctrl + (a + c + v + x)
        if (tipe=='-' && ((charCode>=48 && charCode<=57) || (charCode>=96 && charCode<=105) ||
            (charCode==8 || charCode==9 || charCode==37 || charCode==39 || charCode==46 || charCode==109 || charCode==173 || charCode==190) ||
            (evt.ctrlKey && (charCode==65 || charCode==67 || charCode==86 || charCode==88)))) {
            return true;
        } else if (tipe=='+' && ((charCode>=48 && charCode<=57) || (charCode>=96 && charCode<=105) ||
            (charCode==8 || charCode==9 || charCode==37 || charCode==39 || charCode==46 || charCode==190) ||
            (evt.ctrlKey && (charCode==65 || charCode==67 || charCode==86 || charCode==88)))) {
            return true;
        } else {
            return false;
        }
    }

    function hapusmin(str) {
        str = str.toString();
        while (str.search("-") >= 0) {
            str = (str + "").replace('-', '');
        }
        return str;
    }
    function set_ckeditor(id){
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace(id, {
                height: 500,
                toolbar: [
                    { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source' ] },
                    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Undo', 'Redo' ] },
                    '/',
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript' ] },
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
                    { name: 'links', items: [ 'Link', 'Unlink' ] },
                    { name: 'insert', items: [ 'Image', 'Table' ] },
                    '/',
                    { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                    { name: 'others', items: [ '-' ] },
                    { name: 'about', items: [ 'About' ] }
                ]
            });
            //bootstrap WYSIHTML5 - text editor
            //$(".textarea").wysihtml5();
        });
    }

    $.fn.modal.Constructor.prototype.enforceFocus = function() {
        modal_this = this
        $(document).on('focusin.modal', function (e) {
            if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
                && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select')
                && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                modal_this.$element.focus()
            }
        })
    };
	

</script>

