<?php
/**
 * Created by PhpStorm.
 * User: annashrul yusuf
 * Date: 06/08/2019
 * Time: 15:11
 */

class Api extends CI_Controller{
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        header('Content-Type: application/json');
        $this->output->set_header("Cache-Control: no-store, no-cache, max-age=0, post-check=0, pre-check=0");

    }


    public function register(){
        echo $this->generateRandomString();
    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return base64_encode($randomString);
    }

    public function get_kategori(){
        $response=array();
        $read_data = $this->m_crud->read_data("kategori_berita","*");
        if($read_data != null){
            $response['status']  = true;
            $response['result']  = $read_data;
        }else{
            $response['status']  = false;
            $response['result']  = $read_data;
            $response['message'] = "Berita Tidak Ada";
        }
        echo json_encode($response);
    }

    public function get_edisi($page=1){
        $start = ($page - 1) * 10;
        $response=array();
        $where=null;
        if($this->input->post('tahun')&&$this->input->post('tahun')!=null){
            ($where == null) ? null : $where .= " AND ";
            $where.="YEAR(tanggal)='".$this->input->post('tahun')."'";
        }else{
            ($where == null) ? null : $where .= " AND ";
            $where.="YEAR(tanggal)=YEAR(CURDATE())";
        }
        if($this->input->post('bulan')&&$this->input->post('bulan')!=null){
            ($where == null) ? null : $where .= " AND ";
            $where.="MONTH(tanggal)='".$this->input->post('bulan')."'";
        }else{
            ($where == null) ? null : $where .= " AND ";
            $where.="MONTH(tanggal)=MONTH(CURDATE())";
        }

        $read_data = $this->m_crud->read_data("edisi","*",$where,null,null,10, $start);
        $read_search = $this->m_crud->read_data("edisi","YEAR(tanggal) tahun, MONTH(tanggal) bulan",null,null,"tahun,bulan");
        if($read_data != null){
            $response['status']     = true;
            $response['total_rows'] = count($read_data);
            $response['per_page']   = $page;

            foreach($read_data as $row){
                $response['result'][]  = array(
                    'id_edisi'  => $row['id_edisi'],
                    'nama'      => $row['nama'],
                    'slug'      => $row['slug'],
                    'gambar'    => base_url().$row['gambar'],
                    'tanggal'   => longdate_indo($row['tanggal'])
                );
            }

            foreach($read_search as $val){
                $response['search'] = array(
                    "tahun" => $val['tahun'],
                    "bulan" => $val['bulan'],
                    "nama"  => $this->bulan($val['bulan'])
                );
            }

        }else{
            $response['result']  = $read_data;
            $response['message'] = "Edisi Tidak Ada";
            $response['status']  = false;
        }
        echo json_encode($response,JSON_PRETTY_PRINT);
    }

    public function get_berita($page=1){
        $start = ($page - 1) * 10;
        $where = null;
        if($this->input->post('judul')&&$this->input->post('judul')!=null){
            $where.="b.judul like '%".$this->input->post('judul')."%'";
        }

        $response=array();
        $read_data = $this->m_crud->join_data(
            "berita b","b.*,e.nama nama_edisi,kb.nama nama_kategori",
            array(array("type"=>"LEFT","table"=>"edisi e"),array("type"=>"LEFT","table"=>"kategori_berita kb")),
            array("e.id_edisi=b.id_edisi","kb.id_kategori_berita=b.id_kategori_berita"),
            $where,"b.tgl_insert desc",null, 10, $start
        );
        if($read_data!=null){
            $response['status']     = true;
            $response['total_rows'] = count($read_data);
            $response['per_page']   = $page;
            foreach($read_data as $row){
                $response['result']=array(
                    "id_berita"     => $row['id_berita'],
                    "id_kategori"   => $row['id_kategori_berita'],
                    "id_edisi"      => $row['id_edisi'],
                    "user_id"       => $row['user_id'],
                    "judul"         => $row['judul'],
                    "slug"          => $row['slug'],
                    "ringkasan"     => $row['ringkasan'],
                    "isi"           => $row['isi'],
                    "gambar"        => base_url().$row['gambar'],
                    "seo"           => $row['tag'],
                    "tanggal"       => longdate_indo($row['tanggal']),
                    "url"           => base_url().$row['slug']
                );
            }
        }else{
            $response['result']  = $read_data;
            $response['message'] = "Berita Tidak Ada";
            $response['status']  = false;
        }

        echo json_encode($response,JSON_PRETTY_PRINT);
    }




    public function bulan($bulan){
        $result = "";
        if($bulan=='1' || $bulan=='01'){
            $result.="Januari";
        }elseif($bulan=='2' || $bulan=='02'){
            $result.="Februari";
        }elseif($bulan=='3' || $bulan=='03'){
            $result.="Maret";
        }elseif($bulan=='4' || $bulan=='04'){
            $result.="April";
        }elseif($bulan=='5' || $bulan=='05'){
            $result.="Mei";
        }elseif($bulan=='6' || $bulan=='06'){
            $result.="Juni";
        }elseif($bulan=='7' || $bulan=='07'){
            $result.="Juli";
        }elseif($bulan=='8' || $bulan=='08'){
            $result.="Agustus";
        }elseif($bulan=='9' || $bulan=='09'){
            $result.="September";
        }elseif($bulan=='10'){
            $result.="Oktober";
        }elseif($bulan=='11'){
            $result.="November";
        }else{
            $result.="Desember";
        }
        return $result;
    }



	public function get_nearby_kantor($lat=null,$long=null){
		if(!isset($lat)||!isset($long)){
			echo 'access denied.';
			die();
		}

		//api key distancematrix
		$API_KEY = "AIzaSyA1uxab8JTufkfuXgCX8ULSIhhSPJs-WC0";
		$response = array();
		// prgpg
		// $lat=-6.8063322,107.5742086;
		// btm
		// -6.9115057,107.642177
		$sql = $this->db->query("SELECT *, (6371 * 2 * ASIN(SQRT( POWER(SIN(( $lat - latitude) *  pi()/180 / 2), 2) +COS( $lat * pi()/180) * COS(latitude * pi()/180) * POWER(SIN(( $long - longitude) * pi()/180 / 2), 2) ))) as distance  from lokasi having  distance <= 10 order by distance;")->result_array();


		if(count($sql)==0){
			$response=array(
				'result'=>array(),
				'message'=>"Tidak ada lokasi terdekat.",
				'status'=>false
			);
		}else{
			$qs='';
			foreach($sql as $k=>$i){
				$qs.=$i['latitude']."%2C".$i['longitude']."%7C";
			}
			$res = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$lat,$long&destinations=$qs&key=$API_KEY");
			$data = json_decode($res);
			if($data->status!='OK'){
				$el=null;
			}else{
				$el=$data->rows[0]->elements;
			}
			$hasil=array();
			foreach($sql as $k=>$i){
				array_push($hasil,array(
					'id_lokasi'=> $i['id_lokasi'],
					'nama'=> $i['nama'],
					'longitude'=>$i['longitude'],
					'latitude'=> $i['latitude'],
					'alamat'=>$i['alamat'],
					'provinsi'=>$i['provinsi'],
					'kota'=>$i['kota'],
					'kecamatan'=>$i['kecamatan'],
					'tlp1'=>$i['tlp1'],
					'tlp2'=>$i['tlp2'],
					'gambar'=>base_url().$i['gambar'],
					'jarak'=>isset($el[$k]->distance->text)?$el[$k]->distance->text:null,
					'waktu'=>isset($el[$k]->duration->text)?$el[$k]->duration->text:null,
				));
			}

			$response=array(
				'result'=>$hasil,
				'message'=>"success.",
				'status'=>true
			);

		}
		echo json_encode($response,JSON_PRETTY_PRINT);

	}

}
