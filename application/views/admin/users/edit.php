    <div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>">
            <?php echo ucfirst($this->uri->segment(2));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Updating <?php echo ucfirst($this->uri->segment(2));?>
        </h2>
      </div>

 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Thành công!</strong> user đã cập nhật.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Lỗi!</strong> vui lòng thử lại.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');
      $options_course = array('' => "Select");
      foreach ($courses2 as $row)
      {
        $options_course[$row['id']] = $row['name'];
      }

      //form validation
      echo validation_errors();

      echo form_open('admin/users/update/'.$this->uri->segment(4).'', $attributes);
      ?>
        <fieldset>
          <div class="control-group">
            <label for="inputError" class="control-label">Name</label>
            <div class="controls">
              <input type="text" id="" name="name" value="<?php echo $user[0]['name']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Image</label>
            <div class="controls">
              <input type="text" id="" name="image" value="<?php echo $user[0]['image']; ?>">
              <!--<span class="help-inline">Time Learn</span>-->
            </div>
          </div>          
          <div class="control-group">
            <label for="inputError" class="control-label">Time Learn</label>
            <div class="controls">
              <input type="text" id="" name="timelearn" value="<?php echo $user[0]['timelearn'];?>">
              <!--<span class="help-inline">Time Learn</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Time Use</label>
            <div class="controls">
              <input type="text" name="timeuse" value="<?php echo $user[0]['timeuse']; ?>">
              <!--<span class="help-inline">OOps</span>-->
            </div>
          </div>
          <?php
          echo '<div class="control-group">';
            echo '<label for="course_id" class="control-label">Course</label>';
            echo '<div class="controls">';
              //echo form_dropdown('course_id', $options_course, '', 'class="span2"');
              
              echo form_dropdown('course_id', $options_course, $user[0]['course_id'], 'class="span2"');

            echo '</div>';
          echo '</div">';
          ?>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <button class="btn" type="reset">Cancel</button>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
     