<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<div class="container-fluid">
  <div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
      <h3 class="text-themecolor mb-0">Ticket Record</h3>
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
          <a href="<?php echo $home_url; ?>/my-account">Dashboard</a>
        </li>
        <li class="breadcrumb-item active d-flex align-items-center">
          Ticket Record
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
            <table id="table-with-download" class="table table-bordered table-hover table-striped w-100">
                <thead>
                    <tr>
                        <th>Sr. No.</th>
                        <th>Date</th>
                        <th>Ticket Id</th>
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
                          <td><span style="display:none;"><?php echo strtotime($ticket->created); ?></span><?php echo date("d-M-Y", strtotime($ticket->created)); ?></td>
                          <td><?php echo $ticket->ticket_id; ?></td>
                          <td><?php echo $ticket->subject; ?></td>
                          <td>
                            <?php
                            $status_cls = 'inactive-staus';
                            $status_txt = 'Open';
                            if($ticket->status == 1){
                              $status_cls = 'active-staus';
                              $status_txt = 'Closed';
                            }?>
                            <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></dive>
                          </td>
                          <td>
                            <a  href="<?php echo $home_url; ?>/my-account/support/view-ticket/<?php echo $ticket->ticket_id; ?>">View Details</a>
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