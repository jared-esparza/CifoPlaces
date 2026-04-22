<?php
class Comment extends Model{
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