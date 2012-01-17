<h1>Unggah Berkas</h1>
<div id="upload-box">
        <?php
        if ($this->session->flashdata('message')):
            echo flash_message($this->session->flashdata('message_type'));
        endif;
        ?>

        <?php echo form_open_multipart('/satker/upload') ?>
        <p>Pilih Berkas dengan ukuran maksimum 100 MB
        <input type="file" name="file"></p>
        
        <div class="clearfix"></div>
        
</div>
<div id="upload2-box">
	<input type="submit" value="unggah berkas" class="custom"/>
        </form>
</div>