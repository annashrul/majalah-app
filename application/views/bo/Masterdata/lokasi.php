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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="modal_title"></h4>
            </div>
            <form id="form_input">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Cari Lokasi</label>

                                <div class="col-sm-10">
                                    <input id="pac-input" class="controls form-control" type="text" placeholder="Cari Lokasi / Tandai Di Peta">
                                    <div id="map"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php $label = 'alamat'; ?>
                                <label for="<?=$label?>" class="col-sm-2 control-label">Alamat</label>

                                <div class="col-sm-10">
                                    <textarea type="text" name="<?=$label?>" class="form-control" id="<?=$label?>" rows="4" autocomplete="off" placeholder="Alamat"></textarea>
                                </div>
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
    function add() {
        $("#modal_title").text("Tambah <?=$title?>");
        $("#param").val("add");
        $("#modal_form").modal("show");
        initMap();
    }

    function validasi(action=''){

    }

    $("#modal_form").on("hide.bs.modal", function () {
        document.getElementById("form_input").reset();
    });
</script>