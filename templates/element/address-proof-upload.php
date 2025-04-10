
  <form name="ajax-upload-form" id="ajax-upload-form" action="<?php echo $home_url; ?>/ajax/upload_file" method="post" enctype="multipart/form-data" class="hidden">
    <?php echo $this->Form->input('attachment_file', array('type' => 'file', 'div' => false, 'label' => false, 'class'=>'address_proof_upload')); ?>
  </form>
<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery(".address-proof").click(function(){
      jQuery(".address_proof_upload").click();
    });
    jQuery(".address_proof_upload").change(function(){
      var _this = this;
      jQuery(".body-loader").show();
      var fileExtension = ['jpeg', 'jpg', 'png', 'gif'];
      if (jQuery.inArray(jQuery(_this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          alert("Only "+fileExtension.join(', ') + " file is allowed.");
          jQuery(_this).val('');
          jQuery(".body-loader").hide();
          return false;
      }
      var file_size = (jQuery(_this)[0].files[0].size)/(1024*1024);
      if(file_size > 2){
        alert("File size should be upto 2 MB.");
        jQuery(_this).val('');
        jQuery(".body-loader").hide(); 
        return false;
      }
      var file_data = jQuery(_this).prop('files')[0]; 
      var form_data = new FormData();                  
      form_data.append('file', file_data);
      jQuery.ajax({
        type: "POST",
        url: "<?php echo $home_url; ?>/ajax/address_proof_upload",
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function(responseText){
          //alert(responseText);
          if(responseText == 0){
            alert("Please upload only jpeg|jpg|png|gif files.");
            jQuery(_this).val('');
          }
          else if(responseText == 3){
            alert("File size should be upto 2 MB.");
            jQuery(_this).val('');
          }
          else{
            jQuery('.address-proof-container').html(responseText);
            jQuery(_this).val('');
          }
          jQuery(".body-loader").hide();
        }
      });

    });
  });
</script>