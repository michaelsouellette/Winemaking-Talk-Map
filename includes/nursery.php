<!-- Panel -->
<div id="toppanel">
	<div id="nurserypanel">
		<div class="content clearfix">
			<div class="left">
				<h1>WineMakingTalk.com Locations</h1>
				<h2></h2>		
				<p class="grey">This application will allow for users of <a href="http://www.winemakingtalk.com">WineMakingTalk.com</a> to their favorite nurseries and discover other nurseries around the globe. Add your favorite nursery location now to allow others to discover new locations!</p>
				<h2></h2>
				<p class="grey"><i>This application developed by <a href="http://www.michaelsouellette.com">Michael S. Ouellette</a></p>
			</div>
			<div class="left">
				<!-- Homebrew Store Form -->
<form action="#" method="post">
					<h1>New Nursery</h1>
                    * Required Field<br />
					<label class="grey" for="full_name">Nursery Name: *</label>
					<input class="field" type="text" name="full_name" id="full_name" value="" size="60" />
                    <label class="grey" for="forum_un">Forum Username: *</label>
					<input class="field" type="text" name="forum_un" id="forum_un" size="30" />
                    <label class="grey" for="street_add">Street Address: *</label>
					<input class="field" type="text" name="street_add" id="street_add" size="80" />
                    <label class="grey" for="city">City: *</label>
					<input class="field" type="text" name="city" id="city" size="40" />
					<label class="grey" for="state">State/Territory: *(for US and Canada)</label>
					<input class="field" type="text" name="state" id="state" value="" size="12" />
        			<div class="clear"></div>
			</div>
			<div class="left right">
                    <label class="grey" for="zip">Zip: *</label>
					<input class="field" type="text" name="zip" id="zip" size="10" />            
					<label class="grey" for="country">Country: *</label>
					<select class="field" name="country" id="country"> 
						<? include ('dropdowns/country.php') ?>
					</select>             
					<label class="grey" for="phone">Nursery Phone Number: *</label>
					<input class="field" type="text" name="phone" id="phone" size="15" /> 
                    <label class="grey" for="website">Nursery Website:</label>
					<input class="field" type="text" name="website" id="website" size="50" value="http://www." />
                    <label class="grey" for="produce">Produce Available:</label>
					<textarea class="field" name="produce" id="produce" rows="4" style="background-color:#414141; color:#FFF; border: 1px #1A1A1A solid; margin-right: 5px; margin-top: 4px;	width: 200px;"></textarea>
<input type="submit" name="nurserysubmit" value="Add Nursery" class="bt_register" />
				</form>
				
    </div>
		</div>
</div>