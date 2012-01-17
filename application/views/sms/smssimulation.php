<?php echo form_open(base_url()."sms/responder");?>

<?php

?>


<textarea name="smsconfirm"><?php echo $vercode;?></textarea>
<input type="hidden" name="phonenumber" value="<?php echo $phoneNumber;?>">
<br>
<input type="submit" name="send" value="SEND">	

<?php echo form_close();?>