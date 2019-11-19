<?php $this->load->view('header'); ?>

<div class="container">
    <h3 class="header-rule"><?=$tasks->TaskName?></h3>
    <div class="col-lg-12 pad-left0 margin-tp20">
        <div class="form-group">
          <label>Description - </label>
          <?=$tasks->TaskDescription?>
        </div>

        <div class="form-group">
          <label>Project - </label>
          <?=$tasks->ProjectName?>
        </div>
        
        <div class="form-group">
          <label>Assigned To - </label>
          <?=$tasks->FullName?>
        </div>
        
        <div class="form-group">
          <label>Approx. Duration - </label>
          <?=$tasks->ApproxDuration?> Days
        </div>
        
        <div class="form-group">
          <label>Priority - </label>
          <?=$tasks->Priority?>
        </div>
        
        <div class="form-group">
          <label>Status - </label>
          <?php if($tasks->Status == 'O') {?>
                <span class="label label-primary">Open</span>
            <?php }elseif($tasks->Status == 'I') {?>
                <span class="label label-info">In-Progress</span>
            <?php }elseif($tasks->Status == 'H') {?>
                <span class="label label-danger">Hold</span>
            <?php }elseif($tasks->Status == 'C') {?>
                <span class="label label-success">Completed</span>
            <?php } ?>
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
        <h4>Logs</h4>
        <ul class="list-group">
            <?php foreach($tasklog as $rw) { ?>
                <li class="list-group-item">
                <div class="row">
                    <div class="col-lg-8">
                        <?= $rw->LogDetail ?>
                    </div>    
                    <div class="text-right col-lg-4">
                    <a href="javascript:void(0);" class="text-right" onclick="updateordelete('deletelog',<?=$rw->LogId?>)">Delete</a>
                    </div>
                </div>   
            </li>
            <?php } ?>
          </ul>
    </div>
    
    <?php if($tasks->Status == 'C'){ ?>
    <h4>Task Statistics</h4>
    <div id="example2.1" style="height: 200px;"></div>
    <?php } ?>
    
    <div class="col-lg-12 text-center">
        <a href="/">Back to Task List</a>
    </div>
</div>    
<?php if($tasks->Status == 'C'){ ?>
    <?php $this->load->view('chart-task'); ?>   
<?php } ?>
<?php $this->load->view('footer'); ?>


