<?php $this->load->view('header'); ?>

<div class="container">
    <div class="row">
        <?php if($this->session->flashdata('error')){ ?>
        <div class="alert alert-success alert-dismissible" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <div><?= $this->session->flashdata('error'); ?></div>
        </div>
        <?php } ?>
        <div class="col-lg-12 pad-left0">
            <div class="col-lg-8 pad-left0">
                <h3>List of Tasks</h3>
            </div>
            <div class="col-lg-4 text-right margin-tp20">
                <a href="/create">Add new task</a>
            </div>
        </div>
    </div>    
    <div class="row">
        <?php if(count($tasks) > 0){ ?>
        <table class="table table-striped">
            <thead>
                <th>Project</th>
                <th>Task Name</th>
                <th>Description</th>
                <th>Assigne</th>
                <th>Status</th>
                <th>Created Date</th>
                <th></th>
            </thead>
            <tbody>
                <?php foreach($tasks as $rw) { ?>
                <tr>
                    <td><?=$rw->ProjectName?></td>
                    <td><?=$rw->TaskName?></td>
                    <td><?= substr($rw->TaskDescription,0,50).'...'?></td>
                    <td><?=$rw->FullName?></td>
                    <td>
                        <?php if($rw->Status == 'O') {?>
                            <span class="label label-primary closetask" data-cStatus='O' data-taskid='<?=$rw->TaskId?>'>Open</span>
                        <?php }elseif($rw->Status == 'I') {?>
                            <span class="label label-info closetask" data-cStatus='I' data-taskid='<?=$rw->TaskId?>'>In-Progress</span>
                        <?php }elseif($rw->Status == 'H') {?>
                            <span class="label label-danger closetask" data-cStatus='H' data-taskid='<?=$rw->TaskId?>'>Hold</span>
                        <?php }elseif($rw->Status == 'C') {?>
                            <span class="label label-success closetask" data-cStatus='C' data-taskid='<?=$rw->TaskId?>'>Completed</span>
                        <?php } ?>
                    </td>
                    <td><?=date('Y-m-d', strtotime($rw->CreatedTS))?></td>
                    <td class="col-lg-3 text-right">
                        <a href="/show/<?=$rw->TaskId?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> View</a>&nbsp;
                        <a href="/edit/<?=$rw->TaskId?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>&nbsp;
                        <a href="javascript:void(0);" onclick="updateordelete('deletetask',<?=$rw->TaskId?>)"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                        <a href="javascript:void(0);" class="writelog" data-taskid='<?=$rw->TaskId?>'><span class="glyphicon glyphicon-pencil"></span> Write Log</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php }else{ ?>
        <h3 class="text-center">No Records!!!</h3>
        <?php } ?>
    </div>    
</div>    

<?php $this->load->view('footer'); ?>

