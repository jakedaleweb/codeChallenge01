<?php

class GenerateUserPage extends Page {
	//resrict acions to generate member function
    public static $allowed_actions = array(
        'GenerateMember',
    );

    public function GenerateMember(){
        //make API call store results
        $results = $this->GetMemberFromAPI();
        //if there are results
        if($results){
            //make life easier
            $results = $results->results['0']->user;
            //die($this->AddMember($results));
            return $this->AddMember($results);
        } else {
            //failure ):
            return '<p>Unfortunately the user generator is not working at this time, please try again later or contact support.</p>';
        }
    }

    //make API call to get member info
    public function GetMemberFromAPI(){
        //make connection
        $expiry = 1;
        $fetch = new RestfulService('https://randomuser.me/api/?lego', $expiry);
        //make request
        $results = $fetch->request();
        //decode request        
        $results_decoded = json_decode($results->getBody());
        //if there is a response
        return $results_decoded;
    }

    //function to add member to DB
    public function AddMember($results){
        //set up new member
        $member = new Member();
        $member->FirstName      = Convert::raw2sql(ucfirst($results->name->first));
        $member->Surname        = Convert::raw2sql(ucfirst($results->name->last));
        $member->Email          = Convert::raw2sql($results->email);
        $member->Gender         = Convert::raw2sql($results->gender);
        $member->Address        = Convert::raw2sql($this->GetAddress($results));
        $member->Username       = Convert::raw2sql($results->username);
        $member->Phone          = Convert::raw2sql($results->phone);
        $member->Cell           = Convert::raw2sql($results->cell);
        $member->ProfilePic     = Convert::raw2sql($results->picture->thumbnail);
        $member->changePassword($results->password);
        $member->write();
        return $this->Success($results);
    }

    public function GetAddress($results){
        $address = $results->location->street.', '.$results->location->city.', '.$results->location->state;
        return $address;
    }

    //display success message
    public function Success($results){
        $message = '<p>Thank you, your user, '.ucfirst($results->name->first).', has been created</p>';
        $message.= '<img src="'.$results->picture->large.'" alt="This is a picture of '.ucfirst($results->name->first).'">';
        return $message;
    }
}

class GenerateUserPage_Controller extends Page_Controller {
	public function MemberData() {
		return $this->owner->GenerateMember();
	}
}