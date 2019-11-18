<?php $this->load->view('header'); ?>

<div class="container">
    <h3>Add new task</h3>
    
    <?php if($this->session->flashdata('error')){ ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <div><?= $this->session->flashdata('error'); ?></div>
    </div>
    <?php } ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="tname">Task Name*</label>
          <input type="text" class="form-control" name="tname" id="tname" required placeholder="Task Name">
        </div>
        <div class="form-group">
          <label for="tdescription">Description*</label>
          <textarea class="form-control" rows="3" id="tdescription" name="tdescription" placeholder="Description" required></textarea>
        </div>
        <div class="form-group">
            <label for="tproject">Project*</label>
            <select class="form-control" required id="tproject" name="tproject">
                <option value="">Select Project</option>
                <?php foreach($project as $rw) { ?>
                <option value="<?=$rw->ProjectId?>"><?=$rw->ProjectName?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <div class="row"> 
                <div class="col-lg-3">  
                    <label for="tassigne">Assigned To*</label>
                    <select class="form-control" required id="tassigne" name="tassigne">
                        <option value="">Select Assigne</option>
                        <?php foreach($employee as $rw) { ?>
                        <option value="<?=$rw->ID?>"><?=$rw->FullName.' ('.$rw->Designation.')'?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-3">  
                    <label for="tapproxduration">Approx. Duration*</label>
                    <input type="number" class="form-control" name="tapproxduration" id="tapproxduration" required placeholder="Approx. Duration (in Days)" min="1" max="100">
                </div>
                <div class="col-lg-3">  
                    <label for="tpriority">Priority*</label>
                    <select class="form-control" required id="tpriority" name="tpriority">
                        <option value="">Select Priority</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                    </select>
                </div>
                <div class="col-lg-3">  
                    <label for="tstatus">Status*</label>
                    <select class="form-control" required id="tstatus" name="tstatus">
                        <option value="O">Open</option>
                        <option value="I">In-Progress</option>
                        <option value="H">Hold</option>
                        <option value="C">Completed</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
          <label for="treffile">Upload</label>
          <input type="file" id="treffile" name="treffile" accept="application/pdf,image/jpeg">
          <p class="help-block">Upload (PDF/JPG) and Max. File size 10MB</p>
        </div>
        <div class="col-lg-12 text-center">
            <button type="submit" class="btn btn-default">Submit</button>
            <a href="/">Back to List</a>
        </div>
      </form>    
</div>    

   
<?php $this->load->view('footer'); ?>


