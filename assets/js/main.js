/*
 * Add our Custom Javascript
 */

$(document).ready(function(){
    
/*
 * Disable key press in number input
 */
$("[type='number']").keypress(function (evt) {
    evt.preventDefault();
});

/*
 * To update task status
 * click on "status" in task list
 */
$("span.closetask").on('click',function (evt) {
    var current_status = $(evt.target).attr('data-cStatus')
    var current_taskid = $(evt.target).attr('data-taskid')
    if(current_status == 'C'){
        return false;
    }
    $('#myModal #modal_update_taskid').val(current_taskid)
    $('#myModal #tstatus option[value="'+current_status+'"]').remove()
    if(current_status == 'I' || current_status == 'H'){
        $('#myModal #tstatus option[value="O"]').remove()
    }
    $('#myModal').modal('toggle')
});

/*
 * To write task log
 * click on "write log" link in task list
 */
$('.writelog').on('click', function(evt){
    var current_taskid = $(evt.target).attr('data-taskid')
    $('#logModal #modal_update_taskid').val(current_taskid)
    $('#logModal').modal('toggle')
});
});

/*
 * 
 * @param {type} type - Update type based on user event (status_update, write_log, deletelog, deletefile, deletetask)
 * @param {type} id - TaskId, LogId, FileId
 * @returns {Boolean} - True/False
 */
function updateordelete(type,id = 0){
    /*
     * Update task status
     * Click on "Status" label in task list
     * Required - Status & Log
     */
    if(type == 'status_update'){
        var current_status = $('#myModal #tstatus').val()
        var current_taskid = $('#myModal #modal_update_taskid').val()
        var current_log = $.trim($('#myModal #tlog').val())
        if(current_log == ''){
            alert('Please enter log to update task status')
            return false;
        }
        var dataj = {taskId:current_taskid,taskStatus:current_status, taskLog:current_log,updateType:'status'}
        $.ajax({				
            type: "POST",
            url: '/update',
            dataType:'json',
            data:dataj,
            success: function(data, textStatus, jqXHR){
                alert("Task updated successfully");
                window.location.reload()
            },
            error: function (xhr, textStatus, errorThrown) {					
                if(xhr.status == 200){
                    alert("Task updated successfully");
                    window.location.reload()
                }else if(xhr.status == 409){
                    alert('Request failed');
                }else if(xhr.status == 404){
                    alert('Task Not found');
                }else if(xhr.status == 500){
                    alert('Something went wrong. Please try again after some time');
                }else{
                    alert('Task Not found');
                }
            }
        });
    }
    /*
     * Add task Log
     * Click on "Write Log" link in task list
     * Required - Log
     */
    else if(type == 'write_Log'){
        /*
         * Adding new Log
         */
        var current_taskid = $('#logModal #modal_update_taskid').val()
        var current_log = $.trim($('#logModal #tlog').val())
        if(current_log == ''){
            alert('Please enter log to update task status')
            return false;
        }
        var dataj = {taskId:current_taskid,taskLog:current_log,updateType:'log'}
        $.ajax({				
            type: "POST",
            url: '/update',
            dataType:'json',
            data:dataj,
            success: function(data, textStatus, jqXHR){
                alert("Task updated successfully");
                window.location.reload()
            },
            error: function (xhr, textStatus, errorThrown) {					
                if(xhr.status == 200){
                    alert("Task updated successfully");
                    window.location.reload()
                }else if(xhr.status == 409){
                    alert('Request failed');
                }else if(xhr.status == 404){
                    alert('Task Not found');
                }else if(xhr.status == 500){
                    alert('Something went wrong. Please try again after some time');
                }else{
                    alert('Task Not found');
                }
            }
        });
    }
    /*
     * Delete Log
     * Click on "Delete" link in View Task
     * Required - LogId
     */
    else if(type == 'deletelog'){
        var dataj = {taskId:id,updateType:'deletelog'}
        $.ajax({				
            type: "POST",
            url: '/update',
            dataType:'json',
            data:dataj,
            success: function(data, textStatus, jqXHR){
                alert("Task updated successfully");
                window.location.reload()
            },
            error: function (xhr, textStatus, errorThrown) {					
                if(xhr.status == 200){
                    alert("Task updated successfully");
                    window.location.reload()
                }else if(xhr.status == 409){
                    alert('Request failed');
                }else if(xhr.status == 404){
                    alert('Task Not found');
                }else if(xhr.status == 500){
                    alert('Something went wrong. Please try again after some time');
                }else{
                    alert('Task Not found');
                }
            }
        });
    }
    /*
     * Delete Reference File
     * Click on "Delete" link in View Task
     * Required - FileId
     */
    else if(type == 'deletefile'){
        var dataj = {taskId:id,updateType:'deletefile'}
        $.ajax({				
            type: "POST",
            url: '/update',
            dataType:'json',
            data:dataj,
            success: function(data, textStatus, jqXHR){
                alert("Task updated successfully");
                window.location.reload()
            },
            error: function (xhr, textStatus, errorThrown) {					
                if(xhr.status == 200){
                    alert("Task updated successfully");
                    window.location.reload()
                }else if(xhr.status == 409){
                    alert('Request failed');
                }else if(xhr.status == 404){
                    alert('Task Not found');
                }else if(xhr.status == 500){
                    alert('Something went wrong. Please try again after some time');
                }else{
                    alert('Task Not found');
                }
            }
        });
    }
    /*
     * Delete Task
     * Click on "Delete" link in task list
     * Required - TaskId
     */
    else if(type == 'deletetask'){
        var dataj = {taskId:id,updateType:'deletetask'}
        $.ajax({				
            type: "POST",
            url: '/update',
            dataType:'json',
            data:dataj,
            success: function(data, textStatus, jqXHR){
                alert("Task updated successfully");
                window.location.reload()
            },
            error: function (xhr, textStatus, errorThrown) {					
                if(xhr.status == 200){
                    alert("Task updated successfully");
                    window.location.reload()
                }else if(xhr.status == 409){
                    alert('Request failed');
                }else if(xhr.status == 404){
                    alert('Task Not found');
                }else if(xhr.status == 500){
                    alert('Something went wrong. Please try again after some time');
                }else{
                    alert('Task Not found');
                }
            }
        });
    }
}

