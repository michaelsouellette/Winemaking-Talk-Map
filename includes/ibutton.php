<!-- Panel -->
<div id="toppanel">
	<div id="ipanel">
		<div class="content clearfix">
			<div class="left">
				<h1>WineMakingTalk.com Locations iButton</h1><br />
                <p class="grey"><a href="includes/privacypolicy.php" rel="clearbox[height=500,,width=600]" title="View the map's privacy policy">Privacy Policy</a></p>                  
				<p class="grey"><i>This application developed by <a href="http://www.michaelsouellette.com">Michael S. Ouellette</a></p>
			</div>
			<div class="left">
				<!-- Problem/Concern Form -->
                <form id="contact_form" action="#" method="post" onSubmit="return processForm()">
					<h1>Report Problem/Suggestion</h1>               
                  <label class="grey" for="sender_name">Your name:</label>
                  <input class="field" type="text" name="sender_name" id="sender_name" value="" size="40" />                
                  <label class="grey" for="email">Email:</label>
                  <input class="field" type="text" name="sender_email" id="sender_email" value="" size="40" / >                
                  <label class="grey" for="message">Message:</label>
                  <textarea class="field" name="message" id="message" rows="4" style="background-color:#414141; color:#FFF; border: 1px #1A1A1A solid; margin-right: 5px; margin-top: 4px;	width: 200px;"></textarea>                                  
                  <label class="grey" for="captcha">Security Image:</label>
                  <img src="securimage/securimage_show.php" alt="CAPTCHA Image" height="50px" width="100px"/>                
                  <label class="grey" for="code">Security Code:</label>
                  <input class="field" type="text" name="code" id="code" value="" size="8" />                                  
                  <input id="submit"  name="problemsubmit" type="submit" value="Send" class="bt_register"/>                  
                </form>
                                
	    </div>
    	<div class="left right">
        	<h1>Site updates and versions</h1>
            <ul>
            <li>Version 3.0</li>
            <li>Version 2.0 - Ability to add nurseries to the map, ability to remember previous location from previous visits, tabbed info windows, and update to the bottom navigation bar including pop up add marker menu.</li>
            <li>Version 1.3.2 - Added site updates and versions to i button.</li>
            <li>Version 1.3.1 - Added small change to marker posting to fix reposting problem.</li>
            <li>Version 1.3 - Added map stats page.</li>
            <li>Version 1.2.1 - Small updates to allow better viewing on Firefox.</li>
            <li>Version 1.2 - Added ability to turn markers on and off.</li>
            <li>Version 1.1 - Added "i", or information, button with contact form.</li>           
            </ul>
        </div>
		</div>
</div>