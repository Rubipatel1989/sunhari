<script type="text/javascript">
  function removeAttachment(_this, attachmentID){
    if(confirm("Delete operation will delete data permanently from database. Are you sure?")){
      jQuery(".body-loader").show();

      jQuery.ajax({
        type: "GET",
        url: "<?php echo $home_url; ?>/ajax/remove_attachment/"+attachmentID,
        data: { },
        success: function( responseText ) {
          jQuery(_this).parent(".col-xs-12").parent(".attchment-inner-container").parent(".attchment-container").remove();
          jQuery(".body-loader").hide();
        }
      });
    }
  }
</script>