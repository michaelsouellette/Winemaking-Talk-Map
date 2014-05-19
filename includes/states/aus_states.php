<?php
function convert_ausstate($name, $to='abbrev') {
	$states = array(
	array('name'=>'Australian Capital Territory', 'abbrev'=>'ACT'),
	array('name'=>'Jervis Bay Territory', 'abbrev'=>'JBT'),
	array('name'=>'New South Wales', 'abbrev'=>'NSW'),
	array('name'=>'Northern Territory', 'abbrev'=>'NT'),
	array('name'=>'Queensland', 'abbrev'=>'QLD'),
	array('name'=>'South Australia', 'abbrev'=>'SA'),
	array('name'=>'Tasmania', 'abbrev'=>'TAS'),
	array('name'=>'Victoria', 'abbrev'=>'VIC'),
	array('name'=>'Western Australia', 'abbrev'=>'WA')
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