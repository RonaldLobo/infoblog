<?php 

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package     CodeIgniter
 * @subpackage  Rest Server
 * @category    Controller
 * @author      Phil Sturgeon
 * @link        http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class ServiceImagen extends REST_Controller
{
    function user_get()
    {
        $query = "";
        if($this->get('idImagen'))
        {
            if($this->checkExist($this->get('idImagen'))){
              $query = "SELECT * FROM tbl_imagen where Id_imagen ='".$this->get('idImagen')."';";
            }
            else{
                $this->response(array('error' => 'La imagen no existe'), 404);
            }
        }
        else{
            $query = "SELECT * FROM tbl_imagen;";
        }

        $queryRes = $this->db->query($query);
        $users = array();
        $user = array();
        if ($queryRes->num_rows() > 0)
        {
            foreach ($queryRes->result() as $row)
            {
               $user['id'] = $row->Id_imagen; // call attributes ID
               $user['id_contenido'] = $row->Id_contenido; // call attributes Id_contenido
               $user['url'] = $row->url; // call attributes url
               $user['alt_text'] = $row->alt_text; // call attributes Id_contenido
               $user['tipo'] = $row->tipo; // call attributes Id_contenido
               array_push($users,$user);
            } 
        }
        
        if($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'Equipo could not be found'), 404);
        }
    }
    
    function user_post()
    {
        $query = "";
        $info = json_decode(file_get_contents('php://input'), true);
        $data = array(
                   'Id_contenido' => $info['data']['idContenido'],
                   'url' => $info['data']['url'],
                   'alt_text' => $info['data']['alt_text'],
                   'tipo' => $info['data']['tipo']
                );
        switch ($info['data']['action']) {
            case 'add':
                    $query = $this->db->insert('tbl_imagen', $data); 
                break;
            case 'update':
                if($this->checkExist($info['data']['idImagen'])){
                    $query = $this->db->update('tbl_imagen', $data, array('Id_imagen' => $info['data']['idImagen'])); 
                }
                else{
                    $query = "error no existe";
                }
                break;
            
            default:
                # code...
                break;
        }
        
        $this->response($query, 200); // 200 being the HTTP response code
    }
    
    function user_delete()
    {
        $query = "";
        $info['data'] = $this->post('info');
        $query = $this->db->delete('tbl_imagen', array('Id_imagen' => $info['data']->idImagen)); 
        $this->response($query, 200); // 200 being the HTTP response code
    }

    function checkExist($id){
        $query = $this->db->get_where('tbl_imagen', array('Id_imagen' => $id));
        if($query->num_rows()>0)
            return true;
        return false;
    }
    

    public function send_post()
    {
        dump($this->request->body);
    }


    public function send_put()
    {
        dump($this->put('foo'));
    }
}