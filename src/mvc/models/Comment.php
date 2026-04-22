<?php
class Comment extends Model{

    protected static $fillable = [
        'text',
        'iduser',
        'idplace',
        'idphoto'
    ];

    public function validate(): array{
        $errors = [];

        if(empty(trim($this->text ?? ''))){
            $errors['text'] = "El comentario no puede estar vacío.";
        }

        if(empty($this->idplace) && empty($this->idphoto)){
            $errors['target'] = "El comentario debe estar asociado a un lugar o una foto.";
        }

        return $errors;
    }

    public static function canCreate(){
        return Login::user() != null;
    }

    public function canDelete(){
        $user = Login::user();

        if(!$user){
            return false;
        }

        if($user->oneRole(['ROLE_ADMIN'])){
            return true;
        }

        if($user->id == $this->iduser){
            return true;
        }

        if($this->idplace){
            $place = $this->place();
            return $place && $user->id == $place->iduser;
        }
        if($this->idphoto){
            $photo = $this->photo();

            if(!$photo){
                return false;
            }

            $place = $photo->place();
            return $place && $user->id == $place->iduser;
        }

        return false;
    }
    public function place(){
        return $this->belongsTo('Place', 'idplace');
    }

    public function photo(){
        return $this->belongsTo('Photo', 'idphoto');
    }

    public function author(){
        return $this->belongsTo('User', 'iduser');
    }
}