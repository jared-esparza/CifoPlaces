<?php
#[\AllowDynamicProperties]
class Place extends Model{

    protected static $fillable = [
        'name',
        'type',
        'location',
        'description',
        'mainpicture',
        'iduser',
        'latitude',
        'longitude'
    ];

    public function validate(): array{
        $errores = [];

        if(empty(trim($this->name ?? ''))){
            $errores['name'] = "El nombre es obligatorio.";
        }

        if(empty(trim($this->type ?? ''))){
            $errores['type'] = "El tipo es obligatorio.";
        }

        if(empty(trim($this->location ?? ''))){
            $errores['location'] = "La localización es obligatoria.";
        }

        if(!empty($this->latitude) && !is_numeric($this->latitude)){
            $errores['latitude'] = "La latitud debe ser numérica.";
        }

        if(!empty($this->longitude) && !is_numeric($this->longitude)){
            $errores['longitude'] = "La longitud debe ser numérica.";
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

        return $user
            && (
                $user->oneRole(['ROLE_ADMIN'])
                || $user->id == $this->iduser
            );
    }

    public function author(){
        return $this->belongsTo('User', 'iduser');
    }

    public function photos(){
        return $this->hasMany('Photo', 'idplace');
    }

    public function pictures(){
        return $this->hasMany('V_Picture', 'idplace');
    }

    public function comments(){
        return $this->hasMany('V_Comment', 'idplace');
    }
}