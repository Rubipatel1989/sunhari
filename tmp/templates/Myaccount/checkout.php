<?php
echo $this->Html->css('frontend/css/my-account.css');
?>
<h3>
  <div class="pull-right text-center"> 
  </div>
  Checkout
</h3>
<div class="row">
   <div class="col-xs-12 padding-left-5 padding-right-5">
        <div class="col-xs-12 padding-left-10 padding-right-10">
            
            <div class="col-xs-12 nopadding ">
                <div class="panel panel-default">
                     <div class="panel-body">
                      <?php
                      if(!empty($carts)){?>  
                        <div class="col-xs-12 nopadding">
                          <?php echo $this->Flash->render(); ?>
                        </div>
                        <div class="col-xs-12 nopadding">
                          <h2 class="title-1">Cart Details</h2>
                        </div>
                        <div class="col-xs-12 nopadding table-cotainer">
                          <table class="table table-striped table-hover">
                             <thead>
                                <tr>
                                  <th>Sr. No.</th>
                                  <th>Product</th>
                                  <th>Quantity</th>
                                  <th>Price</th>
                                  <th class="text-right">Total</th>
                                </tr>
                             </thead>
                             <tbody>
                                <?php
                                $i=1;
                                $grandTotal = 0;
                                foreach($carts as $cart){
                                    $price = $cart->Products['price'];
                                    if(!empty($cart->Products['discount_price']) && $cart->Products['discount_price'] > 0){
                                      $price = $cart->Products['discount_price'];
                                    }
                                    $total = $cart->quantity*$price;
                                    $grandTotal = $grandTotal + $total;
                                ?>
                                  <tr class="gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $cart->Products['name']; ?></td>
                                    <td style="padding: 0 0 0 25px;"><?php echo $cart->quantity; ?> &nbsp;<a  onclick="return confirm('Delete operation will delete the data permanently from database. Are you sure?');" href="<?php echo $home_url;?>/my-account/remove-cart-product/<?php echo base64_encode($cart->id);?>" class="cart-remove-link" title="Remove Product"><i class="fa fa-times"></i></a></td>
                                    <td>Rs <?php echo number_format($price, 2); ?></td>
                                    <td class="text-right">Rs <?php echo number_format(($cart->quantity*$price), 2); ?></td>
                                  </tr>
                                <?php
                                  $i++;
                                }
                              ?>
                              <tr class="gradeX">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: right; font-weight: bold; font-size: 19px; line-height: 29px;"><stron>Grand Total</stron></td>
                                    <td style="text-align: right; font-weight: bold; font-size: 19px; line-height: 29px;">Rs <?php echo number_format($grandTotal, 2); ?></td>
                                  </tr>
                            </tbody>
                          </table>
                        </div>
                        <div class="col-xs-12 nopadding margin-top-25">
                          <h2 class="title-1">Personal Details</h2>
                        </div>
                        <div class="col-xs-12 nopadding margin-top-25">
                          <?php echo $this->Form->create(NULL, array('id' => 'order_form', 'action' => $home_url.'/my-account/checkout', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-2 control-label">Name<span class="red">*</span></label>
                                <div class="col-sm-8 height-37">
                                    <div class="col-xs-12 nopadding">
                                      <div class="col-xs-6 padding-left-0 padding-right-5">
                                        <?php 
                                        echo $this->Form->input('Order.first_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'First Name', 'value' => $user->Details['first_name'])); 
                                        ?>
                                      </div>
                                      <div class="col-xs-6 padding-left-5 padding-right-0">
                                        <?php 
                                        echo $this->Form->input('Order.last_name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Last Name', 'value' => $user->Details['last_name'])); 
                                        ?>
                                      </div>
                                    </div>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-2 control-label">Contact Details<span class="red">*</span></label>
                                <div class="col-sm-8 height-37">
                                    <div class="col-xs-12 nopadding">
                                      <div class="col-xs-6 padding-left-0 padding-right-5">
                                        <?php 
                                        echo $this->Form->input('Order.contact_no', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Contact Number', 'value' => $user->Details['contact_no'])); 
                                        ?>
                                      </div>
                                      <div class="col-xs-6 padding-left-5 padding-right-0">
                                        <?php 
                                        echo $this->Form->input('Order.email', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Contact Email', 'value' => $user->email)); 
                                        ?>
                                      </div>
                                    </div>
                                </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                 <label class="col-sm-2 control-label">Delivery Address<span class="red">*</span></label>
                                 <div class="col-sm-8">
                                  <div class="col-xs-12 nopadding" style="height: 90px;">
                                    <?php 
                                    echo $this->Form->input('Order.delivery_address', array('type' => 'textarea', 'label' => false, 'div' => false, 'class' => 'form-control loginbox', 'placeholder' => 'Enter Your Delivery Address', 'style' => 'height:80px;')); 
                                    ?>
                                  </div>
                                 </div>
                              </div>
                            </fieldset>
                            <fieldset>
                              <div class="form-group">
                                <label class="col-sm-2 control-label"></label>
                                <div class="col-sm-8 height-37">
                                  <div class="col-xs-12 nopadding">
                                     <button type="submit" name="btn_order" class="btn btn-square btn-primary">Order Now  </button>
                                  </div>
                                </div>
                              </div>
                            </fieldset>
                          <?php echo $this->Form->end();?>
                        </div>
                      <?php
                      }else{?>
                        <div class="col-xs-12 nopadding empty-cart-message">
                          Sorry! your cart is empty. To place an order please do shopping from our <a class="blue-link-1" href="<?php echo $home_url; ?>/my-account/buy-product">Buy Product</a> page.
                        </div>
                      <?php
                      }?>
                     </div>
                  </div>
            </div>
        </div>
    </div>
</div>