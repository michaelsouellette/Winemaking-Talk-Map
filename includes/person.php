<div class="popup_close"><a href="#" onclick="close_popup('markerContainer')"><img src="/images/close.png"></a></div>
<div id="markerContent">
    <!-- Person Form -->
    <form action="#" method="post" class="niceform">
    <fieldset>
        <legend><img src="http://labs.google.com/ridefinder/images/mm_20_red.png" width="12" height="20" title="Forum Members Markers" alt="Winery Marker" /> New Forum Member</legend>
        * Required Field<br />
        <dl>
        	<dt><label for="full_name">Name:</label></dt>
            <dd><input type="text" name="full_name" id="full_name" value="" size="32" /></dd>
        </dl>
        <dl>
			<dt><label for="forum_un">Forum Username: *</label></dt>
            <dd><input type="text" name="forum_un" id="forum_un" size="32" /></dd>
        </dl>
        <dl>
        	<dt><label for="street_add">Street Address:</label></dt>
            <dd><input type="text" name="street_add" id="street_add" size="32" /></dd>
        </dl>
        <dl>
        	<dt><label for="city">City: *</label></dt>
            <dd><input type="text" name="city" id="city" size="32" /></dd>
        </dl>
		<dl>
        	<dt><label for="state">State/Territory(US, CA, & AU): *</label></dt>
            <dd><input type="text" name="state" id="state" value="" size="32" /></dd>
        </dl>
        <dl>
        	<dt><label for="zip">Zip: *</label></dt>
            <dd><input type="text" name="zip" id="zip" size="32" /></dd>
        </dl>
        <dl>
        	<dt><label for="country">Country: *</label></dt>
            <dd><select name="country" id="country"><? include ('dropdowns/country.php') ?></select></dd>
        </dl>
        <dl>
        	<dt><label for="email">Email:</label></dt>
            <dd><input type="text" name="email" id="email" size="32" /></dd>
        </dl>
    </fieldset>
    <fieldset class="action">                    
    <input type="button" name="personsubmit" value=" Add Forum Member " class="bt_register" onclick='return formValidator("person")' />
    </fieldset>
    </form>
</div>