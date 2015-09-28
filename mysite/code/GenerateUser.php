<?php

class GenerateUser extends Controller {

    public function index(){
        //make connection
        $expiry = 1;
        $fetch = new RestfulService('https://randomuser.me/api/', $expiry);
        //make request
        $results = $fetch->request();
        //decode request        
        $results_decoded = json_decode($results->getBody());
        //make life easier
        $results = $results_decoded->results['0']->user;
        //set up new member
        $member = new Member();
        $member->FirstName      = Convert::raw2sql($results->name->first);
        $member->Surname        = Convert::raw2sql($results->name->last);
        $member->Email          = Convert::raw2sql($results->email);
        $member->changePassword($results->password);
        $member->write();
        //thanks
        echo 'Thank you, your user, '.$results->name->first.', has been created';
    }
}