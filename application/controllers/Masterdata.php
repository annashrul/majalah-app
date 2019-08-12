<?php
/**
 * Created by PhpStorm.
 * User: annashrul yusuf
 * Date: 07/08/2019
 * Time: 13:05
 */

class Masterdata extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->control = 'Masterdata';
        $this->output->set_header("Cache-Control: no-store, no-cache, max-age=0, post-check=0, pre-check=0");

        $site_data = $this->m_website->site_data();
        $this->site = str_replace(' ', '', strtolower($site_data->title));
        $this->user = $this->session->userdata($this->site . 'user');
        $this->username = $this->session->userdata($this->site . 'username');


        $this->data = array(
            'site' => $site_data,
            'account' => $this->m_website->user_data($this->user),
            'access' => $this->m_website->user_access_data($this->user)
        );
    }

    public function berita($action=null, $page=1){
        $data = $this->data;
        $function = 'berita';
        $view = $this->control.'/';
        if($this->session->userdata($this->site . 'admin_menu')!=$function){
            $this->session->unset_userdata('search');
            $this->session->set_userdata($this->site . 'admin_menu', $function);
        }
        $data['title'] = 'Berita';
        $data['page'] = $function;
        $data['content'] = $view.$function;
        $table = $function;
        $where = null;

        if(isset($_POST['search'])||isset($_POST['to_excel'])) {
            $this->session->set_userdata('search', array('any' => $_POST['any']));
        }

        $search = $this->session->search['any'];
        if(isset($search)&&$search!=null) {
            ($where == null) ? null : $where .= " AND ";
            $where .= "judul like '%".$search."%'";
        }

        if($action == 'get_data'){
            $config = array();
            $config["base_url"] = "#";
            //$config["total_rows"] = $this->ajax_pagination_model->count_all();
            $config["total_rows"] = $this->m_crud->count_data($table, "id_berita", $where);
            $config["per_page"] = 6;
            $config["uri_segment"] = 4;
            $config["num_links"] = 5;
            $config["use_page_numbers"] = TRUE;
            $config["full_tag_open"] = '<ul class="pagination pagination-sm">';
            $config["full_tag_close"] = '</ul>';
            $config['first_link'] = '&laquo;';
            $config["first_tag_open"] = '<li>';
            $config["first_tag_close"] = '</li>';
            $config['last_link'] = '&raquo;';
            $config["last_tag_open"] = '<li>';
            $config["last_tag_close"] = '</li>';
            $config['next_link'] = '&gt;';
            $config["next_tag_open"] = '<li>';
            $config["next_tag_close"] = '</li>';
            $config["prev_link"] = "&lt;";
            $config["prev_tag_open"] = "<li>";
            $config["prev_tag_close"] = "</li>";
            $config["cur_tag_open"] = "<li class='active'><a href='#'>";
            $config["cur_tag_close"] = "</a></li>";
            $config["num_tag_open"] = "<li>";
            $config["num_tag_close"] = "</li>";
            $this->pagination->initialize($config);
            $start = ($page - 1) * $config["per_page"];

            $output = '';
            $read_data = $this->m_crud->join_data(
                $table.' b', "b.*, kb.nama nama_kategori, e.nama nama_edisi",
                array(array("type"=>"LEFT","table"=>"kategori_berita kb"),array("type"=>"LEFT","table"=>"edisi e")),
                array("b.id_kategori_berita=kb.id_kategori_berita","e.id_edisi=b.id_edisi"),
                $where, 'b.tanggal desc', null, $config["per_page"], $start);
            $output .= /** @lang text */
                '
                <table class="table table-hover">
                <tr>
                    <th width="1%">No</th>
                    <th width="1%" class="text-center">#</th>
                    <th>Judul</th>
                    <th>Edisi</th>
                    <th>Tanggal</th>
                    <th>Gambar</th>
                    <th>Ringkasan</th>
                    <th>Isi</th>
                    <th>Kategori</th>
                </tr>
            ';
            $no = $start+1;
            if ($read_data != null) {
                foreach ($read_data as $row) {
                    $gambar = '<img style="max-height:50px;max-width:80px;" src="' . base_url().$row['gambar'] . '" />';
                    $output .= /** @lang text */'
                    <tr>
                        <td>' . $no++ . '</td>
                        <td>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">Pilihan <span class="fa fa-caret-down"></span></button>
                            <ul class="dropdown-menu dropdown-position">
                                <li><a href="#" onclick="edit(\'' . $row['id_berita'] . '\'); validasi(\'edit\');">Edit</a></li>
                                <li><a href="#" onclick="hapus(\'' . $row['id_berita'] . '\')">Hapus</a></li>
                            </ul>
                        </div>
                        </td>
                        <td>' . $row['judul'] . '</td>
                        <td>' . $row['nama_edisi'] . '</td>
                        <td>' . $row['tanggal'] . '</td>
                        <td>' . $gambar . '</td>
                        <td>' . substr(strip_tags($row['ringkasan']), 0, 100) . '</td>
                        <td>' . substr(strip_tags($row['isi']), 0, 100) . '</td>
                        <td>' . $row['nama_kategori'] . '</td>
                    </tr>
                ';
                }
            } else {
                $output .= '<tr><td colspan="9" class="text-center">Tidak ada data</td></tr>';
            }
            $output .= '</table>';

            $result = array(
                'pagination_link' => $this->pagination->create_links(),
                'result_table' => $output
            );
            echo json_encode($result);
        }
        elseif ($action == 'simpan'){
            $this->db->trans_begin();
            $path = 'assets/images/berita';
            $config['upload_path']          = './'.$path;
            $config['allowed_types']        = 'bmp|gif|jpg|jpeg|png';
            $config['max_size']             = 5120;
            $config['encrypt_name'] 	= TRUE;
            $this->load->library('upload', $config);
            $input_file = array('1'=>'file_upload');
            $valid = true;
            foreach($input_file as $row){
                if( (! $this->upload->do_upload($row)) && $_FILES[$row]['name']!=null){
                    $file[$row]['file_name']=null;
                    $file[$row] = $this->upload->data();
                    $valid = false;
                    $data['error_'.$row] = $this->upload->display_errors();
                    break;
                } else{
                    $file[$row] = $this->upload->data();
                    $data[$row] = $file;
                    if($file[$row]['file_name']!=null){
                        $manipulasi['image_library']    = 'gd2';
                        $manipulasi['source_image']     = $file[$row]['full_path'];
                        $manipulasi['maintain_ratio']   = true;
                        $manipulasi['width']            = 500;
                        $this->load->library('image_lib', $manipulasi);
                        $this->image_lib->resize();
                    }
                }
            }
            if($valid==true) {
                $data_berita = array(
                    'user_id'           => $this->user,
                    'id_kategori_berita'=> $_POST['kategori_berita'],
                    'id_edisi'          => $_POST['edisi'],
                    'judul'             => $_POST['judul'],
                    'tanggal'           => isset($_POST['tanggal'])?date('Y-m-d', strtotime($_POST['tanggal'])).' '.date('H:i:s'):null,
                    'ringkasan'         => $_POST['ringkasan'],
                    'isi'               => $_POST['deskripsi'],
                    'tag'               => $_POST['tag'],
                    'slug'              => url_title($_POST['judul'], 'dash', true)
                );
                if($_FILES['file_upload']['name']!=null) {
                    $data_berita['gambar'] = ($_FILES['file_upload']['name']!=null)?($path.'/'.$file['file_upload']['file_name']):null;
                    if($_POST['file_uploaded']!=null||$_POST['file_uploaded']!=''){
                        unlink($_POST['file_uploaded']);
                    }
                }

                if ($_POST['param'] == 'add') {
                    $this->m_crud->create_data($table, $data_berita);
                } else {
                    $id = $_POST['id'];
                    $this->m_crud->update_data($table, $data_berita, "id_berita='".$id."'");
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo false;
            } else {
                $this->db->trans_commit();
                echo $valid;
            }
        }
        else if ($action == 'edit') {

            $get_data = $this->m_crud->get_data($table, "*", "id_berita='".$_POST['id']."'");
            $result = array();
            if ($get_data != null) {
                $result['status'] = true;
                $result['res_data'] = $get_data;
            } else {
                $result['status'] = false;
            }

            echo json_encode($result);
        }
        else if ($action == 'hapus') {
            $file = $this->m_crud->get_data($table, 'gambar', "id_berita = '".$_POST['id']."'");

            $delete_data = $this->m_crud->delete_data($table, "id_berita = '".$_POST['id']."'");

            if ($delete_data) {
                if($file!=null){unlink($file['gambar']);}
                $status = true;
            } else {
                $status = false;
            }

            echo $status;
        }
        else{
            $this->load->view('bo/index', $data);
        }

    }


    public function kategori_berita($action=null, $page=1){
        $data = $this->data;
        $function = 'kategori_berita';
        $view = $this->control.'/';
        if($this->session->userdata($this->site . 'admin_menu')!=$function){
            $this->session->unset_userdata('search');
            $this->session->set_userdata($this->site . 'admin_menu', $function);
        }
        $data['title'] = 'Kategori Berita';
        $data['page'] = $function;
        $data['content'] = $view.$function;
        $table = $function;
        $where = null;

        if(isset($_POST['search'])||isset($_POST['to_excel'])) {
            $this->session->set_userdata('search', array('any' => $_POST['any']));
        }

        $search = $this->session->search['any'];
        if(isset($search)&&$search!=null) {
            ($where == null) ? null : $where .= " AND ";
            $where .= "nama like '%".$search."%'";
        }

        if($action == 'get_data'){
            $config = array();
            $config["base_url"] = "#";
            //$config["total_rows"] = $this->ajax_pagination_model->count_all();
            $config["total_rows"] = $this->m_crud->count_data($table, "id_kategori_berita", $where);
            $config["per_page"] = 6;
            $config["uri_segment"] = 4;
            $config["num_links"] = 5;
            $config["use_page_numbers"] = TRUE;
            $config["full_tag_open"] = '<ul class="pagination pagination-sm">';
            $config["full_tag_close"] = '</ul>';
            $config['first_link'] = '&laquo;';
            $config["first_tag_open"] = '<li>';
            $config["first_tag_close"] = '</li>';
            $config['last_link'] = '&raquo;';
            $config["last_tag_open"] = '<li>';
            $config["last_tag_close"] = '</li>';
            $config['next_link'] = '&gt;';
            $config["next_tag_open"] = '<li>';
            $config["next_tag_close"] = '</li>';
            $config["prev_link"] = "&lt;";
            $config["prev_tag_open"] = "<li>";
            $config["prev_tag_close"] = "</li>";
            $config["cur_tag_open"] = "<li class='active'><a href='#'>";
            $config["cur_tag_close"] = "</a></li>";
            $config["num_tag_open"] = "<li>";
            $config["num_tag_close"] = "</li>";
            $this->pagination->initialize($config);
            $start = ($page - 1) * $config["per_page"];

            $output = '';
            $read_data = $this->m_crud->read_data(
                $table.' k', "k.*",
                $where, 'k.tgl_insert desc', null, $config["per_page"], $start);
            $output .= /** @lang text */
                '
                <table class="table table-hover">
                <tr>
                    <th width="1%">No</th>
                    <th width="1%" class="text-center">#</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                </tr>
            ';
            $no = $start+1;
            if ($read_data != null) {
                foreach ($read_data as $row) {
                    if($row['gambar']!=null){
                        $gambar = '<img style="max-height:50px;max-width:80px;" src="' . base_url().$row['gambar'] . '" />';
                    }else{
                        $gambar = '<img style="max-height:50px;max-width:80px;" src="' . base_url()."assets/images/no_images.png" . '" />';
                    }

                    $output .= /** @lang text */'
                    <tr>
                        <td>' . $no++ . '</td>
                        <td>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">Pilihan <span class="fa fa-caret-down"></span></button>
                            <ul class="dropdown-menu dropdown-position">
                                <li><a href="#" onclick="edit(\'' . $row['id_kategori_berita'] . '\'); validasi(\'edit\');">Edit</a></li>
                                <li><a href="#" onclick="hapus(\'' . $row['id_kategori_berita'] . '\')">Hapus</a></li>
                            </ul>
                        </div>
                        </td>
                        <td>' . $row['nama'] . '</td>
                        <td>' . $gambar . '</td>
                    </tr>
                ';
                }
            } else {
                $output .= '<tr><td colspan="9" class="text-center">Tidak ada data</td></tr>';
            }
            $output .= '</table>';

            $result = array(
                'pagination_link' => $this->pagination->create_links(),
                'result_table' => $output
            );
            echo json_encode($result);
        }else if ($action == 'cek_nama') {
            $where = "nama='".$_POST['nama']."'";

            $_POST['param']=='edit'?$where.=" AND nama<>'".$_POST['nama']."'":null;

            $cek_nama = $this->m_crud->get_data($table, "nama", $where);

            if ($cek_nama == null) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
        elseif ($action == 'simpan'){
            $this->db->trans_begin();
            $path = 'assets/images/kategori_berita';
            $config['upload_path']          = './'.$path;
            $config['allowed_types']        = 'bmp|gif|jpg|jpeg|png';
            $config['max_size']             = 5120;
            $config['encrypt_name'] 	= TRUE;
            $this->load->library('upload', $config);
            $input_file = array('1'=>'file_upload');
            $valid = true;
            foreach($input_file as $row){
                if( (! $this->upload->do_upload($row)) && $_FILES[$row]['name']!=null){
                    $file[$row]['file_name']=null;
                    $file[$row] = $this->upload->data();
                    $valid = false;
                    $data['error_'.$row] = $this->upload->display_errors();
                    break;
                } else{
                    $file[$row] = $this->upload->data();
                    $data[$row] = $file;
                    if($file[$row]['file_name']!=null){
                        $manipulasi['image_library']    = 'gd2';
                        $manipulasi['source_image']     = $file[$row]['full_path'];
                        $manipulasi['maintain_ratio']   = true;
                        $manipulasi['width']            = 500;
                        $this->load->library('image_lib', $manipulasi);
                        $this->image_lib->resize();
                    }
                }
            }
            if($valid==true) {
                $data_berita = array(
                    'nama'  => $_POST['nama'],
                    'slug'  => url_title($_POST['nama'], 'dash', true)

                );
                if($_FILES['file_upload']['name']!=null) {
                    $data_berita['gambar'] = ($_FILES['file_upload']['name']!=null)?($path.'/'.$file['file_upload']['file_name']):null;
                    if($_POST['file_uploaded']!=null||$_POST['file_uploaded']!=''){
                        unlink($_POST['file_uploaded']);
                    }
                }

                if ($_POST['param'] == 'add') {
                    $this->m_crud->create_data($table, $data_berita);
                } else {
                    $id = $_POST['id'];
                    $this->m_crud->update_data($table, $data_berita, "id_kategori_berita='".$id."'");
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo false;
            } else {
                $this->db->trans_commit();
                echo $valid;
            }
        }
        else if ($action == 'edit') {

            $get_data = $this->m_crud->get_data($table, "*", "id_kategori_berita='".$_POST['id']."'");
            $result = array();
            if ($get_data != null) {
                $result['status'] = true;
                $result['res_data'] = $get_data;
            } else {
                $result['status'] = false;
            }

            echo json_encode($result);
        }
        else if ($action == 'hapus') {
            $file = $this->m_crud->get_data($table, 'gambar', "id_kategori_berita = '".$_POST['id']."'");

            $delete_data = $this->m_crud->delete_data($table, "id_kategori_berita = '".$_POST['id']."'");

            if ($delete_data) {
                if($file!=null){unlink($file['gambar']);}
                $status = true;
            } else {
                $status = false;
            }

            echo $status;
        }
        else{
            $this->load->view('bo/index', $data);
        }

    }

    public function edisi($action=null, $page=1){
        $data = $this->data;
        $function = 'edisi';
        $view = $this->control.'/';
        if($this->session->userdata($this->site . 'admin_menu')!=$function){
            $this->session->unset_userdata('search');
            $this->session->set_userdata($this->site . 'admin_menu', $function);
        }
        $data['title'] = 'Edisi';
        $data['page'] = $function;
        $data['content'] = $view.$function;
        $table = $function;
        $where = null;

        if(isset($_POST['search'])||isset($_POST['to_excel'])) {
            $this->session->set_userdata('search', array('any' => $_POST['any']));
        }

        $search = $this->session->search['any'];
        if(isset($search)&&$search!=null) {
            ($where == null) ? null : $where .= " AND ";
            $where .= "nama like '%".$search."%'";
        }

        if($action == 'get_data'){
            $config = array();
            $config["base_url"] = "#";
            //$config["total_rows"] = $this->ajax_pagination_model->count_all();
            $config["total_rows"] = $this->m_crud->count_data($table, "id_edisi", $where);
            $config["per_page"] = 6;
            $config["uri_segment"] = 4;
            $config["num_links"] = 5;
            $config["use_page_numbers"] = TRUE;
            $config["full_tag_open"] = '<ul class="pagination pagination-sm">';
            $config["full_tag_close"] = '</ul>';
            $config['first_link'] = '&laquo;';
            $config["first_tag_open"] = '<li>';
            $config["first_tag_close"] = '</li>';
            $config['last_link'] = '&raquo;';
            $config["last_tag_open"] = '<li>';
            $config["last_tag_close"] = '</li>';
            $config['next_link'] = '&gt;';
            $config["next_tag_open"] = '<li>';
            $config["next_tag_close"] = '</li>';
            $config["prev_link"] = "&lt;";
            $config["prev_tag_open"] = "<li>";
            $config["prev_tag_close"] = "</li>";
            $config["cur_tag_open"] = "<li class='active'><a href='#'>";
            $config["cur_tag_close"] = "</a></li>";
            $config["num_tag_open"] = "<li>";
            $config["num_tag_close"] = "</li>";
            $this->pagination->initialize($config);
            $start = ($page - 1) * $config["per_page"];

            $output = '';
            $read_data = $this->m_crud->read_data(
                $table.' e', "e.*",
                $where, 'e.tgl_insert desc', null, $config["per_page"], $start);
            $output .= /** @lang text */
                '
                <table class="table table-hover">
                <tr>
                    <th width="1%">No</th>
                    <th width="1%" class="text-center">#</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                    <th>Tanggal</th>
                </tr>
            ';
            $no = $start+1;
            if ($read_data != null) {
                foreach ($read_data as $row) {
                    if($row['gambar']!=null){
                        $gambar = '<img style="max-height:50px;max-width:80px;" src="' . base_url().$row['gambar'] . '" />';
                    }else{
                        $gambar = '<img style="max-height:50px;max-width:80px;" src="' . base_url()."assets/images/no_images.png" . '" />';
                    }

                    $output .= /** @lang text */'
                    <tr>
                        <td>' . $no++ . '</td>
                        <td>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">Pilihan <span class="fa fa-caret-down"></span></button>
                            <ul class="dropdown-menu dropdown-position">
                                <li><a href="#" onclick="edit(\'' . $row['id_edisi'] . '\'); validasi(\'edit\');">Edit</a></li>
                                <li><a href="#" onclick="hapus(\'' . $row['id_edisi'] . '\')">Hapus</a></li>
                            </ul>
                        </div>
                        </td>
                        <td> Edisi ' . longdate_indo($row['tanggal']) . '</td>
                        <td>' . $gambar . '</td>
                        <td>' . longdate_indo($row['tanggal']) . '</td>
                    </tr>
                ';
                }
            } else {
                $output .= '<tr><td colspan="9" class="text-center">Tidak ada data</td></tr>';
            }
            $output .= '</table>';

            $result = array(
                'pagination_link' => $this->pagination->create_links(),
                'result_table' => $output
            );
            echo json_encode($result);
        }else if ($action == 'cek_nama') {
            $where = "nama='".$_POST['nama']."'";

            $_POST['param']=='edit'?$where.=" AND nama<>'".$_POST['nama']."'":null;

            $cek_nama = $this->m_crud->get_data($table, "nama", $where);

            if ($cek_nama == null) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
        elseif ($action == 'simpan'){
            $this->db->trans_begin();
            $path = 'assets/images/edisi';
            $config['upload_path']          = './'.$path;
            $config['allowed_types']        = 'bmp|gif|jpg|jpeg|png';
            $config['max_size']             = 5120;
            $config['encrypt_name'] 	= TRUE;
            $this->load->library('upload', $config);
            $input_file = array('1'=>'file_upload');
            $valid = true;
            foreach($input_file as $row){
                if( (! $this->upload->do_upload($row)) && $_FILES[$row]['name']!=null){
                    $file[$row]['file_name']=null;
                    $file[$row] = $this->upload->data();
                    $valid = false;
                    $data['error_'.$row] = $this->upload->display_errors();
                    break;
                } else{
                    $file[$row] = $this->upload->data();
                    $data[$row] = $file;
                    if($file[$row]['file_name']!=null){
                        $manipulasi['image_library']    = 'gd2';
                        $manipulasi['source_image']     = $file[$row]['full_path'];
                        $manipulasi['maintain_ratio']   = true;
                        $manipulasi['width']            = 500;
                        $this->load->library('image_lib', $manipulasi);
                        $this->image_lib->resize();
                    }
                }
            }
            if($valid==true) {
                $data_berita = array(
                    'nama'  => $_POST['nama'],
                    'slug'  => url_title($_POST['nama'], 'dash', true),
                    'tanggal'           => isset($_POST['tanggal'])?date('Y-m-d', strtotime($_POST['tanggal'])).' '.date('H:i:s'):null,
                );
                if($_FILES['file_upload']['name']!=null) {
                    $data_berita['gambar'] = ($_FILES['file_upload']['name']!=null)?($path.'/'.$file['file_upload']['file_name']):null;
                    if($_POST['file_uploaded']!=null||$_POST['file_uploaded']!=''){
                        unlink($_POST['file_uploaded']);
                    }
                }

                if ($_POST['param'] == 'add') {
                    $this->m_crud->create_data($table, $data_berita);
                } else {
                    $id = $_POST['id'];
                    $this->m_crud->update_data($table, $data_berita, "id_edisi='".$id."'");
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo false;
            } else {
                $this->db->trans_commit();
                echo $valid;
            }
        }
        else if ($action == 'edit') {

            $get_data = $this->m_crud->get_data($table, "*", "id_edisi='".$_POST['id']."'");
            $result = array();
            if ($get_data != null) {
                $result['status'] = true;
                $result['res_data'] = $get_data;
            } else {
                $result['status'] = false;
            }

            echo json_encode($result);
        }
        else if ($action == 'hapus') {
            $file = $this->m_crud->get_data($table, 'gambar', "id_edisi = '".$_POST['id']."'");

            $delete_data = $this->m_crud->delete_data($table, "id_edisi = '".$_POST['id']."'");

            if ($delete_data) {
                if($file!=null){unlink($file['gambar']);}
                $status = true;
            } else {
                $status = false;
            }

            echo $status;
        }
        else{
            $this->load->view('bo/index', $data);
        }

    }

    public function lokasi($action=null, $page=1){
        $data = $this->data;
        $function = 'lokasi';
        $view = $this->control.'/';
        if($this->session->userdata($this->site . 'admin_menu')!=$function){
            $this->session->unset_userdata('search');
            $this->session->set_userdata($this->site . 'admin_menu', $function);
        }
        $data['title'] = 'Lokasi';
        $data['page'] = $function;
        $data['content'] = $view.$function;
        $table = $function;
        $where = null;

        if(isset($_POST['search'])||isset($_POST['to_excel'])) {
            $this->session->set_userdata('search', array('any' => $_POST['any']));
        }

        $search = $this->session->search['any'];
        if(isset($search)&&$search!=null) {
            ($where == null) ? null : $where .= " AND ";
            $where .= "nama like '%".$search."%'";
        }

        if($action == 'get_data'){
            $config = array();
            $config["base_url"] = "#";
            //$config["total_rows"] = $this->ajax_pagination_model->count_all();
            $config["total_rows"] = $this->m_crud->count_data($table, "id_lokasi", $where);
            $config["per_page"] = 6;
            $config["uri_segment"] = 4;
            $config["num_links"] = 5;
            $config["use_page_numbers"] = TRUE;
            $config["full_tag_open"] = '<ul class="pagination pagination-sm">';
            $config["full_tag_close"] = '</ul>';
            $config['first_link'] = '&laquo;';
            $config["first_tag_open"] = '<li>';
            $config["first_tag_close"] = '</li>';
            $config['last_link'] = '&raquo;';
            $config["last_tag_open"] = '<li>';
            $config["last_tag_close"] = '</li>';
            $config['next_link'] = '&gt;';
            $config["next_tag_open"] = '<li>';
            $config["next_tag_close"] = '</li>';
            $config["prev_link"] = "&lt;";
            $config["prev_tag_open"] = "<li>";
            $config["prev_tag_close"] = "</li>";
            $config["cur_tag_open"] = "<li class='active'><a href='#'>";
            $config["cur_tag_close"] = "</a></li>";
            $config["num_tag_open"] = "<li>";
            $config["num_tag_close"] = "</li>";
            $this->pagination->initialize($config);
            $start = ($page - 1) * $config["per_page"];

            $output = '';
            $read_data = $this->m_crud->read_data(
                $table.' l', "l.*",
                $where, 'l.id_lokasi desc', null, $config["per_page"], $start);
            $output .= /** @lang text */
                '
                <table class="table table-hover">
                <tr>
                    <th width="1%">No</th>
                    <th width="1%" class="text-center">#</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Gambar</th>
                </tr>
            ';
            $no = $start+1;
            if ($read_data != null) {
                foreach ($read_data as $row) {
                    if($row['gambar']!=null){
                        $gambar = '<img style="max-height:50px;max-width:80px;" src="' . base_url().$row['gambar'] . '" />';
                    }else{
                        $gambar = '<img style="max-height:50px;max-width:80px;" src="' . base_url()."assets/images/no_images.png" . '" />';
                    }

                    $output .= /** @lang text */'
                    <tr>
                        <td>' . $no++ . '</td>
                        <td>
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">Pilihan <span class="fa fa-caret-down"></span></button>
                            <ul class="dropdown-menu dropdown-position">
                                <li><a href="#" onclick="edit(\'' . $row['id_lokasi'] . '\'); validasi(\'edit\');">Edit</a></li>
                                <li><a href="#" onclick="hapus(\'' . $row['id_lokasi'] . '\')">Hapus</a></li>
                            </ul>
                        </div>
                        </td>
                        <td>' . $row['nama'] . '</td>
                        <td>' . $row['tlp1'] . '</td>
                        <td>' . $row['alamat'] . '</td>
                        
                        <td>' . $gambar . '</td>
                    </tr>
                ';
                }
            } else {
                $output .= '<tr><td colspan="6" class="text-center">Tidak ada data</td></tr>';
            }
            $output .= '</table>';

            $result = array(
                'pagination_link' => $this->pagination->create_links(),
                'result_table' => $output
            );
            echo json_encode($result);
        }else if ($action == 'cek_nama') {
            $where = "nama='".$_POST['nama']."'";

            $_POST['param']=='edit'?$where.=" AND nama<>'".$_POST['nama']."'":null;

            $cek_nama = $this->m_crud->get_data($table, "nama", $where);

            if ($cek_nama == null) {
                echo 'true';
            } else {
                echo 'false';
            }
        }
        elseif ($action == 'simpan'){
            $this->db->trans_begin();
            $path = 'assets/images/lokasi';
            $config['upload_path']          = './'.$path;
            $config['allowed_types']        = 'bmp|gif|jpg|jpeg|png';
            $config['max_size']             = 5120;
            $config['encrypt_name'] 	= TRUE;
            $this->load->library('upload', $config);
            $input_file = array('1'=>'file_upload');
            $valid = true;
            foreach($input_file as $row){
                if( (! $this->upload->do_upload($row)) && $_FILES[$row]['name']!=null){
                    $file[$row]['file_name']=null;
                    $file[$row] = $this->upload->data();
                    $valid = false;
                    $data['error_'.$row] = $this->upload->display_errors();
                    break;
                } else{
                    $file[$row] = $this->upload->data();
                    $data[$row] = $file;
                    if($file[$row]['file_name']!=null){
                        $manipulasi['image_library']    = 'gd2';
                        $manipulasi['source_image']     = $file[$row]['full_path'];
                        $manipulasi['maintain_ratio']   = true;
                        $manipulasi['width']            = 500;
                        $this->load->library('image_lib', $manipulasi);
                        $this->image_lib->resize();
                    }
                }
            }
            if($valid==true) {
                $data_berita = array(
                    'nama'  => $_POST['nama'],
                    'tlp1'  => $_POST['tlp'],
                    'alamat'  => $_POST['alamat'],
                    'provinsi'  => $_POST['provinsi'],
                    'kota'  => $_POST['kota']!=""||$_POST['kota']!=null?$_POST['kota']:$_POST['id_kota'],
                    'kecamatan'  => $_POST['kecamatan']!=""||$_POST['kecamatan']!=null?$_POST['kecamatan']:$_POST['id_kecamatan'],
                    'longitude'  => $_POST['lng'],
                    'latitude'  => $_POST['lat'],
                );
                if($_FILES['file_upload']['name']!=null) {
                    $data_berita['gambar'] = ($_FILES['file_upload']['name']!=null)?($path.'/'.$file['file_upload']['file_name']):null;
                    if($_POST['file_uploaded']!=null||$_POST['file_uploaded']!=''){
                        unlink($_POST['file_uploaded']);
                    }
                }

                if ($_POST['param'] == 'add') {
                    $this->m_crud->create_data($table, $data_berita);
                } else {
                    $id = $_POST['id'];
                    $this->m_crud->update_data($table, $data_berita, "id_lokasi='".$id."'");
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo false;
            } else {
                $this->db->trans_commit();
                echo $valid;
            }
        }
        else if ($action == 'edit') {

            $get_data = $this->m_crud->get_join_data(
                "lokasi l","l.*, p.id id_provinsi, p.name nama_provinsi,k.id id_kota, k.name nama_kota, kc.id id_kecamatan,kc.name nama_kecamatan",
                array(array("type"=>"LEFT","table"=>"provinsi p"),array("type"=>"LEFT","table"=>"kota k"),array("type"=>"LEFT","table"=>"kecamatan kc")),
                array("p.id=l.provinsi","k.id=l.kota","kc.id=l.kecamatan"),
                "l.id_lokasi='".$_POST['id']."'"
            );

//            $get_data = $this->m_crud->get_data($table, "*", "id_lokasi='".$_POST['id']."'");
            $result = array();
            if ($get_data != null) {
                $result['status'] = true;
                $result['res_data'] = $get_data;
            } else {
                $result['status'] = false;
            }

            echo json_encode($result);
        }
        else if ($action == 'hapus') {
            $file = $this->m_crud->get_data($table, 'gambar', "id_lokasi = '".$_POST['id']."'");

            $delete_data = $this->m_crud->delete_data($table, "id_lokasi = '".$_POST['id']."'");

            if ($delete_data) {
                if($file!=null){unlink($file['gambar']);}
                $status = true;
            } else {
                $status = false;
            }

            echo $status;
        }
        else{
            $this->load->view('bo/index', $data);
        }

    }


}