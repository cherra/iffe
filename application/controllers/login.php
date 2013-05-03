<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

        public $layout = 'template_frontend';

	/*
	* Muestra en pantalla el login del sistema
	*/
	public function index( $msg = '' ) {
            $data['msg'] = $msg;
            $this->load->view('login', $data);
	}
        
    public function process(){
        $this->load->model('login_model');
        $result = $this->login_model->validate(); // Validamos que el usuario puede logearse
        
        // Verificamos el resultado de la validacion
        if(! $result){
            // Si el usuario no es valido, lo regresamos al login
            $msg = 'Usuario o contraseña inválidos.';
            $this->index($msg);
        }else{
            
            $this->load->model('menu');
            // Se obtienen las carpetas dentro "controllers"
            $folders = $this->menu->getFolders();
            // Se registran las carpetas en la sesión del usuario
            // De ésta forma el menú superior solo se carga una vez al momento de logearse.
            $this->session->set_userdata('folders',$folders);
            // Si el usuario valida, lo redireccionamos al home
            redirect('home');
        }       
    }
    
    // Método para destruir la sesión del usuario
    public function do_logout(){
        $this->session->sess_destroy();
        redirect('login'); // Inmediatamente después lo redireccionamos al login
    }

}

?>