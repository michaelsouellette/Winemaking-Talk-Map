<?php
echo '	
			<dl>
			<dt><label for="full_name">Store Name:<input type="hidden" class="DEPENDS ON option BEING o1"></label></dt>
			<dd><input class="DEPENDS ON option BEING o1" type="text" name="full_name" id="full_name" value="',$name,'" size="32" maxlength="60" /></dd>
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
			<dt><label for="phone">Phone Number:<input type="hidden" class="DEPENDS ON option BEING o1"></label></dt>
			<dd><input class="DEPENDS ON option BEING o1" type="text" name="phone" id="phone" value="',$phone,'" size="32" maxlength="15" /></dd> 
		</dl>
		<dl>
			<dt><label for="website">Website:<input type="hidden" class="DEPENDS ON option BEING o1"></label></dt>
			<dd><input class="DEPENDS ON option BEING o1" type="text" name="website" id="website" size="32" maxlength="50" value="', $website,'" /></dd>
		</dl>
		</fieldset>
	<fieldset class="action"> 
    	<input type="submit" name="editsubmit" id="submit" value=" Submit " /> 
    </fieldset> ';
?>