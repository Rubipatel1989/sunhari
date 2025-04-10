<div class="auth-box p-4 bg-white rounded" style="max-width: 520px; margin: 2% 0;">
   <div id="loginform">
      <div class="logo">
         <h3 class="box-title mb-3">Member Registration</h3>
      </div>
      <!-- Form -->
      <div class="row">
        <?php echo $this->Flash->render(); ?>
      </div>
      <div class="row">
         <div class="col-12">
           <?php echo $this->Form->create(NULL, array('id' => 'add_user_form', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal'));?>
               <div class="mb-3 margin-top-10 height-64">
            <label>Referral Id<span class="red">*</span></label>
            <?php 
            $referralUsername = $referralInfo->username ?? '';
            echo $this->Form->input('User.sponsor_username', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => 'Enter referral id', 'onchange' => 'return getFullName(this);', 'value' => $referralUsername)); 
            ?>
          </div>
          <div class="mb-3 height-64">
            <label>Referral Name<span class="red">*</span></label>
            <?php 
            $referralName = $referralInfo->name ?? '';
            echo $this->Form->input('User.sponsor_name', array('type' => 'text', 'id' => 'referral_name', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'readonly' => 'readonly', 'value' => $referralName)); 
            ?>
          </div>
          <div class="mb-3 height-64">
            <label>Name<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('User.name', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => 'Enter name')); 
            ?>
          </div>
          <div class="mb-3">
            <div class="row">
              <div class="col-md-4 height-64">
                <label>Country<span class="red">*</span></label>
                <?php 
                $options = ['' => '-Select-'];
                foreach($countries as $country) {
                  $options[$country->id.'__'.$country->country_code] = $country->name;
                }
                echo $this->Form->input('User.country_id', array('type' => 'select', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'options' => $options, 'onchange' => 'return getCountryCode(this);')); 
                ?>
              </div>
              <div class="col-md-4 height-64">
                <label>Country Code<span class="red">*</span></label>
                <?php 
                echo $this->Form->input('User.country_code', array('type' => 'text', 'id' => 'country_code', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'readonly' => 'readonly')); 
                ?>
              </div>
              <div class="col-md-4 height-64">
                <label>Mobile<span class="red">*</span></label>
                <?php 
                echo $this->Form->input('User.contact_number', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => 'Mobile')); 
                ?>
              </div>
            </div>
          </div>
          <div class="mb-3 height-64">
            <label>Email Id<span class="red">*</span></label>
            <?php 
            echo $this->Form->input('User.email', array('type' => 'text', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => 'Enter email id')); 
            ?>
          </div>
          <div class="mb-3">
            <div class="row">
              <div class="col-md-6 height-64">
                <label>Password<span class="red">*</span></label>
                <?php 
                echo $this->Form->input('User.password', array('type' => 'password', 'id' => 'password', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => '**********')); 
                ?>
              </div>
              <div class="col-md-6 height-64">
                <label>Confirm Password<span class="red">*</span></label>
                <?php 
                echo $this->Form->input('User.confirm_password', array('type' => 'password', 'label' => false, 'div' => false, 'class' => 'select2 form-control loginbox', 'placeholder' => '**********')); 
                ?>
              </div>
            </div>
          </div>
               <div class="form-group">
                  <div class="d-flex">
                     <div class="checkbox checkbox-info pt-0">
                        <input name="is_gree_terms"
                           id="is_gree_terms"
                           type="checkbox"
                           class="material-inputs chk-col-indigo" required="required" />
                        <label for="is_gree_terms"> I agree <a href="">Terms of User</a> </label>
                     </div>
                  </div>
               </div>
               <div class="form-group text-center mt-4 mb-3">
                  <div class="col-xs-12">
                     <button
                        class="
                        btn btn-info
                        d-block
                        w-100
                        waves-effect waves-light
                        "
                        type="submit"
                        >
                     Register
                     </button>
                  </div>
               </div>
            <?php echo $this->Form->end();?>
         </div>
      </div>
   </div>
</div>