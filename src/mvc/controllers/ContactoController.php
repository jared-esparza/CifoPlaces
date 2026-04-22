<?php
class ContactoController extends Controller{

    public function index(){
        return view('contacto');
    }

    public function send(){
        if (empty(request()->post('enviar'))){
            throw new FormException("No se recibió el formulario de contacto");
        }

        $from = request()->post('email');
        $name = request()->post('nombre');
        $subject = request()->post('asunto');
        $message = request()->post('mensaje');

        try{
            $email = new Email(ADMIN_EMAIL, $from, $name, $subject, $message);
            $email->send();

            Session::success("Mensaje enviado, en breves recibiras respuesta");
            return redirect('/');
        } catch (EmailException $e){
            Session::error("No s eha podido enviar el mensaje.");
            if(DEBUG){
                throw new Exception($e->getMessage());
            }
            return redirect('/Contacto');
        }
    }
}