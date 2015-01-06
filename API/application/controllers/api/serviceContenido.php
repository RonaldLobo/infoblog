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

class ServiceContenido extends REST_Controller
{
    function user_get()
    {
        $query = "";
        if($this->get('idContenido'))
        {
            if($this->checkExist($this->get('idContenido'))){
              $query = "SELECT * FROM tbl_contenido where Id_contenido ='".$this->get('idContenido')."';";
            }
            else{
                $this->response(array('error' => 'El contenido no existe'), 404);
            }
        }
        else{
            $query = "SELECT * FROM tbl_contenido;";
        }

        $queryRes = $this->db->query($query);
        $users = array();
        $user = array();
        if ($queryRes->num_rows() > 0)
        {
            foreach ($queryRes->result() as $row)
            {
               $user['id'] = $row->Id_contenido; // call attributes ID
               $user['titulo'] = $row->titulo; // call attributes Id_contenido
               $user['fecha_ingreso'] = $row->fecha_ingreso; // call attributes url
               $user['idUsuario'] = $row->Id_Usuario; // call attributes Id_contenido
               $user['meta'] = $row->meta; // call attributes Id_contenido
               $user['descripcion'] = $row->descripcion; // call attributes Id_contenido
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
                   'titulo' => $info['data']['titulo'],
                   'fecha_ingreso' => $info['data']['fecha_ingreso'],
                   'Id_Usuario' => $info['data']['idUsuario'],
                   'meta' => $info['data']['meta'],
                   'descripcion' => $info['data']['descripcion']
                );
        switch ($info['data']['action']) {
            case 'add':
                    $query = $this->db->insert('tbl_contenido', $data); 
                break;
            case 'update':
                if($this->checkExist($info['data']['idContenido'])){
                    $query = $this->db->update('tbl_contenido', $data, array('Id_contenido' => $info['data']['idContenido'])); 
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
        $query = $this->db->delete('tbl_contenido', array('Id_contenido' => $info['data']->idContenido)); 
        $this->response($query, 200); // 200 being the HTTP response code
    }

    function checkExist($id){
        $query = $this->db->get_where('tbl_contenido', array('Id_contenido' => $id));
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