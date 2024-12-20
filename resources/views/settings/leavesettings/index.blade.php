<div class="page-header">
    <h1 class="page-title">{{__('All Settings')}}</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item ">{{__('Leave Settings')}}</li>
        <li class="breadcrumb-item active">{{__('You are Here')}}</li>
    </ol>
    <div class="page-header-actions">
        <div class="row no-space w-250 hidden-sm-down">

            <div class="col-sm-6 col-xs-12">
                <div class="counter">
                    <span class="counter-number font-weight-medium">{{date('Y-m-d')}}</span>

                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="counter">
                    <span class="counter-number font-weight-medium" id="time"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-content container-fluid">
    <div class="row">
        <div class="col-md-12 col-xs-12">

            <div class="panel panel-info panel-line">
                <div class="panel-heading">
                    <h3 class="panel-title">Leave</h3>
                    <div class="panel-actions">

                        <button class="btn btn-info" data-toggle="modal" data-target="#addLeaveModal">Add Leave</button>
                    </div>
                </div>
                <div class="panel-body">

                    <table id="exampleTablePagination" data-toggle="table"
                    data-query-params="queryParams" data-mobile-responsive="true"
                    data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                    <thead>
                        <tr>
                            <th >Name:</th>
                            <th>Length(Days)</th>
                            <th>With / Without Pay</th>
                            <th>Gender</th>
                            <th >Action:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                        <tr>
                            <td>{{$leave->name}}</td>
                            <td>{{$leave->length}}</td>
                            <td>{{$leave->with_pay==1?'With pay':'Without Pay'}}</td>
                            <td>{{$leave->gender=='all'?'All':($leave->gender=='M'?'Male':($leave->gender=='F'?'Female':''))}}</td>
                            <td><a class="" title="edit" class="btn btn-icon btn-info" id="{{$leave->id}}"
                             onclick="prepareLEditData(this.id);"><i class="fa fa-pencil"
                             aria-hidden="true"></i></a>
                             <a class="" title="delete" class="btn btn-icon btn-danger" id="{{$leave->id}}"
                                 onclick="deleteLeave(this.id);"><i class="fa fa-trash"
                                 aria-hidden="true"></i></a>
                             </td>
                         </tr>
                         @empty
                         @endforelse

                     </tbody>
                 </table>
             </div>
         </div>

         <div class="panel panel-info panel-line">
            <div class="panel-heading">
                <h3 class="panel-title">Leave Policy Settings</h3>
                <div class="panel-actions">

                </div>
            </div>
            <form id="leavePolicyForm" enctype="multipart/form-data">
                <div class="panel-body">
                    <div class="col-md-6">
                        @csrf
                        <div class="form-group">
                            <h4>Does your leave include weekends?</h4>
                            <input type="checkbox" name="includes_weekend" class="active-toggle bstoggle"
                            {{$lp->includes_weekend==1?'checked':''}} value="1">
                            <h4>Does your leave include holidays?</h4>
                            <input type="checkbox" name="includes_holiday" class="active-toggle bstoggle"
                            {{$lp->includes_holiday==1?'checked':''}} value="1">
                            <h4>Can employees apply for leave allowance?</h4>
                            <input type="checkbox" name="can_request_allowance" class="active-toggle bstoggle"
                                   {{$lp->can_request_allowance==1?'checked':''}} value="1">
                            <h4>Does your Leave Relieve Approve Requests?</h4>
                            <input type="checkbox" name="relieve_approves" class="active-toggle bstoggle"
                            {{$lp->relieve_approves==1?'checked':''}} value="1">
                            <h4>Do you carry leave over?</h4>
                            <input type="checkbox" name="uses_spillover" class="active-toggle bstoggle"
                            {{$lp->uses_spillover==1?'checked':''}} value="1">
                            <h4>Do you have a maximum number of days when carrying leave over?</h4>
                            <input type="checkbox" name="uses_maximum_spillover" class="active-toggle bstoggle"
                            {{$lp->uses_maximum_spillover==1?'checked':''}} value="1">
                            <h4>Does your probationers apply?</h4>
                            <input type="checkbox" name="probationer_applies" class="active-toggle bstoggle"  {{$lp->probationer_applies==1?'checked':''}} value="1">
                            <h4>Does your probationers use casual leave?</h4>
                            <input type="checkbox" name="uses_casual_leave" class="active-toggle bstoggle"  {{$lp->uses_casual_leave==1?'checked':''}} value="1">
                        </div>
                        <div class="form-group">
                            <h4>Default Leave Length</h4>
                            <input type="text" name="default_length" class="form-control"
                            value="{{$lp->default_length}}"><h4>What is your Casual Leave Length</h4>
                            <input type="text" name="casual_leave_length" class="form-control" value="{{$lp->casual_leave_length}}">
                            <h4>What is your Maximum Leave Carryover Length</h4>
                            <input type="text" name="spillover_length" class="form-control"
                            value="{{$lp->spillover_length}}">
                        </div>
                        <br>
                        <h4>Select Leave Carryover Deadline Date</h4>
                        <div class="form-inline">
                            <div class="form-group ">
                                <label class="form-control-label" for="inputInlineUsername">Month</label>
                                <select class="form-control" name="spillover_month">
                                    @for($i=1;$i<=12;$i++)
                                    <option value="{{$i}}" {{$i==$lp->spillover_month?'selected':''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group ">
                                <label class="form-control-label" for="inputInlineUsername">Day</label>
                                <select class="form-control" name="spillover_day">
                                    @for($i=1;$i<=31;$i++)
                                    <option value="{{$i}}" {{$i==$lp->spillover_day?'selected':''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <h4>Specific Salary Component Type</h4>
                            <select class="form-control" name="specific_salary_component_type_id">
                                @forelse($sscts as $ssct)
                                    <option value="{{$ssct->id}}" {{$lp->specific_salary_component_type_id==$ssct->id?'selected':''}}>{{$ssct->name}}</option>
                                @empty
                                    <option value="0">Please Create a Specific Salary Component for Leave</option>
                                @endforelse

                            </select>
                        </div>
                        <div class="form-group">
                            <h4>Approval Workflow</h4>
                            <select class="form-control" name="workflow_id">
                                @forelse($workflows as $workflow)
                                <option value="{{$workflow->id}}" {{$lp->workflow_id==$workflow->id?'selected':''}}>{{$workflow->name}}</option>
                                @empty
                                <option value="0">Please Create a Workflow</option>
                                @endforelse

                            </select>
                        </div>
                        <input type="hidden" name=" type" value="leave_policy">

                    </div>

                </div>
                <div class="panel-footer">
                    <div class="form-group">
                        <button class="btn btn-info">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="panel panel-info panel-line">
            <div class="panel-heading">
                <h3 class="panel-title">Holidays</h3>
                <div class="panel-actions">

                    <button class="btn btn-info" data-toggle="modal" data-target="#addHolidayModal">Add Holiday
                    </button>
                </div>
            </div>
            <div class="panel-body">

                <table id="exampleTablePagination" data-toggle="table"
                data-query-params="queryParams" data-mobile-responsive="true"
                data-height="400" data-pagination="true" data-search="true" class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 30%">Title:</th>
                        <th style="width: 25%">Date:</th>
                        <th style="width: 25%">Created By:</th>
                        <th style="width: 25%">Adjustment:</th>

                        <th style="width: 20%">Action:</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($holidays as $holiday)
                    <tr>
                        <td>{{$holiday->title}}</td>
                        <td>{{date("F j, Y",strtotime($holiday->date))}}</td>
                        <td>{{$holiday->user?$holiday->user->name:''}}</td>
                        <td><a title="Adjust Leave Requests" href="#" class="btn btn-info text-white" id="{{$holiday->id}}"
                            onclick="adjustHolidayLeaveRequests(this.id);">Adjust Leave Requests</a>
                        <td><a class="" title="edit" class="btn btn-info" id="{{$holiday->id}}"
                         onclick="prepareHEditData(this.id);"><i class="fa fa-pencil"
                         aria-hidden="true"></i></a>
                         <a class="" title="delete" class="btn btn-danger" id="{{$holiday->id}}"
                             onclick="deleteHoliday(this.id);"><i class="fa fa-trash" aria-hidden="true"></i></a>
                         </td>
                     </tr>
                     @empty
                     @endforelse

                 </tbody>
             </table>
         </div>
     </div>
 </div>
</div>
</div>

<div class="col-md-12 col-xs-12"></div>
@include('settings.leavesettings.modals.addleave')
{{-- edit holiday modal --}}
@include('settings.leavesettings.modals.editleave')
{{-- Add Grade Modal --}}
@include('settings.leavesettings.modals.addholiday')
{{-- edit holiday modal --}}
@include('settings.leavesettings.modals.editholiday')
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true
    });
    $('.bstoggle').bootstrapToggle({
        on: 'Yes',
        off: 'No',
        onstyle: 'info',
        offstyle: 'default'
    });
    $(document).on('submit', '#leavePolicyForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url: '{{route('leave_policy.store')}}',
            data: formdata ? formdata : form.serialize(),
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data, textStatus, jqXHR) {

                toastr.success("Changes saved successfully", 'Success');

            },
            error: function (data, textStatus, jqXHR) {
                jQuery.each(data['responseJSON'], function (i, val) {
                    jQuery.each(val, function (i, valchild) {
                        toastr.error(valchild[0]);
                    });
                });
            }
        });

    });

    $(document).on('submit', '#addLeaveForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url: '{{route('leaves.store')}}',
            data: formdata ? formdata : form.serialize(),
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data, textStatus, jqXHR) {

                toastr.success("Changes saved successfully", 'Success');
                $('#addLeaveModal').modal('toggle');
                // $( "#ldr" ).load('{{route('leavesettings')}}');
                location.reload();
            },
            error: function (data, textStatus, jqXHR) {
                jQuery.each(data['responseJSON'], function (i, val) {
                    jQuery.each(val, function (i, valchild) {
                        toastr.error(valchild[0]);
                    });
                });
            }
        });

    });
    $(document).on('submit', '#editLeaveForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url: '{{route('leaves.store')}}',
            data: formdata ? formdata : form.serialize(),
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data, textStatus, jqXHR) {

                toastr.success("Changes saved successfully", 'Success');
                $('#editLeaveModal').modal('toggle');
                {{-- $( "#ldr" ).load('{{route('leavesettings')}}'); --}}
                location.reload();
            },
            error: function (data, textStatus, jqXHR) {
                jQuery.each(data['responseJSON'], function (i, val) {
                    jQuery.each(val, function (i, valchild) {
                        toastr.error(valchild[0]);
                    });
                });
            }
        });

    });

    $(document).on('submit', '#addHolidayForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url: '{{route('holidays.store')}}',
            data: formdata ? formdata : form.serialize(),
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data, textStatus, jqXHR) {

                toastr.success("Changes saved successfully", 'Success');
                $('#addHolidayModal').modal('toggle');
                // $( "#ldr" ).load('{{route('leavesettings')}}');
                location.reload();
            },
            error: function (data, textStatus, jqXHR) {
                jQuery.each(data['responseJSON'], function (i, val) {
                    jQuery.each(val, function (i, valchild) {
                        toastr.error(valchild[0]);
                    });
                });
            }
        });

    });
    $(document).on('submit', '#editHolidayForm', function (event) {
        event.preventDefault();
        var form = $(this);
        var formdata = false;
        if (window.FormData) {
            formdata = new FormData(form[0]);
        }
        $.ajax({
            url: '{{route('holidays.store')}}',
            data: formdata ? formdata : form.serialize(),
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function (data, textStatus, jqXHR) {

                toastr.success("Changes saved successfully", 'Success');
                $('#editHolidayModal').modal('toggle');
                {{-- $( "#ldr" ).load('{{route('leavesettings')}}'); --}}
                location.reload();
            },
            error: function (data, textStatus, jqXHR) {
                jQuery.each(data['responseJSON'], function (i, val) {
                    jQuery.each(val, function (i, valchild) {
                        toastr.error(valchild[0]);
                    });
                });
            }
        });

    });

    function prepareLEditData(leave_id) {
        $.get('{{ url('/settings/leave') }}/' + leave_id, function (data) {
            console.log(data.date);
            $('#editlid').val(data.id);
            $('#editlname').val(data.name);
            $('#editllength').val(data.length);
            $('#editlmarital_status').val(data.marital_status);
            $('#editlgender').val(data.gender);
            $('#editlwith_pay').val(data.with_pay);
        });

        $('#editLeaveModal').modal();
    }

    function prepareHEditData(holiday_id) {
        $.get('{{ url('/settings/holiday') }}/' + holiday_id, function (data) {
            // console.log(data);
            $('#edithid').val(data.id);
            $('#edithdate').val(data.o_date);
            $('#edithtitle').val(data.title);
        });
        $('#editHolidayModal').modal();
    }

    function deleteLeave(leave_id) {
        alertify.confirm('Are you sure you want to delete this Leave?', function () {


            $.get('{{ url('/settings/leaves/delete') }}/' + leave_id, function (data) {
                if (data == 'success') {
                    toastr["success"]("Leave deleted successfully", 'Success');
                    // $( "#ldr" ).load('{{route('employeesettings')}}');
                    location.reload();
                } else {
                    toastr["error"]("Error deleting Leave", 'Success');
                }

            });
        }, function () {
            alertify.error('Leave not deleted');
        });

    }

    function deleteHoliday(holiday_id) {
        alertify.confirm('Are you sure you want to delete this Holiday?', function () {
            $.get('{{ url('/settings/holidays/delete') }}/' + holiday_id, function (data) {
                if (data == 'success') {
                    toastr["success"]("Holiday deleted successfully", 'Success');
                    // $( "#ldr" ).load('{{route('employeesettings')}}');
                    location.reload();
                } else {
                    toastr["error"]("Error deleting Holiday", 'Success');
                }
            });
        }, function () {
            alertify.error('Holiday not deleted');
        });
    }
    function adjustHolidayLeaveRequests(holiday_id){
        alertify.confirm('Are you sure you want to adjust the leave requests that contain this Holiday?', function () {
            $.get('{{ url('/settings/holidays/adjust_leave') }}/' + holiday_id, function (data) {
                if (data == 'success') {
                    toastr["success"]("Holiday adjusted successfully", 'Success');
                    // $( "#ldr" ).load('{{route('employeesettings')}}');
                    location.reload();
                } else {
                    toastr["error"]("Error adjusting Holiday", 'Success');
                }
            });
        }, function () {
            alertify.error('Holiday not adjusted');
        });

    }
</script>
