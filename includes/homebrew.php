<div class="popup_close"><a href="#" onclick="close_popup('markerContainer')"><img src="/images/close.png"></a></div>
<div id="markerContent">
    <!-- Homebrew Store Form -->
    <form action="#" method="post" class="niceform">
    <fieldset>
        <legend><img src="http://labs.google.com/ridefinder/images/mm_20_yellow.png" width="12" height="20" title="Homebrew Store Markers" alt="Winery Marker" /> New Homebrew Store</legend>
        * Required Field<br />
        <dl>
        	<dt><label for="full_name">Homebrew Store Name: *</label></dt>
        	<dd><input type="text" name="full_name" id="full_name" value="" size="32" /></dd>
        </dl>
        <dl>
        	<dt><label for="street_add">Street Address: *</label></dt>
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
        	<dt><label for="phone">Homebrew Store Phone Number: *</label></dt>
        	<dd><input type="text" name="phone" id="phone" size="32" /></dd>
        </dl>
        <dl>
        	<dt><label for="website">Homebrew Store Website:</label></dt>
        	<dd><input type="text" name="website" id="website" size="32" value="http://www." /></dd>
        </dl>    
    </fieldset>
    <fieldset class="action">                    
    <input type="button" name="homebrewsubmit" value=" Add Homebrew Store " class="bt_register" onclick='return formValidator("homebrew")' />
    </fieldset>
    </form>
</div>