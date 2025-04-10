<input type="hidden" name="page" id="page" value="1">
<input type="hidden" name="srno" id="srno" value="<?php echo ($limit + 1);?>>">
<input type="hidden" name="limit" id="limit" value="<?php echo $limit;?>">

<script type="text/javascript">
    $(document).ready(function(){
      $("#loadMoreRow").click(function(){
        var backendUrl = '<?php echo $backend_url;?>';
        var page = parseInt($("#page").val()) + 1;
        var srno = parseInt($("#srno").val());
        var limit = parseInt($("#limit").val());
        jQuery(".body-loader").show();
        jQuery.ajax({
            type: "GET",
            url: backendUrl+"/users/index/1/"+page+"/"+srno,
            dataType: 'text',  
            cache: false,
            contentType: false,
            processData: false,
            data: {},
            success: function(responseText){
              var table = $('#dt-basic-example').DataTable();
               table.rows.add(JSON.parse(responseText));
                table .draw();
                $("#page").val(page);
                $("#srno").val(srno + limit);
                jQuery(".body-loader").hide(); 
            }
        });
      });
    });
</script>