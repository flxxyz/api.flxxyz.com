<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use App\models\User;

class Api extends CI_Controller {
    protected $user;

    public function index ()
    {
        $user = User::all(['*'])->where([
            'token = ' => session_id(),
        ])->get();
        var_dump(session_id(), $user);
        //echo message('200', 'success', '', $user);
    }
}