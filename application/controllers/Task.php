<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
    
        function __construct(){
            parent::__construct();
            $this->load->model('task_model');
        }

        /*
         * Task Home Page
         * List all the tasks
         */
	public function index()
	{
            $this->db->join('projects', 'projects.ProjectId = task.ProjectId');
            $this->db->join('employee', 'employee.ID = task.Assigned');
            $data['tasks'] = $this->task_model->selectData('task',array('Status !=' => 'D'),'projects.ProjectName,employee.FullName, task.*');
            $this->load->view('tasks',$data);
	}
        
        /*
         * Form page to add new task
         * Required - Role & Project list
         */
        public function add_new_task(){
            $roles = array('manager', 'lead', 'programmer');
            $this->db->where_in('Role', $roles);
            $data['employee'] = $this->task_model->selectData('employee',array('Active' => TRUE),'ID, FullName, Email, Designation, Role');
            
            $data['project'] = $this->task_model->selectData('projects',array('Active' => TRUE),'ProjectId, ProjectName, ProjectDescription, Client');
            $this->load->view('task_create', $data);
        }
        
        /*
         * Form Submit to create new task
         * Validating Form submit to ensure the form data
         * Insert in to New task after validation
         */
        public function create(){
            $this->form_validation->set_rules('tname', 'Task Name', 'required|is_unique[task.TaskName]|min_length[10]');
            $this->form_validation->set_rules('tdescription', 'Description', 'required|min_length[50]');
            $this->form_validation->set_rules('tproject', 'Project', 'required|integer');
            $this->form_validation->set_rules('tassigne', 'Assigned To', 'required|integer');
            $this->form_validation->set_rules('tapproxduration', 'Approx Duration', 'required|integer');
            $this->form_validation->set_rules('tpriority', 'Priority', 'required|alpha');
            $this->form_validation->set_rules('tstatus', 'Status', 'required|max_length[1]');
            
            if ($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('error', validation_errors());
                redirect('/create');
            }else{
                $new_task = array('ProjectId' => $this->input->post('tproject'),'TaskName' => $this->input->post('tname'), 'TaskDescription' => $this->input->post('tdescription'), 'Assigned' => $this->input->post('tassigne'), 'ApproxDuration' => $this->input->post('tapproxduration'), 'Priority' => $this->input->post('tpriority'), 'Status' => $this->input->post('tstatus'),'CreatedTS'=>date('Y-m-d H:i:s'),'UpdatedTS'=>date('Y-m-d H:i:s'));
                try{
                    $this->task_model->insertData('task',$new_task);
                    $taskid = $this->db->insert_id();
                    if($_FILES['treffile']){
                        $this->do_upload($taskid);
                    }
                    $this->session->set_flashdata('error', 'Task added successfully');
                    redirect('/');
                } catch (Exception $ex) {
                    $this->session->set_flashdata('error', 'Something went wrong. Please try again after some time');
                    redirect('/create');
                }
                
            }
            
        }
        
        /*
         * Reference file upload
         * Valid files (PDF/JPEG)
         * Max File Size (10 MB)
         * After successfull upload, insert record into task_reference_files
         * 
         */
        private function do_upload($taskid)
        {
            $new_name = time().$_FILES["treffile"]['name'];
            $config['file_name'] = $new_name;
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'jpg|pdf';
            $config['max_size']             = 10048;
            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('treffile'))
            {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('/create');
                    exit;
            }
            else
            {
                    $data = array('FileName' => $new_name, 'TaskId' => $taskid, 'CreatedTS' => date('Y-m-d H:i:s'));
                    $this->task_model->insertData('task_reference_files',$data);
                    return TRUE;
            }
        }
        
        /*
         * Edit Task
         */
        public function edit_task($id){
            $roles = array('manager', 'lead', 'programmer');
            $this->db->where_in('Role', $roles);
            $data['employee'] = $this->task_model->selectData('employee',array('Active' => TRUE),'ID, FullName, Email, Designation, Role');
            
            $data['project'] = $this->task_model->selectData('projects',array('Active' => TRUE),'ProjectId, ProjectName, ProjectDescription, Client');
            
            $this->db->join('projects', 'projects.ProjectId = task.ProjectId');
            $this->db->join('employee', 'employee.ID = task.Assigned');
            $data['tasks'] = $this->task_model->selectData('task',array('TaskId' => $id),'projects.ProjectName,employee.FullName, task.*');
            $data['tasks'] = $data['tasks'][0];
            
            $data['reffile'] = $this->task_model->selectData('task_reference_files',array('TaskId' => $id, 'Status !=' => 'D'),'TaskId, FileName');
            
            if(empty($data['tasks'])){
                show_error('Something went wrong. Please try again', 400);
            }
            $this->load->view('task_edit', $data);
        }
        
        /*
         * Form Submit to update task
         * Validating Form submit to ensure the form data
         * Update task after validation
         */
        
        public function update($taskid){
            $this->form_validation->set_rules('tname', 'Task Name', 'required|min_length[10]');
            $this->form_validation->set_rules('tdescription', 'Description', 'required|min_length[50]');
            $this->form_validation->set_rules('tproject', 'Project', 'required|integer');
            $this->form_validation->set_rules('tassigne', 'Assigned To', 'required|integer');
            $this->form_validation->set_rules('tapproxduration', 'Approx Duration', 'required|integer');
            $this->form_validation->set_rules('tpriority', 'Priority', 'required|alpha');
            $this->form_validation->set_rules('tstatus', 'Status', 'required|max_length[1]');
            
            if ($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('error', validation_errors());
                redirect('/edit/'.$taskid);
            }else{
                $condition = array('TaskName' => $this->input->post('tname'), 'TaskId !=' => $taskid);
                $exist = $this->task_model->selectData('task',$condition,'TaskId');
                if(!empty($exist)){
                    $this->session->set_flashdata('error', 'TaskName has been already taken');
                    redirect('/edit/'.$taskid);
                }
                
                $new_task = array('ProjectId' => $this->input->post('tproject'),'TaskName' => $this->input->post('tname'), 'TaskDescription' => $this->input->post('tdescription'), 'Assigned' => $this->input->post('tassigne'), 'ApproxDuration' => $this->input->post('tapproxduration'), 'Priority' => $this->input->post('tpriority'), 'Status' => $this->input->post('tstatus'),'UpdatedTS'=>date('Y-m-d H:i:s'));
                try{
                    $this->task_model->updateData('task',$new_task,array('TaskId' => $taskid));
                    if($_FILES['treffile']){
                        $this->do_upload($taskid);
                    }
                    $this->session->set_flashdata('error', 'Task updated successfully');
                    redirect('/edit/'.$taskid);
                } catch (Exception $ex) {
                    $this->session->set_flashdata('error', 'Something went wrong. Please try again after some time');
                    redirect('/edit/'.$taskid);
                }
                
            }
            
        }
        
        /*
         * To view individual task complete information
         */
        public function view_task($id){
            $roles = array('manager', 'lead', 'programmer');
            $this->db->where_in('Role', $roles);
            $data['employee'] = $this->task_model->selectData('employee',array('Active' => TRUE),'ID, FullName, Email, Designation, Role');
            
            $data['project'] = $this->task_model->selectData('projects',array('Active' => TRUE),'ProjectId, ProjectName, ProjectDescription, Client');
            
            $this->db->join('projects', 'projects.ProjectId = task.ProjectId');
            $this->db->join('employee', 'employee.ID = task.Assigned');
            $data['tasks'] = $this->task_model->selectData('task',array('TaskId' => $id),'projects.ProjectName,employee.FullName, task.*');
            $data['tasks'] = $data['tasks'][0];
            
            $data['reffile'] = $this->task_model->selectData('task_reference_files',array('TaskId' => $id,'Status !='=>'D'),'FileId,TaskId, FileName');
            $data['tasklog'] = $this->task_model->selectData('task_log',array('TaskId' => $id,'Status !='=>'D'),'LogId, LogDetail, Status');
            
            if(empty($data['tasks'])){
                show_error('Something went wrong. Please try again', 400);
            }
            $this->load->view('task_view', $data);
        }
        
        /*
         * Update on Ajax request
         * Status update, write log, delete log, delete file, delete task
         * UpdateType - status : Updating task status via ajax request
         * UpdateType - log : Adding new log for task via ajax request
         * UpdateType - deletelog : Updating log status to 'D' via ajax request
         * UpdateType - deletefile : Updating file status to 'D' and delete files
         * UpdateType - deletetask : Updating task status to 'D' via ajax request
         * 
         */
        public function update_task(){
            
            if($this->input->post('updateType') == 'status'){
                $condition = array('taskId' => $this->input->post('taskId'));
                $data_update = array('Status' => $this->input->post('taskStatus'));
                $log_data = array('taskId' => $this->input->post('taskId'),'LogDetail' => $this->input->post('taskLog'),'CreatedTS' => date('Y-m-d H:i:s'),'UpdatedTS' => date('Y-m-d H:i:s'));
                try{
                    $this->task_model->updateData('task',$data_update,$condition);
                    $this->task_model->insertData('task_log',$log_data);
                    echo TRUE;
                } catch (Exception $ex){
                    echo FALSE;
                    exit;
                }
            }elseif($this->input->post('updateType') == 'log'){
                $log_data = array('taskId' => $this->input->post('taskId'),'LogDetail' => $this->input->post('taskLog'),'CreatedTS' => date('Y-m-d H:i:s'),'UpdatedTS' => date('Y-m-d H:i:s'));
                try{
                    $this->task_model->insertData('task_log',$log_data);
                    echo TRUE;
                } catch (Exception $ex){
                    echo FALSE;
                    exit;
                }
            }elseif($this->input->post('updateType') == 'deletelog'){
                $condition = array('LogId' => $this->input->post('taskId'));
                $log_data = array('Status' => 'D','UpdatedTS' => date('Y-m-d H:i:s'));
                try{
                    $this->task_model->updateData('task_log',$log_data,$condition);
                    echo TRUE;
                } catch (Exception $ex){
                    echo FALSE;
                    exit;
                }
            }elseif($this->input->post('updateType') == 'deletefile'){
                $condition = array('FileId' => $this->input->post('taskId'));
                $log_data = array('Status' => 'D','UpdatedTS' => date('Y-m-d H:i:s'));
                try{
                    $reffile = $this->task_model->selectData('task_reference_files',array('FileId' => $this->input->post('taskId')),'FileName');
                    $file = 'uploads/'.$reffile[0]->FileName;
                    if (is_readable($file)) {
                        unlink($file);
                        $this->task_model->updateData('task_reference_files',$log_data,$condition);
                        echo TRUE;
                    }
                } catch (Exception $ex){
                    echo FALSE;
                    exit;
                }
            }elseif($this->input->post('updateType') == 'deletetask'){
                $condition = array('TaskId' => $this->input->post('taskId'));
                $log_data = array('Status' => 'D','UpdatedTS' => date('Y-m-d H:i:s'));
                try{
                    $this->task_model->updateData('task',$log_data,$condition);
                    echo TRUE;
                } catch (Exception $ex){
                    echo FALSE;
                    exit;
                }
            }
        }
}
