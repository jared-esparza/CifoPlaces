<?php

class UserController extends Controller{

    public function index(){
        return $this->home();
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