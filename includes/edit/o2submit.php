<?
	$timestamp = date("Ymdhis");
	$send_email = 'michaelsouellette@gmail.com';  // Email to send message to
	$errors  = array(); // array of errors
	$sendname = "The Wine Map";
	$your_email = 'winemap@michaelsouellette.com';
	$link = 'http://www.michaelsouellette.com/apps/winemakingtalk/confirmdelete.php?id='.$userid.'&d='.$timestamp;
		
	// Check for a message:
	if (empty($_POST['delete'])) {
		$errors[] = 'You forgot to enter your reason for deletion.';
	} else {
		$message = $_POST['delete'];
	}
		
		if (sizeof($errors) > 0) {
			  // if errors, send the error message
		  echo'<div id="container">
				<fieldset> 
				<legend>Error</legend> 
				<dl>
				There was an error with your submission!  Please correct the following:<br />';
				foreach ($errors as $msg) { // Print each error.
				echo " - $msg<br />\n";
			}
				echo '</p><p>Please try again.</p><br />
				</dl>
				</fieldset></div>';
		} else {
			$query2 = "INSERT INTO delete_flag (mapid, timestamp, message, type, deleted) VALUES ('$userid', '$timestamp', '$message','$type', 'n')";
			$result2 = mysql_query($query2);
			if (!$result2) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query2;
				die($message);
			}		
			
			$time = date('r');
			$body = 'Hi!
		
			A message was sent to you from '.$sendname.' on '.$time.'
			
			The folling entry was flagged to be deleted:
			
			ID: '.$userid.'
			Name: '.$name.'
			Address: '.$address.'
			City: '.$city.'
			State: '.$state.'
			Country: '.$country.'
			Phone: '.$phone.'
			Website: '.$website.'
			Type: '.$type.'
			Reason: '.$message.'
			
			Link to delete: '.$link;
			
			// send email
			mail($send_email, "Wine Map Flag For Deletion", $body, "From: $your_email\r\nReply-To: $send_email\r\nContent-Type: text/plain; charset=ISO-8859-1\r\nMIME-Version: 1.0");
			echo'This item has been flagged for deletion and may take some time before it disappears from the map.<br />'; // send success indicator
		}
?>