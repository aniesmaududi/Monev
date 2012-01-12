<?php echo form_open(base_url()."sms/tokenverification");?>

<?php
$code = rand(123456, 987654);
?>

CODE :  <?php echo $tokencode;?>
<input type="hidden" name="tokencode" value="<?php echo $tokencode;?>">
<br>
Verification Code : <input type="text" name="vercode" value="">
<input type="submit" name="send" value="Verify">		
<br>
kirim sms ke nomor : 08XXXX991828 <br>
dengan format : TOKEN&lt;spasi&gt;CODE<br>
contoh : <strong>TOKEN 918299</strong>
<?php echo form_close();?>