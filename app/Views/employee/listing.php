<<div class="container mt-4">
    <div class ="d-flex justify content-end">
        <a href ="<?php echo site_url('/employee/add')?>" class="btn btn-sucess mb-2">Add Employee</a>
</div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">Employee Code</th>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email</th>
      <th scope="col">Phone</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <?php if(count($employee)){ ?>
      <?php foreach($employee as $single_emp){ ?>
        <tr>
          <td><?php echo $single_emp['emp_code']; ?></td>
          <td><?php echo $single_emp['emp_fname']; ?></td>
          <td><?php echo $single_emp['emp_lname']; ?></td>
          <td><?php echo $single_emp['emp_email']; ?></td>
          <td><?php echo $single_emp['emp_phone']; ?></td>
          <td>
            <a href="<?php echo base_url('/employee/edit/'.$single_emp['id']); ?>" class="btn btn-primary btn-sm">Edit</a>
            <a href="<?php echo base_url('/employee/delete/'.$single_emp['id']); ?>" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
      <?php } ?>
      
    <?php } ?>
  </tbody>
</table>