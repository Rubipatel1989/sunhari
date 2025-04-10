<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   Tickets
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
                          <table id="wallets" class="table table-striped table-hover">
                             <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Date</th>
                                    <th>Ticket Id</th>
                                    <th>Ticket By</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                if(!empty($tickets)){
                                  $i=1;
                                  foreach($tickets as $ticket){?>
                                    <tr class="gradeX">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo date("F j, Y, g:i a", strtotime($ticket->created)); ?></td>
                                      <td><?php echo $ticket->ticket_id; ?></td>
                                      <td><?php echo $ticket->Users['username']; ?></td>
                                      <td><?php echo $ticket->subject; ?></td>
                                      <td>
                                        <?php
                                        $status_cls = 'inactive-staus';
                                        $status_txt = 'Open';
                                        if($ticket->status == 1){
                                          $status_cls = 'active-staus';
                                          $status_txt = 'Closed';
                                        }?>
                                        <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button data-toggle="dropdown" data-play="rubberBand" class="btn btn-default dropdown-toggle" aria-expanded="true"> -Select- <b class="caret"></b>
                                          </button>
                                          <ul class="dropdown-menu animated rubberBand action-dropdown" style="animation-duration: 0.5s; animation-delay: 0s; animation-timing-function: linear; animation-iteration-count: 1;">
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/support/view_ticket/<?php echo $ticket->ticket_id; ?>">View Details</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/support/update-ticket-status/<?php echo $ticket->ticket_id.'/'.base64_encode(0); ?>">Open</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/support/update-ticket-status/<?php echo $ticket->ticket_id.'/'.base64_encode(1); ?>">Close</a> 
                                            </li>
                                            <li>
                                              <a href="<?php echo $backend_url; ?>/support/delete/<?php echo $ticket->ticket_id; ?>" onclick="return confirm('Delete operation will data the permanently from database. Are you sure?');">Delete</a> 
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