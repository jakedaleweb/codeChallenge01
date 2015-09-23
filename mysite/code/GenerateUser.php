<?php

class GenerateUser extends Controller {

    private static $allowed_actions = array(
        'index',
        'init'
    );

    public function init(){
    	parent::init();
    	echo '<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script><script src="/themes/simple/javascript/ajax.js"></script>';
    }

    public function index() {
        if(isset($_GET['firstName'])){
            $member = new Member();
            $member->FirstName      = Convert::raw2sql($_GET['firstName']);
            $member->Surname        = Convert::raw2sql($_GET['lastName']);
            $member->Email          = Convert::raw2sql($_GET['email']);
            $member->changePassword(Convert::raw2sql($_GET['pass']));
            $member->write();
    }
}