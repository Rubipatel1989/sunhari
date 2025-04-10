<?php
echo $this->Html->css('frontend/css/my-account.css');
use Cake\ORM\TableRegistry;
$upgradesTable  = TableRegistry::get('Upgrades');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Ticket History</h3>
    </div>
    <div
      class="
        col-md-7 col-12
        align-self-center
        d-none d-md-flex
        justify-content-end
      "
    >
      <ol class="breadcrumb mb-0 p-0 bg-transparent">
        <li class="breadcrumb-item">
          <a href="javascript:void(0)">Home</a>
        </li>
        <li class="breadcrumb-item active d-flex align-items-center">
          Ticket History
        </li>
      </ol>
    </div>
  </div>
  <!-- -------------------------------------------------------------- -->
  <!-- Start Page Content -->
  <!-- -------------------------------------------------------------- -->
  <div class="row">
    <div class="col-sm-12">
      <?php echo $this->Flash->render(); ?>
    </div>
  </div>
  <div class="card card-body">
    <div class="row">
      <div class="col-sm-12">
        <?php echo $this->Form->create(NULL, array('id' => 'epin_list_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
          <div class="row nopadding table-cotainer">
            <table id="packages" class="table table-bordered table-hover table-striped w-100">
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
                        <td style="white-space: nowrap;"><span style="display:none;"><?php echo strtotime($ticket->created); ?></span><?php echo date("d/m/y g:i a", strtotime($ticket->created)); ?></td>
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
                          <div class="btn-group" role="group">
                            <button id="btnGroupVerticalDrop1" type="button" class="btn btn-light-secondary text-secondary font-weight-medium dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Dropdown
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1" style="">
                                <a class="dropdown-item" href="<?php echo $backend_url; ?>/support/view_ticket/<?php echo $ticket->ticket_id; ?>">View Details</a> 
                                <a class="dropdown-item" href="<?php echo $backend_url; ?>/support/update-ticket-status/<?php echo $ticket->ticket_id.'/'.base64_encode(0); ?>">Open</a>
                                <a class="dropdown-item" href="<?php echo $backend_url; ?>/support/update-ticket-status/<?php echo $ticket->ticket_id.'/'.base64_encode(1); ?>">Close</a> 
                                <a class="dropdown-item" href="<?php echo $backend_url; ?>/support/delete/<?php echo $ticket->ticket_id; ?>" onclick="return confirm('Delete operation will data the permanently from database. Are you sure?');">Delete</a> 
                            </ul>
                            </div>
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
        <?php echo $this->Form->end();?>
      </div>
    </div>
  </div>
  <!-- /.row -->
  <!-- -------------------------------------------------------------- -->
  <!-- End PAge Content -->
  <!-- -------------------------------------------------------------- -->
</div>