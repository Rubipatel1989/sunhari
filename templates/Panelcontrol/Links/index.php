<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Links
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            <div class="col-xs-12 nopadding text-right action-container">
               <a href="<?php echo $backend_url ?>/links/add"><i class="fa fa-plus"></i> Add Link</a>
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
                                    <th>Link</th>
                                    <th>Remark</th>
                                    <th>Status</th>
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
                                        <?php
                                        
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Inactive';
                                        if($link->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Active';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                             <li><a href="<?php echo $backend_url; ?>/links/edit/<?php echo $link->id; ?>">Edit</a> 
                                             </li>
                                             <li><a href="<?php echo $backend_url; ?>/links/update_status/<?php echo $link->id; ?>/1">Active</a>
                                             </li>
                                             <li><a href="<?php echo $backend_url; ?>/links/update_status/<?php echo $link->id; ?>/0">Inactive</a>
                                             </li>
                                             <li><a onclick="return confirm('Delete operation will the data permanently from database. Are you sure?');" href="<?php echo $backend_url; ?>/links/delete/<?php echo $link->id; ?>">Delete</a>
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