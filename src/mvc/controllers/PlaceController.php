<?php
class PlaceController extends Controller{

    public function index(){
        return $this->list();
    }

    public function list(int $page = 1){
        $filtro = Filter::apply('places');
        $total = $filtro ? V_Place::filteredResults($filtro) : V_Place::total();
        $limit = RESULTS_PER_PAGE;
        $paginator = new Paginator('/Place/list', $page, $limit, $total);

        $places = $filtro
            ? V_Place::filter($filtro, $limit, $paginator->getOffset())
            : V_Place::orderBy('created_at', 'DESC', $limit, $paginator->getOffset());

        return view('place/list', [
            'places' => $places,
            'paginator' => $paginator,
            'filtro' => $filtro
        ]);
    }

    public function show(int $id = 0){
        $place = Place::findOrFail($id, "No se encontró el lugar.");

        $photos = $place->photos();
        $comments = $place->comments();
        // $comments = array_filter(
        //     $place->comments(),
        //     fn($comment) => empty($comment->idphoto)
        // );

        return view('place/show', [
            'place' => $place,
            'photos' => $photos,
            'comments' => $comments
        ]);
    }

    public function create(){
        if(!Place::canCreate()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        return view('place/create');
    }

    public function store(){
        if(!Place::canCreate()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        if(!request()->has('guardar')){
            throw new FormException("No se recibió el formulario");
        }

        try{
            $data = request()->posts();
            $user = Login::user();
            $data['iduser'] = $user->id;

            $place = Place::create($data);
            $file = request()->file('mainpicture', 8000000, ['image/png', 'image/jpeg', 'image/gif', 'image/webp']);
            if($file){
                $place->mainpicture = $file->store('../public/'.PLACE_IMAGE_FOLDER, 'place_');
                $place->update();
            }

            Session::success("Guardado del lugar $place->name correcto.");
            return redirect("/Place/show/$place->id");

        }catch(SQLException $e){
            $mensaje = "No se pudo guardar el lugar.";

            Session::error($mensaje);
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/Place/create");

        }catch(UploadException $e){
            Session::warning("El lugar se guardó pero la imagen principal no se subió correctamente.");
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/Place/edit/$place->id");

        }catch(ValidationException $e){
            Session::error($e->getMessage());
            return redirect("/Place/create");
        }
    }

    public function edit(int $id = 0){
        $place = Place::findOrFail($id, "No se encontró el lugar.");

        // if(!$place->canEdit()){
        //     Session::error("No puedes realizar esta operación.");
        //     return redirect('/');
        // }

        $pictures = $place->pictures();
        $comments = $place->comments();

        return view('place/edit', [
            'place' => $place,
            'pictures' => $pictures,
            'comments' => $comments
        ]);
    }

    public function update(){
        if(!request()->has('actualizar')){
            throw new FormException("No se recibieron datos.");
        }

        $id = intval(request()->post('id'));
        $place = Place::findOrFail($id, "No se encontró el lugar.");

        if(!$place->canEdit()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        try{
            Place::create(request()->posts(), $id);
            $place = Place::findOrFail($id, "No se encontró el lugar.");

           $file = request()->file(
                'mainpicture',
                8000000,
                ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
            );

            if($file){

                if($place->mainpicture && $place->mainpicture != DEFAULT_PLACE_IMAGE){
                    File::remove('../public/'.PLACE_IMAGE_FOLDER.$place->mainpicture);
                }

                $place->mainpicture = $file->store('../public/'.PLACE_IMAGE_FOLDER, 'place_');
                $place->update();
            }

            Session::success("Actualización del lugar $place->name correcta.");
            return redirect("/Place/edit/$id");

        }catch(SQLException $e){
            Session::error("No se pudo actualizar el lugar $place->name.");
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/Place/edit/$id");

        }catch(UploadException $e){
            Session::warning("Cambios guardados pero no se guardó la imagen principal.");
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/Place/edit/$id");

        }catch(ValidationException $e){
            Session::error($e->getMessage());
            return redirect("/Place/edit/$id");
        }
    }

    public function delete(int $id = 0){
        $place = Place::findOrFail($id, "No existe el lugar.");

        if(!$place->canDelete()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        return view('place/delete', ['place' => $place]);
    }

    public function destroy(){
        if(!request()->has("borrar")){
            throw new FormException("No se recibieron datos");
        }

        $id = intval(request()->post("id"));
        $place = Place::findOrFail($id, "No existe el lugar.");

        if(!$place->canDelete()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        $tmp = $place->mainpicture;

        try{
            $place->deleteObject();

            if($tmp && $tmp != DEFAULT_PLACE_IMAGE){
                File::remove('../public/'.PLACE_IMAGE_FOLDER.$tmp, true);
            }

            Session::success("Se ha borrado el lugar $place->name.");
            return redirect("/Place/list");

        }catch(SQLException $e){
            Session::error("No se pudo borrar el lugar $place->name.");
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/Place/delete/$id");
        }
    }
}