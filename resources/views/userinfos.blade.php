<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://datatables.yajrabox.com/css/datatables.bootstrap.css" rel="stylesheet">
<script src="//code.jquery.com/jquery.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="js/handler.js"></script>
{{-- scripts from cdn and places --}}
<div id="test">
    <button type="button" id="addbtn" data-toggle="modal" data-target="#AddmyModal">Add</button>
    <input type="text" id="myInputTextField" placeholder="Search">
    <table id="users-table" class="table">
        <thead>
            {{-- simple table, filled in the js --}}
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Address</th>
                <th>Age</th>
                <th>Salary</th>
                <th>Edit</th>
            </tr>
        </thead>
    </table>
</div>

{{-- this modal for Add / edit--}}
<div class="modal fade" id="myModal" role="dialog">


    <div class="modal-dialog">

        {{-- content --}}
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="modalTitle" class="modal-title">Edit User</h4>
            </div>
            {{-- error to be places here --}}
            <div class="alert alert-danger" style="display:none"></div>
            <div class="modal-body">
                <form id="modalFormData" name="modalFormData" class="form-horizontal" novalidate="">


                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="eName" placeholder="Name"
                                value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Surname</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="eSurName" placeholder="Surname"
                                value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="eAdr" placeholder="Address" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Age</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="eAge" placeholder="Age" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLink" class="col-sm-2 control-label">Salary</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="eSalary" placeholder="Salary" value="">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="eSave" value="edit">Save</button>
                <button type="button" class="btn btn-default" id="eDel" value="delete">Delete</button>
                <input type="hidden" id="link_id" name="link_id" value="0">
            </div>
        </div>

    </div>
</div>
