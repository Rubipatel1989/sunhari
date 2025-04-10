
<script type="text/javascript">

$(document).ready(function(){
  $("#select_username").change(function(){
    var _this = this;
    var username = $(_this).val();
    if(username != ''){
      var url = '<?php echo $home_url; ?>/my-account/team/my-network/'+username;
    }else{
      var url = '<?php echo $home_url; ?>/my-account/team/my-network';
    }
    jQuery(".body-loader").show();
    location.href = url;
  });
      
 });
</script>