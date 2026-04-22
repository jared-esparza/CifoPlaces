<?php

class UserController extends Controller{

    public function index(){
        Auth::admin();
        return $this->list();
    }

    public function list(int $page = 1){
        Auth::admin();
        $filtro = Filter::apply('users');
        $total = $filtro ? User::filteredResults($filtro): User::total();
        $limit = RESULTS_PER_PAGE;
        $paginator = new Paginator('/User/list', $page, $limit, $total);

        $users = $filtro ? User::filter($filtro, $limit, $paginator->getOffset()): User::orderBy('displayname', 'DESC', $limit, $paginator->getOffset());

        return view('user/list', ['users'=>$users, 'paginator'=>$paginator, 'filtro'=>$filtro]);
    }

    public function show(int $id = 0){
        Auth::admin();
        $user = User::findOrFail($id);
        return view('user/show', ['user'=>$user]);
    }

    public function create(){
        return view('user/create');
    }

    public function store(){
        if(!request()->has('guardar')){
            throw new FormException("No se recibió el formulario");
        }
        try{
            $user = User::create(request()->posts());

            $user->addRole('ROLE_USER');
            $user->password = md5($user->password);
            $file = request()->file('picture', 8000000, ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);
            if($file){
                $user->picture = $file->store('../public/' . USER_IMAGE_FOLDER, 'user_');
            }
            $user->update();
            Session::success("Guardado del user $user->displayname correcto.");
            return redirect("/user/show/$user->id");
        }catch(Exception $e){
            echo $e->getMessage();
        }
        catch(SQLException $e){
            $mensaje = "No se pudo guardar el user $user->displayname.";

            Session::error($mensaje);
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/user/create");
        }catch(UploadException $e){
            Session::warning('El user se guardó pero la imagen no se ha subido correctamente.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/User/edit/$user->id");
        }catch(ValidationException $e){
            Session::error($e->getMessage());
            return redirect("/User/create");
        }
    }

    public function edit(int $id = 0){
        $user = User::findOrFail($id, "No se encontró el user");
        if(Login::user()->id != $user->id && !Login::isAdmin()){
            Auth::admin();
        }
        return view('user/edit', ['user'=>$user]);
    }
    public function update(){
        $id = intval(request()->post('id'));
        $user = User::findOrFail($id, "No se encontró el user");
        if(Login::user()->id != $user->id && !Login::isAdmin()){
            Auth::admin();
        }
        if(!request()->has('actualizar')){
            throw new FormException("No se recibieron datos.");
        }
        try{
            $user = User::create(request()->posts(), $id);
            $user = User::findOrFail($id, 'No se ha encontrado el user');
            $file = request()->file('picture', 8000000, ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);
            if($file){
                if($user->picture){
                    File::remove('../public/' . USER_IMAGE_FOLDER . '/' . $user->picture);
                }
                $user->picture = $file->store('../public/'.USER_IMAGE_FOLDER, 'user_');
                $user->update();
            }
            Session::success("Actualización del user $user->displayname correcta.");
            return redirect("/user/edit/$id");
        }catch(SQLException $e){
            $mensaje = "No se pudo actualizar el user $user->displayname.";

            Session::error($mensaje);
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/user/edit/$id");
        }catch(UploadException $e){
            Session::warning('Cambios guardados pero no se gaurdó la imagen.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/User/edit/$id");
        }catch(ValidationException $e){
            Session::error($e->getMessage());
            return redirect("/user/edit/$id");
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function dropcover(){
        Auth::admin();
        if(!request()->has("borrar")){
            throw new FormException("No se ha recibido el formulario.");
        }
        $id = request()->post("id");
        $user = User::findOrFail($id, "No se ha encontrado el user.");

        $tmp = $user->picture;
        $user->picture = NULL;

        try{
            $user->update();
            File::remove('../public/' . USER_IMAGE_FOLDER . '/' . $tmp, true);
            Session::success("Borrado de la imagen de user $user->displayname correcta.");
            return redirect("/user/edit/$id");
        }catch(FileException $e){
            Session::warning('No se pudo eliminar la imagen.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/User/edit/$user->id");
        }
    }

    public function delete(int $id = 0){
        Auth::admin();
        $user = User::findOrFail($id, "No existe el user");
        return view("user/delete", ["user"=>$user]);
    }

    public function destroy(){
        Auth::admin();
        if(!request()->has("borrar")){
            throw new FormException("No se recibieron datos");
        }
        $id = intval(request()->post("id"));
        $user = User::findOrFail($id);
        try{
            $user->deleteObject();
             if($user->picture){
                File::remove('../public/' . USER_IMAGE_FOLDER . '/' . $user->picture);
            }
            Session::success("Se ha borrado el user $user->displayname.");
            return redirect("/user/list");
        }catch(SQLException $e){
            Session::error("No se pudo borrar el user $user->displayname.");
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/user/delete/$id");
        }catch(FileException $e){
            Session::warning('No se pudo eliminar la imagen.');
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/User");
        }

    }

    public function block(int $id){
        Auth::admin();
        $user = User::findOrFail($id);
        $user->addRole('ROLE_BLOCKED');
        $user->update();
        return redirect("/User");
   }
     public function unblock(int $id){
        Auth::admin();
        $user = User::findOrFail($id);
        $user->removeRole('ROLE_BLOCKED');
        $user->update();
        return redirect("/User");

   }

    public function home(){
        Auth::user();

        $user = Login::user();

        $places = $user->places();
        $photos = $user->photos();
        $comments = $user->comments();

        return view('user/home', [
            'user' => $user,
            'places' => $places,
            'photos' => $photos,
            'comments' => $comments
        ]);
    }
}