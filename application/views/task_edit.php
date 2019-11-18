<?php $this->load->view('header'); ?>

<div class="container">
    <h3>Edit task</h3>
    
    <?php if($this->session->flashdata('error')){ ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
       <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       <div><?= $this->session->flashdata('error'); ?></div>
    </div>
    <?php } ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="tname">Task Name*</label>
          <input type="text" class="form-control" name="tname" id="tname" required placeholder="Task Name" value="<?=$tasks->TaskName?>">
        </div>
        <div class="form-group">
          <label for="tdescription">Description*</label>
          <textarea class="form-control" rows="3" id="tdescription" name="tdescription" placeholder="Description" required><?=$tasks->TaskDescription?></textarea>
        </div>
        <div class="form-group">
            <label for="tproject">Project*</label>
            <select class="form-control" required id="tproject" name="tproject">
                <option value="">Select Project</option>
                <?php foreach($project as $rw) { ?>
                <option <?=($rw->ProjectId == $tasks->ProjectId) ? 'selected' : "" ?> value="<?=$rw->ProjectId?>"><?=$rw->ProjectName?></option>
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
                        <option <?=($rw->ID == $tasks->Assigned) ? 'selected' : "" ?> value="<?=$rw->ID?>"><?=$rw->FullName.' ('.$rw->Designation.')'?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-3">  
                    <label for="tapproxduration">Approx. Duration*</label>
                    <input type="number" class="form-control" name="tapproxduration" id="tapproxduration" required placeholder="Approx. Duration (in Days)" min="1" max="100" value="<?=$tasks->ApproxDuration?>">
                </div>
                <div class="col-lg-3">  
                    <label for="tpriority">Priority*</label>
                    <select class="form-control" required id="tpriority" name="tpriority">
                        <option value="">Select Priority</option>
                        <option value="Low" <?=($tasks->Priority == 'Low') ? 'selected' : "" ?>>Low</option>
                        <option value="Medium" <?=($tasks->Priority == 'Medium') ? 'selected' : "" ?>>Medium</option>
                        <option value="High" <?=($tasks->Priority == 'High') ? 'selected' : "" ?>>High</option>
                    </select>
                </div>
                <div class="col-lg-3">  
                    <label for="tstatus">Status*</label>
                    <select class="form-control" required id="tstatus" name="tstatus">
                        <option value="O" <?=($tasks->Status == 'O') ? 'selected' : "" ?>>Open</option>
                        <option value="I" <?=($tasks->Status == 'I') ? 'selected' : "" ?>>In-Progress</option>
                        <option value="H" <?=($tasks->Status == 'H') ? 'selected' : "" ?>>Hold</option>
                        <option value="C" <?=($tasks->Status == 'C') ? 'selected' : "" ?>>Completed</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <h4>Reference Files</h4>
            <ul class="list-group">
                <?php foreach($reffile as $rw) { ?>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-8">
                                <?= $rw->FileName ?>
                            </div>    
                            <div class="text-right col-lg-4">
                                <a target="_blank" href="/uploads/<?= $rw->FileName ?>" class="text-right">View</a>
                                <a href="javascript:void(0);" onclick="updateordelete('deletefile',<?=$rw->FileId?>)" class="text-right">Delete</a>
                            </div>
                        </div>   
                    </li>
                <?php } ?>
              </ul>
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


