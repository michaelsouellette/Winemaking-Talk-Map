<?php
echo '<dl>
			<label for="delete">Marker currently set as: <b>',$type,'</b><input type="hidden" class="DEPENDS ON option BEING o3"><br></label>
			<label for="delete">What would you like to change it to?<input type="hidden" class="DEPENDS ON option BEING o3"><br></label>
            <label><input class="DEPENDS ON option BEING o3" type="radio" name="typegroup" value="winery"'; if ($type == "winery") {echo ' checked="checked"';} echo'> Winery<input type="hidden" class="DEPENDS ON option BEING o3"><br></label>
			<label><input class="DEPENDS ON option BEING o3" type="radio" name="typegroup" value="homebrew"'; if ($type == "homebrew") {echo ' checked="checked"';} echo'> Homebrew Store<input type="hidden" class="DEPENDS ON option BEING o3"><br></label>
			<label><input class="DEPENDS ON option BEING o3" type="radio" name="typegroup" value="event"'; if ($type == "event") {echo ' checked="checked"';} echo'> Event<input type="hidden" class="DEPENDS ON option BEING o3"><br></label>
			<label><input class="DEPENDS ON option BEING o3" type="radio" name="typegroup" value="person"'; if ($type == "person") {echo ' checked="checked"';} echo'> Person<input type="hidden" class="DEPENDS ON option BEING o3"><br></label>
		</dl>	
' ?>