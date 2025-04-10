<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
   <div class="pull-right text-center">
      
   </div>
   View Ticket
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
                         <div class="col-xs-12 nopadding">
                          <div class="col-xs-12 nopadding">
                            <div class="ticket-profile-pic">
                              <img src="<?php $home_url ?>/img/no-image.jpg">
                            </div>
                            <div class="ticket-by">
                              <div class="col-xs-12 nopadding name-info">
                                <?php echo $ticket->Users['username']; ?>
                              </div>
                              <div class="col-xs-12 nopadding ticket-on">
                                <?php echo date("F j, Y, g:i a", strtotime($ticket->created)); ?>
                              </div>
                            </div>
                            <div class="ticket-status">
                              <?php
                              $status_cls = 'inactive-staus';
                              $status_txt = 'Open';
                              if($ticket->status == 1){
                                $status_cls = 'active-staus';
                                $status_txt = 'Closed';
                              }?>
                              <div class="whitetext-1 <?php echo $status_cls; ?>"><?php echo $status_txt; ?></div>
                            </div>
                          </div>
                          <div class="col-xs-12 ticket-info-box">
                            <div class="col-xs-12 query-cotainer padding-right-10 padding-right-10">
                              <div class="col-xs-12 nopadding">
                                <h2 class="subject"><?php echo $ticket->subject; ?></h2>
                              </div>
                              <div class="col-xs-12 nopadding margin-top-5">
                                <?php echo html_entity_decode($ticket->description); ?>
                              </div>
                            </div>
                            <div class="col-xs-12 replies-cotainer">
                              <div class="col-xs-12 padding-left-7 padding-right-7 replies-count">
                                <i class="fa fa-edit"></i> <strong><?php echo count($replies); ?> Replies</strong>
                              </div>
                              <div class="col-xs-12 padding-left-7 padding-right-7">
                                <?php
                                if(!empty($replies)){
                                  foreach($replies as $reply){?>
                                    <div class="col-xs-12 nopadding margin-top-15 reply-info-cotainer">
                                      <div class="ticket-profile-pic">
                                        <img src="<?php $home_url ?>/img/no-image.jpg">
                                      </div>
                                      <div class="col-xs-12 nopadding">
                                        <div class="col-xs-12 nopadding replied-by">
                                          <?php echo $reply->Users['username']; ?>
                                        </div>
                                        <div class="col-xs-12 nopadding reply-on">
                                          <?php echo date("F j, Y, g:i a", strtotime($reply->created)); ?>
                                        </div>
                                        <div class="col-xs-12 grey-top-strip-1"></div>
                                        <div class="col-xs-12 nopadding">
                                          <?php echo html_entity_decode($reply->description); ?>
                                        </div>
                                        <div class="col-xs-12 nopadding margin-top-5">
                                          <a href="" title="Edit" class="edit-icon-container edit-reply-icon"><i class="fa fa-pencil"></i></a> &nbsp; <a href="<?php echo $backend_url; ?>/support/delete-reply/<?php echo $reply->id; ?>" onclick=" return confirm('Delete operation will delete the data permanently from database. Are you sure?');" title="Delete" class="delete-icon-container"><i class="fa fa-trash"></i></a>
                                        </div>
                                        <div class="col-xs-12 reply-form-container margin-top-20" style="display: none;">
                                          <form name="edit-reply-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                            <?php echo $this->Form->input('Reply.id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'value' => $reply->id)); ?>
                                           
                                            <div class="col-xs-12 reply-text-fiel-container">
                                              <div class="col-xs-12 nopadding" style="height:70px;">
                                                <?php echo $this->Form->input('Reply.description', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Edit reply...', 'style' => 'height:70px;', 'value' => $reply->description)); ?>
                                              </div>
                                              <div class="col-xs-12 nopadding margin-top-20 btn-reply-container">
                                                <button type="submit" name="btn_edit_reply" class="btn-reply btn btn-square btn-primary">Edit</button>
                                              </div>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                <?php
                                  }
                                }?>
                              </div>
                              <?php
                              if($ticket->status == 0){?>
                                <div class="col-xs-12 reply-form-container margin-top-20">
                                  <div class="col-xs-12 padding-left-8 padding-right-8">
                                    <form name="reply-form" id="reply-form" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                      <?php echo $this->Form->input('Reply.ticket_id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'value' => $ticket->id)); ?>
                                      <?php echo $this->Form->input('Reply.parent_id', array('type' => 'hidden', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Remark', 'value' => 0)); ?>
                                      <div class="col-xs-12 reply-text-fiel-container">
                                        <div class="col-xs-12 nopadding" style="height:70px;">
                                          <?php echo $this->Form->input('Reply.description', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Write your reply...', 'style' => 'height:70px;')); ?>
                                        </div>
                                        <div class="col-xs-12 nopadding margin-top-20 btn-reply-container">
                                          <button type="submit" name="btn_post_reply" class="btn-reply btn btn-square btn-primary">Reply</button>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              <?php
                              }?>
                            </div>
                        </div>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>