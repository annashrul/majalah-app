<style>
    #map {
        height: 400px;
        width: 100%;
    }

    #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
    }

    #infowindow-content .title {
        font-weight: bold;
    }

    #infowindow-content {
        display: none;
    }

    #map #infowindow-content {
        display: inline;
    }

    .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
    }

    #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
    }

    .pac-controls {
        display: inline-block;
        padding: 5px 11px;
    }

    .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 100%;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
    }
    #target {
        width: 345px;
    }
    .pac-container {
        background-color: #FFF;
        z-index: 1050;
        position: fixed;
        display: inline-block;
        float: left;
    }
</style>
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="pull-left page-title"><?=$title?></h4>
                    <ol class="breadcrumb pull-right">
                        <li><a href="<?=base_url()?>"><?=$site->title?></a></li>
                        <li class="active"><?=$title?></li>
                    </ol>
                </div>
            </div>
            <!-- Main Content -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row" style="margin-bottom: 3px">
                                <div class="col-sm-3">
                                    <div class="input-group" style="width: 100%;">
                                        <input type="text" id="any" name="table_search" class="form-control pull-right" onkeyup="return cari(event, $(this).val())" value="<?=isset($this->session->search['any'])?$this->session->search['any']:''?>" placeholder="Cari Lalu Tekan Enter">
                                        <div class="input-group-btn"><button type="button" class="btn btn-primary bg-blue" disabled><i class="fa fa-search"></i></button></div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary"  onclick="add(); validasi('add');">Tambah</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="responsive" id="result_table"></div>
                                <div align="center" id="pagination_link"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" id="modal_form" style="display: none">
    <div class="modal-dialog modal-lg" style="width: 100%;">
        <div class="modal-content" style="width: 100%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modal_title"></h4>
            </div>
            <form id="form_input">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php $label = 'nama'; ?>
                                <label>Nama</label>
                                <input id="<?=$label?>" class="form-control" type="text" name="<?=$label?>">
                            </div>
                            <div class="form-group">
                                <?php $label = 'tlp'; ?>
                                <label>Telepon</label>
                                <input id="<?=$label?>" class="form-control" type="text" name="<?=$label?>">
                            </div>
                            <div class="form-group">
                                <div class="col-sm-10" style="padding: 0px;">
                                    <?php $label = 'file_upload'; ?>
                                    <label for="<?=$label?>">Photo</label>
                                    <input type="hidden" id="<?=$label?>ed" name="<?=$label?>ed" />
                                    <input type="file" id="<?=$label?>" name="<?=$label?>" class="form-control" onchange="return ValidateFileUpload()" accept="image/*">
                                    <p class="error" id="alr_<?=$label?>"></p>
                                </div>
                                <div class="col-sm-2" style="padding: 0px;">
                                    <img style="width:100%; max-height:250px;" src="<?=base_url().'assets/images/no_images.png'?>" id="result_image">
                                </div>
                            </div>
                            <div class="form-group">
                                <div id="map"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">

                            <div class="form-group">
                                <?php $label = 'provinsi'; ?>
                                <label for="<?=$label?>">Provinsi</label>
                                <select name="<?=$label?>" id="<?=$label?>" class="select2"></select>
                            </div>
                            <div class="form-group" id="par_kota">
                                <?php $label = 'kota'; ?>
                                <label for="<?=$label?>">Kota</label>
                                <select name="<?=$label?>" id="<?=$label?>" class="select2">
                                    <option value="">Pilih Kota</option>
                                </select>

                            </div>
                            <div class="form-group" id="par_kota_">
                                <label for="">Kota</label>
                                <input type="text" name="kota_" id="kota_" class="form-control" readonly>
                            </div>
                            <div class="form-group" id="par_kecamatan">
                                <?php $label = 'kecamatan'; ?>
                                <label for="<?=$label?>">Kecamatan</label>
                                <select name="<?=$label?>" id="<?=$label?>" class="select2">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="form-group" id="par_kecamatan_">
                                <label for="">Kecamatan</label>
                                <input type="text" name="kecamatan_" id="kecamatan_" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Cari Lokasi</label>
                                <input id="pac-input" class="controls form-control" type="text" placeholder="Cari Lokasi / Tandai Di Peta">
                            </div>
                            <div class="form-group">
                                <?php $label = 'alamat'; ?>
                                <label for="<?=$label?>">Alamat</label>
                                <textarea type="text" name="<?=$label?>" class="form-control" id="<?=$label?>" rows="4" autocomplete="off" placeholder="Alamat" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
                </div>
                <input type="hidden" name="lng" id="lng">
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="param" id="param" value="add">
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="id_kota" id="id_kota">
                <input type="hidden" name="id_kecamatan" id="id_kecamatan">
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $("#pac-input").keypress(function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });

    $('#result_table').on('show.bs.dropdown', function () {
        document.querySelector('style').textContent += "@media only screen and (max-width: 500px) {.dropdown-position {position: relative}} @media only screen and (min-width: 500px) {.table-responsive {overflow: inherit !important}}";
    }).on('hide.bs.dropdown', function () {
        document.querySelector('style').textContent += "@media only screen and (min-width: 500px) {.table-responsive {overflow: auto}}";
    });

    function initMap(zoom_=14, lat_=-6.9228583, lng_=107.6058134, id_='map', param_='edit') {
        var uluru = {lat: lat_, lng: lng_};
        var map = new google.maps.Map(document.getElementById(id_), {
            zoom: zoom_,
            center: uluru
        });

        var geocoder = new google.maps.Geocoder;

        var marker = new google.maps.Marker({
            map: map
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        //map.controls[google.maps.ControlPosition.TOP_CENTER].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                    $("#alamat").val(place.formatted_address);
                    $("#lat").val(place.geometry.location.lat());
                    $("#lng").val(place.geometry.location.lng());
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });

        if (param_ == 'set' || $("#param").val()=='edit') {
            marker.setPosition(uluru);
        }

        google.maps.event.addListener(map, 'click', function(e) {
            if (param_ == 'edit') {
                var latLng = e.latLng;
                marker.setPosition(latLng);
                $("#lat").val(latLng.lat());
                $("#lng").val(latLng.lng());
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                geocoder.geocode({
                    'latLng': latLng
                }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $("#alamat").val(results[0].formatted_address);
                            $("#pac-input").val('');
                        }
                    }
                });
            }
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDqD1Z03FoLnIGJTbpAgRvjcchrR-NiICk&libraries=places" async defer></script>

<script type="text/javascript">
    $(document).ready(function(){
        load_data(1);
        load_provinsi();

    }).on("click", ".pagination li a", function(event){
        event.preventDefault();
        var page = $(this).data("ci-pagination-page");
        load_data(page);
    });
    function cari(e=null, val=null) {
        if (e.keyCode == 13) {
            load_data(1, {search:true, any:val});
        }
    }
    function load_data(page,data={}){
        $.ajax({
            url         : "<?=base_url().$content.'/get_data/';?>"+page,
            type        : "POST",
            data        : data,
            dataType    : "JSON",
            beforeSend  : function() {$('body').append('<div class="first-loader"><img src="<?=base_url().'/assets/images/spin.svg'?>"></div>');},
            complete    : function() {$('.first-loader').remove();},
            success     : function(data){
                $('#result_table').html(data.result_table);
                $('#pagination_link').html(data.pagination_link);
            }
        });
    }
    function add() {
        $("#modal_title").text("Tambah <?=$title?>");
        $("#param").val("add");
        $("#modal_form").modal("show");
        $("#par_kota_,#par_kecamatan_").hide();
        $("#par_kota,#par_kecamatan").show();
        initMap();

    }


    function load_provinsi(){
        $.ajax({
            url : "<?=base_url().'ajax/get_provinsi'?>",
            type : "POST",
            dataType : "JSON",
            beforeSend  : function() {$('body').append('<div class="first-loader"><img src="<?=base_url().'/assets/images/spin.svg'?>"></div>');},
            complete    : function() {$('.first-loader').remove();},
            success : function(res){
                if (res.status===true) {
                    var label = $("#provinsi"), obj = res.result, html = "";
                    html+="<option value=''>Pilih Provinsi</option>";
                    for(var i = 0; i<obj.length; i++){
                        html += "<option value='"+obj[i].id+"'>"+obj[i].name+"</option>";
                        label.html(html);
                        label.select2("val",$('#provinsi option:nth-child(1)').val());
                    }
                } else {
                    alert("Error getting data!")
                }
            }
        });
    }





    $("#provinsi").on('click',function(){
        $.ajax({
            url : "<?=base_url().'ajax/get_kota'?>",
            type : "POST",
            dataType : "JSON",
            data:{id:$("#provinsi").val()},
            beforeSend  : function() {$('body').append('<div class="first-loader"><img src="<?=base_url().'/assets/images/spin.svg'?>"></div>');},
            complete    : function() {$('.first-loader').remove();},
            success : function(res){
                if (res.status===true) {
                    $("#par_kota").show();$("#par_kota_").hide();
                    var label = $("#kota"), obj = res.result, html = "";
                    html+="<option value=''>Pilih Kota</option>";
                    for(var i = 0; i<obj.length; i++){
                        html += "<option value='"+obj[i].id+"'>"+obj[i].name+"</option>";
                        label.html(html);
                        label.select2("val",$('#kota option:nth-child(1)').val());
                    }

                    $("#id_kota").val('');

                } else {
                    alert("Error getting data!")
                }
            }
        });
    });

    $("#kota").on('click',function(){
        $.ajax({
            url : "<?=base_url().'ajax/get_kecamatan'?>",
            type : "POST",
            dataType : "JSON",
            data:{id:$("#kota").val()},
            beforeSend  : function() {$('body').append('<div class="first-loader"><img src="<?=base_url().'/assets/images/spin.svg'?>"></div>');},
            complete    : function() {$('.first-loader').remove();},
            success : function(res){
                if (res.status===true) {
                    $("#par_kecamatan").show();$("#par_kecamatan_").hide();
                    var label = $("#kecamatan"), obj = res.result, html = "";
                    html+="<option value=''>Pilih Kecamatan</option>";
                    for(var i = 0; i<obj.length; i++){
                        html += "<option value='"+obj[i].id+"'>"+obj[i].name+"</option>";
                        label.html(html);
                        label.select2("val",$('#kecamatan option:nth-child(1)').val());
                    }
                    $("#id_kecamatan").val('');
                } else {
                    alert("Error getting data!")
                }
            }
        });
    });




    $('#form_input').validate({
        rules: {
            nama        : {required: true},
            alamat      : {required: true},
            tlp         : {required: true},
            provinsi    : {required: true},
            kota        : {required: true},
            kecamatan   : {required: true},
            // file_upload : {required: true, accept: "png|jpeg|jpg"}
        },
        messages: {
            nama        : {required: "nama tidak boleh kosong!"},
            alamat      : {required: "alamat tidak boleh kosong!"},
            tlp         : {required: "no telepon tidak boleh kosong!"},
            provinsi    : {required: "provinsi tidak boleh kosong!"},
            kota        : {required: "kota tidak boleh kosong!"},
            kecamatan   : {required: "kecamatan tidak boleh kosong!"},
            // file_upload : {required: "Gambar tidak boleh kosong",accept: "Tipe file yang hanya boleh PNG, JPG, dan JPEG!"}
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            placement?$(placement).append(error):error.insertAfter(element);
        },
        submitHandler: function (form) {
            const myForm = document.getElementById('form_input');
            $.ajax({
                url         : "<?=base_url().$content.'/simpan'?>",
                type        : "POST",
                data        : new FormData(myForm),
                mimeType    : "multipart/form-data",
                contentType : false,
                processData : false,
                beforeSend  : function() {$('body').append('<div class="first-loader"><img src="<?=base_url().'/assets/images/spin.svg'?>"></div>');},
                complete    : function() {$('.first-loader').remove();},
                success     : function(res) {
                    if (res) {
                        swal("Kerja Bagus!","Data Berhasil Disimpan!","success");
                        $("#modal_form").modal('hide');
                        load_data(1);
                    } else {
                        alert("Data gagal disimpan!");
                    }
                }
            });
        }
    });


    function edit(id) {
        $.ajax({
            url: "<?=base_url().$content.'/edit'?>",
            type: "POST",
            data: {id: id},
            dataType: "JSON",
            beforeSend: function() {
                $('body').append('<div class="first-loader"><img src="<?=base_url().'/assets/images/spin.svg'?>"></div>');
            },
            complete: function() {
                $('.first-loader').remove();
            },
            success: function (res) {
                console.log(res.res_data);
                if (res.status) {
                    $("#modal_title").text("Edit Lokasi");
                    $("#param").val("edit");
                    $("#id").val(id);
                    $("#nama").val(res.res_data['nama']);
                    $("#tlp").val(res.res_data['tlp1']);
                    $("#alamat").val(res.res_data['alamat']);
                    $("#lng").val(res.res_data['longitude']);
                    $("#lat").val(res.res_data['latitude']);

                    $("#provinsi").val(res.res_data['provinsi']).change();

                    $("#par_kota").hide();
                    $("#par_kecamatan").hide();

                    $("#par_kota_").show();
                    $("#kota_").val(res.res_data['nama_kota']);
                    $("#id_kota").val(res.res_data['id_kota']);
                    $("#id_kecamatan").val(res.res_data['id_kecamatan']);
                    $("#par_kecamatan_").show();
                    $("#kecamatan_").val(res.res_data['nama_kecamatan']);




                    $('#file_upload').val('');
                    $('#file_uploaded').val((res.res_data['gambar']!=''?res.res_data['gambar']:''));
                    $('#result_image').attr('src', '<?= base_url() ?>' + (res.res_data['gambar']!=''?res.res_data['gambar']:'assets/images/no_images.png'));
                    initMap(18, parseFloat(res.res_data['latitude']), parseFloat(res.res_data['longitude']), 'map', 'edit');
                    $("#modal_form").modal("show");
                    setTimeout(function () {
                        $("#nama").focus();
                    }, 600);
                } else {
                    alert("Error getting data!")
                }
            }
        });
    }

    function hapus(id){
        swal({
            title: 'Anda Yakin?',
            text: "Anda Tidak Dapat Mengembalikan Data Ini!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin !',
            closeOnConfirm: false
        }).then(function(isConfirm){
            if (isConfirm) {
                $.ajax({
                    url: "<?=base_url() . $content . '/hapus'?>",
                    type: "POST",
                    data: {id: id},
                    beforeSend: function() {
                        $('body').append('<div class="first-loader"><img src="<?=base_url().'/assets/images/spin.svg'?>"></div>');
                    },
                    complete: function() {
                        $('.first-loader').remove();
                    },
                    success: function(res){
                        if(res){
                            swal('Success!','Data Anda Berhasil Dihapus.', 'success');
                            load_data(1);
                        }else{
                            alert("Error deleting data!");
                        }

                    },error: function(xhr, status, error) {
                        alert("Data tidak bisa dihapus!");
                        console.log(xhr.responseText);
                    }
                });
            }
        })
    }

    function validasi(action=''){

    }

    $("#modal_form").on("hide.bs.modal", function () {
        document.getElementById("form_input").reset();
    });

    function ValidateFileUpload() {
        var fuData = document.getElementById('file_upload');
        var FileUploadPath = fuData.value;
        var valid = 1;
        $("#alr_file_upload").text("");
        if (FileUploadPath == '') {
        } else {
            var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
            if (Extension == "gif" || Extension == "png" || Extension == "bmp" || Extension == "jpeg" || Extension == "jpg") {
                if (fuData.files && fuData.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#result_image').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(fuData.files[0]);
                }
            }
        }
        return valid;
    }
</script>