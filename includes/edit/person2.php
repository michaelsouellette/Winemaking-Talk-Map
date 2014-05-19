<?php
echo '	<div id="container">
			<form action="#" method="post" class="niceform" name="weboptions" id="weboptions">
			<fieldset>
			<legend><h1>', $name ,'</h1></legend>
			<label for="option">What would you like to do?</label>
			<select name="option">
			<option value="o1">Edit Details
			<option value="o2">Flag for Deletion
			</select>
			</fieldset>
			<fieldset> 
    	<legend>Edit Entry</legend> 
		'; include ('../includes/edit/delete.php');
		include ('../includes/edit/changetype.php'); echo'
		<dl>
			<dt><label for="full_name">Name:<input type="hidden" class="DEPENDS ON option BEING o1"></label></dt>
			<dd><input class="DEPENDS ON option BEING o1" type="text" name="full_name" id="full_name" value="',$name,'" size="32" maxlength="60" /></dd>
		</dl>
		<dl>
			<dt><label for="forum_un">Username:<input type="hidden" class="DEPENDS ON option BEING o1"></label></dt>
			<dd><input class="DEPENDS ON option BEING o1" type="text" name="forum_un" id="forum_un" value=',$username,' size="30" /></dd>
		</dl>
		<dl>
			<dt><label for="street_add">Street Address:<input type="hidden" class="DEPENDS ON option BEING o1"></label></dt>
			<dd><input class="DEPENDS ON option BEING o1" type="text" name="street_add" id="street_add" value="',$address,'" size="32" maxlength="80" /></dd>
		</dl>
		<dl>
			<dt><label for="city">City:<input type="hidden" class="DEPENDS ON option BEING o1"></label></dt>
			<dd><input class="DEPENDS ON option BEING o1" type="text" name="city" id="city" value="',$city,'" size="32" maxlength="40" /></dd>
		</dl>
		<dl>
			<dt><label for="state">State/Territory:<input type="hidden" class="DEPENDS ON option BEING o1"></label></dt>
			<dd><input class="DEPENDS ON option BEING o1" type="text" name="state" id="state" value="',$state,'" size="32" maxlength="12" /></dd>
		</dl>
		<dl>
			<dt><label for="zip">Zip:<input type="hidden" class="DEPENDS ON option BEING o1"></label></dt>
			<dd><input class="DEPENDS ON option BEING o1" type="text" name="zip" id="zip" size="32" maxlength="10" value="',$zip,'"/></dd>        
		</dl>
		<dl>
			<dt><label for="country">Country:<input type="hidden" class="DEPENDS ON option BEING o1"></label><dt>
			<dd><select class="DEPENDS ON option BEING o1" name="country" id="country" size="1"> 
			'; include ('country_drop_down.php'); echo'
			</select></dd>  
		</dl>
		<dl>
            <dt><label for="email">Email:<input type="hidden" class="DEPENDS ON option BEING o1"></label></dt>
			<dd><input class="DEPENDS ON option BEING o1" type="text" name="email" id="email" value="',$email,'" size="50" /></dd>
		</dl>
		</fieldset>
	<fieldset class="action"> 
    	<input type="submit" name="editsubmit" id="submit" value=" Submit " /> 
    </fieldset> ';
?>