<div class="container">
  <div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <h3>Add Employee</h3>
        <hr>
        <form class="" action="<?= site_url ('/employee/save') ?>" method="post" id="employee_add">
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group">
               <label for="emp_code">Employee Code</label>
               <input type="text" class="form-control" name="emp_code" id="emp_code" value="<?= set_value('emp_code') ?>">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
               <label for="emp_fname">First Name</label>
               <input type="text" class="form-control" name="emp_fname" id="emp_fname" value="<?= set_value('emp_fname') ?>">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
               <label for="emp_lname">Last Name</label>
               <input type="text" class="form-control" name="emp_lname" id="emp_lname" value="<?= set_value('emp_lname') ?>">
              </div>
            </div>
            <div class="col-12">
              <div class="form-group">
               <label for="emp_email">Email address</label>
               <input type="text" class="form-control" name="emp_email" id="emp_email" value="<?= set_value('emp_email') ?>">
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
               <label for="emp_phone">Phone</label>
               <input type="password" class="form-control" name="emp_phone" id="emp_phone" value="<?= set_value('emp_phone') ?>">
             </div>
           </div>
           <div class="col-12 col-sm-6">
             <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" value="<?= set_value('emp_phone') ?>">
            </div>
          </div>
          <?php if (isset($validation)): ?>
            <div class="col-12">
              <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
              </div>
            </div>
          <?php endif; ?>
          </div>

          <div class="row">
            <div class="col-12 col-sm-4">
              <button type="submit" class="btn btn-primary">Store</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>