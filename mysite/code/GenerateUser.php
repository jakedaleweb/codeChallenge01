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
        //if there is a response
        if($results_decoded){
           //make life easier
            $results = $results_decoded->results['0']->user;
            //call addMember
            echo $this->addMember($results);
        } else {
            echo 'unfortunately the user generator is not working at this time, please try again later or contact support.';
        }
        
    }
    //function to add member to DB
    public function addMember($results){
        //set up new member
        $member = new Member();
        $member->FirstName      = Convert::raw2sql($results->name->first);
        $member->Surname        = Convert::raw2sql($results->name->last);
        $member->Email          = Convert::raw2sql($results->email);
        $member->Gender         = Convert::raw2sql($results->gender);
        //set address string
        $Address                = $results->location->street.', '.$results->location->city.', '.$results->location->state;
        $member->Address        = Convert::raw2sql($Address);
        $member->Username       = Convert::raw2sql($results->username);
        $member->Phone          = Convert::raw2sql($results->phone);
        $member->Cell           = Convert::raw2sql($results->cell);
        $member->ProfilePic     = Convert::raw2sql($results->picture->thumbnail);
        $member->changePassword($results->password);
        $member->write();
        return $this->success($results);
    }
    //display success message
    public function success($results){
        $message = '<p>Thank you, your user, '.ucfirst($results->name->first).', has been created</p>';
        $message.= '<img src="'.$results->picture->medium.'" alt="This is a picture of '.ucfirst($results->name->first).'">';
        return $message;
    }
}