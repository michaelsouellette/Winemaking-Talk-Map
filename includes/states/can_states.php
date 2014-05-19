<?php
function convert_canstate($name, $to='abbrev') {
	$states = array(
	array('name'=>'Alberta', 'abbrev'=>'AB'),
	array('name'=>'British Columbia', 'abbrev'=>'BC'),
	array('name'=>'Manitoba', 'abbrev'=>'MB'),
	array('name'=>'New Brunswick', 'abbrev'=>'NB'),
	array('name'=>'Newfoundland and Labrador', 'abbrev'=>'NL'),
	array('name'=>'Northwest Territories', 'abbrev'=>'NT'),
	array('name'=>'Nova Scotia', 'abbrev'=>'NS'),
	array('name'=>'Nunavut', 'abbrev'=>'NU'),
	array('name'=>'Ontario', 'abbrev'=>'ON'),
	array('name'=>'Prince Edward Island', 'abbrev'=>'PE'),
	array('name'=>'Quebec', 'abbrev'=>'QC'),
	array('name'=>'Saskatchewan', 'abbrev'=>'SK'),
	array('name'=>'Yukon Territory', 'abbrev'=>'YT')
	);

	$return = false;
	
	foreach ($states as $state) {
	foreach ($state as $title=>$value) {
		if (strtolower($value) == strtolower(trim($name))) {
			if ($to == 'name') {
				$return = $state['name'];
			} else {
				$return = $state['abbrev'];
			}
			break;
		}
	}
}
	return $return;
}
?>