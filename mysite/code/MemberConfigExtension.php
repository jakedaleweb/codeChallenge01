<?php
class MemberConfigExtension extends DataExtension {
	private static $db = array(
		'Gender' 	=> 'Enum(array("Male", "Female"))',
		'Address' 	=> 'Varchar(255)',
		'Username'	=> 'Varchar(50)',
		'Phone'		=> 'Varchar(20)',
		'Cell'		=> 'Varchar(20)',
		'ProfilePic'=> 'Varchar(255)',
	);
	public function updateCMSFields(FieldList $fields) {
		$fields->addFieldToTab(
			'Root.Main',
			TextField::create('Gender', 'Gender')
		);
		$fields->addFieldToTab(
			'Root.Main',
			TextField::create('Address', 'Address')
		);
		$fields->addFieldToTab(
			'Root.Main',
			TextField::create('Username', 'Username')
		);
		$fields->addFieldToTab(
			'Root.Main',
			TextField::create('Phone', 'Home Phone')
		);
		$fields->addFieldToTab(
			'Root.Main',
			TextField::create('Cell', 'Mobile')
		);
		$fields->addFieldToTab(
			'Root.Main',
			TextField::create('ProfilePic', 'Profile Picture')
		);
	}
}