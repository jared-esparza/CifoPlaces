<?php
#[\AllowDynamicProperties]
class Photo extends Model{
    protected static $fillable = [
        "name",
        "file",
        "alt",
        "description",
        "date",
        "time",
        "iduser",
        "idplace"
    ];

    public function validate(): array{
        $errores = [];

        if(empty(trim($this->name ?? ''))){
            $errores['name'] = "El nombre de la foto es obligatorio.";
        }

        if(empty(trim($this->alt ?? ''))){
            $errores['alt'] = "El texto alternativo es obligatorio.";
        }

        if(empty($this->idplace)){
            $errores['idplace'] = "La foto debe pertenecer a un lugar.";
        }

        return $errores;
    }
    public static function canCreate(){
        $user = Login::user();
        return $user && $user->oneRole(['ROLE_USER', 'ROLE_ADMIN']);
    }
    public function canEdit(){
        $user = Login::user();

        return $user
            && (
                $user->oneRole(['ROLE_ADMIN'])
                || $user->id == $this->iduser
            );
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

        $place = Place::find($this->idplace);
        return $place && $user->id == $place->iduser;
    }
    public function place(){
        return $this->belongsTo('Place', 'idplace');
    }

    public function author(){
        return $this->belongsTo('User', 'iduser');
    }
    public function comments(){
        return $this->hasMany('V_Comment', 'idphoto');
    }
}