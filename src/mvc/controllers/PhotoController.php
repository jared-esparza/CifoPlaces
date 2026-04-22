<?php

class PhotoController extends Controller{

    public function show(int $id = 0){
        $photo = Photo::findOrFail($id, "No existe la foto.");
        $place = $photo->place();
        $comments = $photo->comments();

        return view('photo/show', [
            'photo' => $photo,
            'place' => $place,
            'comments' => $comments
        ]);
    }

    public function create(int $idplace = 0){
        if(!Photo::canCreate()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        $place = Place::findOrFail($idplace, "No existe el lugar.");

        return view('photo/create', [
            'place' => $place
        ]);
    }

    public function store(){
        if(!Photo::canCreate()){
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
            $data['file'] = "--";


            $photo = Photo::create($data);
            $file = request()->file(
                'file',
                8000000,
                ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
            );

            if($file){
                $photo->file = $file->store('../public/'.PHOTO_IMAGE_FOLDER, 'photo_');
                $photo->update();
            }

            Session::success("Guardado de la foto $photo->name correcto.");
            return redirect("/Photo/show/$photo->id");

        }catch(SQLException $e){
            Session::error("No se pudo guardar la foto.");
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/Photo/create/".request()->post('idplace'));

        }catch(UploadException $e){
            Session::warning("La foto se guardó pero la imagen no se subió correctamente.");
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/Photo/edit/$photo->id");

        }catch(ValidationException $e){
            Session::error($e->getMessage());
            return redirect("/Photo/create/".request()->post('idplace'));
        }
    }

    public function edit(int $id = 0){
        $photo = Photo::findOrFail($id, "No existe la foto.");

        if(!$photo->canEdit()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        $place = $photo->place();
        $comments = $photo->comments();

        return view('photo/edit', [
            'photo' => $photo,
            'place' => $place,
            'comments' => $comments
        ]);
    }

    public function update(){
        if(!request()->has('actualizar')){
            throw new FormException("No se recibieron datos");
        }

        $id = intval(request()->post('id'));
        $photo = Photo::findOrFail($id, "No existe la foto.");

        if(!$photo->canEdit()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        $tmp = $photo->file;

        try{
            Photo::create(request()->posts(), $id);
            $photo = Photo::findOrFail($id, "No existe la foto.");

            $file = request()->file(
                'file',
                8000000,
                ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
            );

            if($file){
                if($tmp && $tmp != DEFAULT_PHOTO_IMAGE){
                    File::remove('../public/'.PHOTO_IMAGE_FOLDER.$tmp);
                }

                $photo->file = $file->store('../public/'.PHOTO_IMAGE_FOLDER, 'photo_');
                $photo->update();
            }

            Session::success("Actualización de la foto $photo->name correcta.");
            return redirect("/Photo/edit/$photo->id");

        }catch(SQLException $e){
            Session::error("No se pudo actualizar la foto $photo->name.");
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/Photo/edit/$id");

        }catch(UploadException $e){
            Session::warning("Los datos se actualizaron, pero la imagen no se subió correctamente.");
            if(DEBUG){
                throw new UploadException($e->getMessage());
            }
            return redirect("/Photo/edit/$id");

        }catch(ValidationException $e){
            Session::error($e->getMessage());
            return redirect("/Photo/edit/$id");
        }
    }

    public function delete(int $id = 0){
        $photo = Photo::findOrFail($id, "No existe la foto.");

        if(!$photo->canDelete()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        return view('photo/delete', [
            'photo' => $photo,
            'place' => $photo->place()
        ]);
    }

    public function destroy(){
        if(!request()->has("borrar")){
            throw new FormException("No se recibieron datos");
        }

        $id = intval(request()->post("id"));
        $photo = Photo::findOrFail($id, "No existe la foto.");

        if(!$photo->canDelete()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        $tmp = $photo->file;
        $idplace = $photo->idplace;
        $name = $photo->name;

        try{
            $photo->deleteObject();

            if($tmp && $tmp != DEFAULT_PHOTO_IMAGE){
                File::remove('../public/'.PHOTO_IMAGE_FOLDER.$tmp, true);
            }

            Session::success("Se ha borrado la foto $name.");
            return redirect("/Place/show/$idplace");

        }catch(SQLException $e){
            Session::error("No se pudo borrar la foto $name.");
            if(DEBUG){
                throw new SQLException($e->getMessage());
            }
            return redirect("/Photo/delete/$id");
        }
    }
}