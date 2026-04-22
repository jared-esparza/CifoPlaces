<?php

class CommentController extends Controller{

    public function store(){

        if(!Comment::canCreate()){
            Session::error("Debes identificarte para comentar.");
            return redirect('/');
        }

        if(!request()->has('guardar')){
            throw new FormException("No se recibieron datos.");
        }

        try{
            $data = request()->posts();
            $user = Login::user();

            $data['iduser'] = $user->id;

            if(!empty($data['idplace'])){
                $data['idphoto'] = null;
            }else{
                $data['idplace'] = null;
            }

            $comment = Comment::create($data);

            Session::success("Comentario añadido correctamente.");

            if($comment->idplace){
                return redirect("/Place/show/$comment->idplace");
            }

            if($comment->idphoto){
                return redirect("/Photo/show/$comment->idphoto");
            }

            return redirect('/');

        }catch(ValidationException $e){
            Session::error($e->getMessage());

            $idplace = request()->post('idplace');
            $idphoto = request()->post('idphoto');

            if($idplace){
                return redirect("/Place/show/$idplace");
            }

            if($idphoto){
                return redirect("/Photo/show/$idphoto");
            }

            return redirect('/');

        }catch(SQLException $e){
            Session::error("No se pudo guardar el comentario.");

            if(DEBUG){
                throw new SQLException($e->getMessage());
            }

            $idplace = request()->post('idplace');
            $idphoto = request()->post('idphoto');

            if($idplace){
                return redirect("/Place/show/$idplace");
            }

            if($idphoto){
                return redirect("/Photo/show/$idphoto");
            }

            return redirect('/');
        }
    }

    public function delete(int $id = 0){

        $comment = Comment::findOrFail($id, "No existe el comentario.");

        if(!$comment->canDelete()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        $place = $comment->place();
        $photo = $comment->photo();
        $author = $comment->author();

        return view('comment/delete', [
            'comment' => $comment,
            'place'   => $place,
            'photo'   => $photo,
            'author'  => $author
        ]);
    }

    public function destroy(){

        if(!request()->has("borrar")){
            throw new FormException("No se recibieron datos");
        }

        $id = intval(request()->post("id"));
        $comment = Comment::findOrFail($id, "No existe el comentario.");

        if(!$comment->canDelete()){
            Session::error("No puedes realizar esta operación.");
            return redirect('/');
        }

        $place = $comment->place();
        $photo = $comment->photo();

        try{
            $comment->deleteObject();

            Session::success("Comentario eliminado correctamente.");

            if($place){
                return redirect("/Place/show/$place->id");
            }

            if($photo){
                return redirect("/Photo/show/$photo->id");
            }

            return redirect('/');

        }catch(SQLException $e){
            Session::error("No se pudo borrar el comentario.");

            if(DEBUG){
                throw new SQLException($e->getMessage());
            }

            if($place){
                return redirect("/Place/show/$place->id");
            }

            if($photo){
                return redirect("/Photo/show/$photo->id");
            }

            return redirect('/');
        }
    }
}