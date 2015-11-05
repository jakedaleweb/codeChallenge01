<?php 

class GenerateUserTest extends SapphireTest {

	//test output of controller
	public function testGenerateMember(){
		//instantiate GenerateUser class
		$GenerateUser = new GenerateUser();
		//run GenerateMember task
		$successMessage = $GenerateUser->GenerateMember();
		$this->assertContains('<p>Thank you, your user,' , $successMessage);
	}

	//test function which manages the API call
	public function testGetMemberFromAPI(){
		//instantiate GenerateUser class
		$GenerateUser = new GenerateUser();
		//make API call
		$results_decoded = $GenerateUser->GetMemberFromAPI();
		//make life easier
		$results = $results_decoded->results['0']->user;
		//there should be results
		$this->assertTrue(gettype($results->name->first) == 'string' );
		$this->assertTrue(gettype($results->name->last) == 'string' );
		$this->assertTrue(gettype($results->email) == 'string' );
		$this->assertTrue(gettype($GenerateUser->GetAddress($results)) == 'string' && strlen($GenerateUser->GetAddress($results) > 8 ));
		$this->assertTrue(gettype($results->username) == 'string' );
		$phone = intval($results->phone, 10);
		$this->assertTrue(gettype($phone) == 'integer' );
		$this->assertTrue(strlen($results->cell) >= 10);
		$this->assertContains('https://randomuser.me/api/portraits/thumb', $results->picture->thumbnail);
		$this->assertTrue(gettype($results->password) == 'string' );
	}
}