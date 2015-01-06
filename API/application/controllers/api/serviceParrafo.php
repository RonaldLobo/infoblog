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

class ServiceParrafo extends REST_Controller
{
    function user_get()
    {
        $query = "";
        if($this->get('idParrafo'))
        {
            if($this->checkExist($this->get('idParrafo'))){
              $query = "SELECT * FROM tbl_parrafo where Id_parrafo ='".$this->get('idParrafo')."';";
            }
            else{
                $this->response(array('error' => 'El Parrafo no existe'), 404);
            }
        }
        else{
            $query = "SELECT * FROM tbl_parrafo;";
        }

        $queryRes = $this->db->query($query);
        $users = array();
        $user = array();
        if ($queryRes->num_rows() > 0)
        {
            foreach ($queryRes->result() as $row)
            {
               $user['id'] = $row->Id_parrafo; // call attributes ID
               $user['id_contenido'] = $row->Id_contenido; // call attributes Id_contenido
               $user['parrafo'] = $row->parrafo; // call attributes Id_contenido
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
                   'Id_contenido' => $info['data']['id_contenido'],
                   'parrafo' => $info['data']['parrafo']
                );
        switch ($info['data']['action']) {
            case 'add':
                    $query = $this->db->insert('tbl_parrafo', $data); 
                break;
            case 'update':
                if($this->checkExist($info['data']['idParrafo'])){
                    $query = $this->db->update('tbl_parrafo', $data, array('Id_parrafo' => $info['data']['idParrafo'])); 
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
        $query = $this->db->delete('tbl_parrafo', array('Id_parrafo' => $info['data']->idParrafo)); 
        $this->response($query, 200); // 200 being the HTTP response code
    }

    function checkExist($id){
        $query = $this->db->get_where('tbl_parrafo', array('Id_parrafo' => $id));
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