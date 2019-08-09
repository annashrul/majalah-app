<?php
/**
 * Created by PhpStorm.
 * User: annashrul yusuf
 * Date: 08/08/2019
 * Time: 8:17
 */

class Ajax extends CI_Controller
{
    public function get_edisi(){
        $response=array();
        $read_data = $this->m_crud->read_data("edisi","*");
        if($read_data != null){
            $response['status']  = true;
            $response['result']  = $read_data;
        }else{
            $response['status']  = false;
            $response['result']  = $read_data;
        }
        echo json_encode($response);
    }
}