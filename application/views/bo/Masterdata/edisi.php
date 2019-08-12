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
                                <?php $label = 'nama'; ?>
                                <label for="<?=$label?>">Nama</label>
                                <input type="text" name="<?=$label?>" id="<?=$label?>" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <?php $label = 'tanggal'; ?>
                                <label for="<?=$label?>">Tanggal</label>
                                <input type="text" name="<?=$label?>" class="form-control daterangesingle" id="<?=$label?>" autocomplete="off"  readonly />
                            </div>
                            <div class="form-group">
                                <?php $label = 'file_upload'; ?>
                                <label for="<?=$label?>">Gambar</label>
                                <input type="hidden" id="<?=$label?>ed" name="<?=$label?>ed" />
                                <input type="file" id="<?=$label?>" name="<?=$label?>" class="form-control" onchange="return ValidateFileUpload()" accept="image/*">
                                <p class="error" id="alr_<?=$label?>"></p>
                            </div>
                            <div class="col-sm-12" style="padding:0px;">
                                <img style="max-width:100%; max-height:250px;" src="<?=base_url().'assets/images/no_images.png'?>" id="result_image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan</button>
                </div>
                <input type="hidden" name="param" id="param" value="add">
                <input type="hidden" name="id" id="id">
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<style>
    .bootstrap-tagsinput {
        width: 100% !important;
        height : 34px!important;
    }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        load_data(1);
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
    $("#tanggal").on('change',function(){
        $("#nama").val("Edisi "+$(this).val())
    })
    $('#form_input').validate({
        rules: {
            nama: {
                required: true,
                remote: {
                    url: "<?=base_url().$content.'/cek_nama'?>",
                    type: "post",
                    data: {
                        param: function() {
                            return $("#param").val();
                        }
                    }
                }
            },
            file_upload     : {required: true, accept: "png|jpeg|jpg"}
        },
        //For custom messages
        messages: {
            nama:{
                required: "Edisi tidak boleh kosong!",
                remote: "Edisi sudah tersedia!"
            },
            file_upload     : {required: "Gambar tidak boleh kosong",accept: "Tipe file yang hanya boleh PNG, JPG, dan JPEG!"}

        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
            var placement = $(element).data('error');
            placement?$(placement).append(error):error.insertAfter(element);
        },
        submitHandler: function (form) {
            const myForm = document.getElementById('form_input');
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
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
            beforeSend: function() {$('body').append('<div class="first-loader"><img src="<?=base_url().'/assets/images/spin.svg'?>"></div>');},
            complete: function() {$('.first-loader').remove();},
            success: function (res) {
                if (res.status) {
                    $("#modal_title").text("Edit <?=$title?>");
                    $("#param").val("edit");
                    $("#id").val(id);
                    $("#nama").val(res.res_data['nama']);
                    set_date(res.res_data['tanggal'], 'daterangesingle');
                    $('#file_upload').val('');
                    $('#file_uploaded').val((res.res_data['gambar']!=''?res.res_data['gambar']:''));
                    $('#result_image').attr('src', '<?= base_url() ?>' + (res.res_data['gambar']!=''?res.res_data['gambar']:'assets/images/no_images.png'));
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
                    beforeSend: function() {$('body').append('<div class="first-loader"><img src="<?=base_url().'/assets/images/spin.svg'?>"></div>');},
                    complete: function() {$('.first-loader').remove();},
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

    function add() {
        $("#modal_title").text("Tambah <?=$title?>");
        $("#param").val("add");
        $("#modal_form").modal("show");
        setTimeout(function () {
            $("#nama").focus();
            $('#result_image').attr('src', '<?= base_url() ?>' + ('assets/images/no_images.png'));
        }, 600);
    }

    function validasi(action=''){
        if(action=='add'){
            $('#file_upload').rules('remove', 'required');
            $('#file_upload').rules('add', {required: true});
        } else if(action=='edit'){
            $('#file_upload').rules('remove', 'required');
            $('#file_upload').rules('add', {required: false});
        }
    }

    $("#modal_form").on("hide.bs.modal", function () {
        document.getElementById("form_input").reset();
        $( "#form_input" ).validate().resetForm();
        $('#result_image').attr('src', '<?= base_url() ?>' + 'assets/images/no_images.png');
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