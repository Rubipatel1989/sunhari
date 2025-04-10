<?php
use Cake\ORM\TableRegistry;
$usersTable = TableRegistry::get('Users');
echo $this->Html->css('frontend/css/my-account.css');

//echo '<pre>';
//print_r($userInfos);
?>
<main id="js-page-content" role="main" class="page-content">
    <ol class="breadcrumb page-breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo $backend_url; ?>/user/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active"> Tickets</li>
    </ol>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>
                     Tickets
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="row nopadding table-cotainer margin-top-20">
                          <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
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
</main>
<?php echo $this->element('common-upload'); ?>
<?php echo $this->element('delete-attachment'); ?>