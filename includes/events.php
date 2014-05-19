<div class="popup_close"><a href="#" onclick="close_popup('markerContainer')"><img src="/images/close.png"></a></div>
<div id="markerContent">
    <!-- Event Form -->
    <form action="#" method="post" class="niceform">
    <fieldset>
        <legend><img src="http://labs.google.com/ridefinder/images/mm_20_blue.png" width="12" height="20" title="Event Markers" alt="Winery Marker" /> New Event</legend>
        * Required Field<br />
        <dl>
        	<dt><label for="full_name">Event Name: *</label></dt>
            <dd><input type="text" name="full_name" id="full_name" value="" size="32" /></dd>
        </dl>
        <dl>
        	<dt><label for="forum_un">Forum Username: *</label></dt>
            <dd><input type="text" name="forum_un" id="forum_un" size="32" /></dd>
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
        	<dt><label for="startevent">Event Start Date & Time: *</label></dt>
            <dd><input name="startevent" id="startevent" type="text" size="32"></dd>
        </dl>
        <dl>
        	<dt><label for="endevent">Event End Date & Time: *</label></dt>
            <dd><input name="endevent" id="endevent" type="text" size="32"></dd>
		</dl>
        <dl>
        	<dt><label for="website">Event Website:</label></dt>
            <dd><input type="text" name="website" id="website" size="32" value="http://www." /></dd>
        </dl>
    </fieldset>
    <fieldset class="action">                    
    <input type="button" name="eventsubmit" value=" Add Event " class="bt_register" onclick='return formValidator("events")' />
    </fieldset>
    </form>            
	<script type="text/javascript">
    $('#startevent').focus( function() {
    $('#startevent').unbind('focus').AnyTime_picker( 
          { format: "%z/%m/%d %h:%i %p" } ); } );
    $('#endevent').focus( function() {
    $('#endevent').unbind('focus').AnyTime_picker( 
          { format: "%z/%m/%d %h:%i %p" } ); } );
    </script>
</div>