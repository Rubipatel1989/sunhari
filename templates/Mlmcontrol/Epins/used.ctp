<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Used Epins
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <form name="epin_list_form" id="epin_list_form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="form-horizontal" enctype="multipart/form-data">
                          
                          <div class="col-xs-12 nopadding table-cotainer margin-top-20">
                            <table id="wallets" class="table table-striped table-hover">
                               <thead>
                                  <tr>
                                      <th>Sr. No.</th>
                                      <th>Created On</th>
                                      <th>Used On</th>
                                      <th>Epin</th>
                                      <th>Assinged To</th>
                                      <th>Remark</th>
                                  </tr>
                               </thead>
                               <tbody>
                                  <?php
                                  if(!empty($epins)){
                                    $i=1;
                                    foreach($epins as $epin){?>
                                      <tr class="gradeX">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo date("F j, Y, g:i a", strtotime($epin->created)); ?></td>
                                        <td>
                                          <?php
                                          $usedOn = 'N/A';
                                          if($epin->modfied != ''){
                                            $usedOn =  date("F j, Y, g:i a", strtotime($epin->modfied)); 
                                          }
                                          echo $usedOn;
                                          ?>
                                        </td>
                                        <td><?php echo $epin->epin; ?></td>
                                        <td style="white-space: nowrap;">
                                          <?php
                                          if(!empty($epin->Users['username'])) {
                                            echo $epin->Users['username'].' ('.$epin->Details['first_name'].' '.$epin->Details['last_name'].')';
                                          }else{
                                            echo 'N/A';
                                          }
                                          ?>
                                        </td>
                                        <td>
                                          <?php 
                                          if(!empty($epin->remark))
                                            echo html_entity_decode($epin->remark); 
                                          else
                                            echo 'N/A';
                                          ?>
                                        </td>
                                      </tr>
                                    <?php
                                      $i++;
                                    }
                                  }?>
                               </tbody>
                            </table>
                          </div>
                        </form>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>