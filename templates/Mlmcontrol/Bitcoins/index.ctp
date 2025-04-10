<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   BTC Address
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $backend_url ?>/bitcoins/add"><i class="fa fa-plus"></i> Add BTC Address</a>
            </div>
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="packages" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Title</th>
                                    <th>Address</th>
                                    <th>Remark</th>
                                    <th>Status</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($bitcoins)){
                                  $i=1;
                                  foreach($bitcoins as $bitcoin){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $bitcoin->title; ?></td>
                                      <td><?php echo $bitcoin->address; ?></td>
                                      <td><?php echo html_entity_decode($bitcoin->remark); ?></td>
                                      <td>
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($bitcoin->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                    </tr>
                                  <?php
                                    $i++;
                                  }
                                }?>
                             </tbody>
                          </table>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>