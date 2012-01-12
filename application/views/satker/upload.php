<h1>Upload Data Satker</h1>
<div id="search-box" style="min-height:400px;">
    <p style="font-size:1.3em;font-weight:normal;">

        <?php
        if ($this->session->flashdata('message')):
            echo flash_message($this->session->flashdata('message_type'));
        endif;
        ?>

        <?php echo form_open_multipart('/satker/upload') ?>
        <input type="file" name="file">
        <input type="submit" value="upload"/>
        </form>
        Ukuran file maksimum 100 MB
    </p>
</div>
<div id="nav-box">


</div>