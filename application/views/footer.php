<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update task status</h4>
      </div>
      <div class="modal-body">
          <div class="row">  
            <div class="form-group col-lg-12">  
                <label for="tstatus">Status*</label>
                <select class="form-control" required id="tstatus" name="tstatus">
                    <option value="O">Open</option>
                    <option value="I">In-Progress</option>
                    <option value="H">Hold</option>
                    <option value="C">Completed</option>
                </select>
            </div>
            <div class="form-group col-lg-12">  
                <label for="tdescription">Write your Log*</label>
                <textarea class="form-control" rows="3" id="tlog" name="tlog" placeholder="Log" required></textarea>
            </div>  
          </div>      
      </div>
      <div class="modal-footer">
          <input type="hidden" id="modal_update_taskid" value="" />  
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateordelete('status_update')">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="logModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Add new log</h4>
      </div>
      <div class="modal-body">
          <div class="row">  
            <div class="form-group col-lg-12">  
                <label for="tdescription">Write your Log*</label>
                <textarea class="form-control" rows="3" id="tlog" name="tlog" placeholder="Log" required></textarea>
            </div>  
          </div>      
      </div>
      <div class="modal-footer">
          <input type="hidden" id="modal_update_taskid" value="" />  
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="updateordelete('write_Log')">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/assets/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/main.js"></script>
  </body>
</html>