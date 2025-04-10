<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   My Ads
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
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table id="packages" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($links)){
                                  $i=1;
                                  foreach($links as $link){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $link->title; ?></td>
                                      <td><?php echo $link->link; ?></td>
                                      <td><?php echo html_entity_decode($link->remark); ?></td>
                                      <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                             <li>
                                                <a href="<?php echo $home_url; ?>/my-account/ad/view/<?php echo md5($link->id); ?>">view</a> 
                                             </li>
                                          </ul>
                                       </div>
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