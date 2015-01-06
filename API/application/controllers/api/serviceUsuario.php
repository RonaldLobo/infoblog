<?php 

require APPPATH.'/libraries/REST_Controller.php';

class ServiceUsuario extends REST_Controller
{
    function user_get()
    {
        $query = "";
        if($this->get('idUsuario'))
        {
            if($this->checkExist($this->get('idUsuario'))){
              $query = "SELECT * FROM tbl_usuario where Id_usuario ='".$this->get('idUsuario')."';";
            }
            else{
                $this->response(array('error' => 'El usuario no existe'), 404);
            }
        }
        else{
            $query = "SELECT * FROM tbl_usuario;";
        }

        $queryRes = $this->db->query($query);
        $users = array();
        $user = array();
        if ($queryRes->num_rows() > 0)
        {
            foreach ($queryRes->result() as $row)
            {
               $user['id'] = $row->Id_usuario; // call attributes ID
               $user['password'] = $row->password; // call attributes Password
               $user['tipo'] = $row->tipo; // call attributes tipo
               array_push($users,$user);
            } 
        }
        
        if($users)
        {
            $this->response($users, 200); // 200 being the HTTP response code
        }

        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }
    }
    
    function user_post()
    {
        $query = "";
        $info = json_decode(file_get_contents('php://input'), true);
        $data = array(
                   'Id_usuario' => $info['data']->['idUsuario'],
                   'password' => $info['data']->['password'],
                   'tipo' => $info['data']->['tipo']
                );
        switch ($info['data']->['action']) {
            case 'add':
                if(!$this->checkExist($info['idUsuario'])){
                    $query = $this->db->insert('tbl_usuario', $data); 
                }
                else{
                    $query = "error ya existe";
                }
                break;
            case 'update':
                if($this->checkExist($info['data']['idUsuario'])){
                    $query = $this->db->update('tbl_usuario', $data, array('Id_Usuario' => $data['Id_Usuario'])); 
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
        $query = $this->db->delete('tbl_usuario', array('Id_usuario' => $info['data']->idUsuario)); 
        $this->response($query, 200); // 200 being the HTTP response code
    }

    function checkExist($id){
        $query = $this->db->get_where('tbl_usuario', array('Id_usuario' => $id));
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