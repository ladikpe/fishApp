@extends('layouts.master')
@section('stylesheets')
 <link rel="stylesheet" href="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css')}}"> 
 <link rel="stylesheet" href="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.css') }}">

 <style>
     .td-left
     {
        width: 30%; padding: 10px 2%!important; text-align: right;
     }
     
     .td-right
     {
        width: 70%; padding: 10px 2%!important; text-align: left;
     }
 </style>
@endsection

@section('content')
<!-- Page -->
  <div class="page ">
    <div class="page-header">
      <h1 class="page-title">{{__('Delegate Approvals - Leave')}}</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">{{__('Home')}}</a></li>
        <li class="breadcrumb-item active">{{__('Delegate Approvals - Leave')}}</li>
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
        <div class="row" data-plugin="matchHeight" data-by-row="true">
  <!-- First Row -->
  
  
  <!-- End First Row -->
  {{-- second row --}}

  {{-- //CHECK IF THE APPROVAL IS IN THE SAME STAGE AS THE DELEGATED APPROVAL --}}
  @if($delegate->delegate_id == \Auth::user()->id && $delegate->has_approved == 0)
  <div class="col-ms-12 col-xs-12 col-md-12">
    <div class="panel panel-info panel-line">
      <div class="panel-heading" style="width: 70%; margin: auto;">
        <h3 class="panel-title text-align: center"> Delegated Approvals 
            {{-- <a data-id="{{ $delegate_approval->leave_request->id }}" style="cursor:pointer;"class="view-approval" id="{{$delegate_approval->leave_request->id}}" onclick="viewRequestApproval(this.id)"><i class="fa fa-eye" aria-hidden="true"></i>&nbsp;View Approval</a> --}}
            {{-- @if($user->id == $delegate_approval->delegate_id) --}}
            <button type="button" style="cursor:pointer;" class="btn btn-primary pull-right" id="{{$delegate_approval->id}}" onclick="setLeaveRequestId(this.id)" data-toggle="modal" data-target="#approveLeaveRequestModal"><i class="fa fa-eye" aria-hidden="true"></i> Action</button>
            {{-- @endif --}}
        </h3>        
      </div>

      <div class="panel-body">
        <div class="table-reponsive">

            <table class="table-striped table-sm" style="width: 70%; margin: auto; border-color: #ddd" border="1">
                <tbody>
                    <tr>
                        <td class="td-left"> Employee </td>
                        <td class="td-right">{{$delegate_approval->user?$delegate_approval->user->name:''}}</td>
                    </tr>
                    <tr>
                        <td class="td-left"> Reliever </td>
                        <td class="td-right">{{$delegate_approval->replacement?$delegate_approval->replacement->name:''}}</td>
                    </tr>
                    <tr>
                        <td class="td-left"> Start Date </td>
                        <td class="td-right">{{date('M, j Y', strtotime($delegate_approval->start_date))}}</td>
                    </tr>
                    <tr>
                        <td class="td-left"> End Date </td>
                        <td class="td-right">{{date('M, j Y', strtotime($delegate_approval->end_date))}}</td>
                    </tr>
                    <tr>
                        <td class="td-left"> Purpose </td>
                        <td class="td-right">{{$delegate_approval->reason}}</td>
                    </tr>
                    <tr>
                        <td class="td-left"> No of Days </td>
                        <td class="td-right">{{$delegate_approval->lenght}} day(s)</td>
                    </tr>
                    <tr>
                        <td class="td-left"> Stage </td>
                        <td class="td-right">{{$controllerName->getDelegateApprovalStatus($delegate_approval->id)}}</td>
                    </tr>
                    <tr>
                        <td class="td-left"> Comment </td>
                        <td class="td-right">{{$delegate_approval->relieve_comment}}</td>
                    </tr>
                </tbody>
            </table>

         </div> 
                  
        </div>
      </div>

    </div>
    
  </div>
  @else
  <div class="panel-heading" style="width: 20%; margin: auto;">
    <h3 class="panel-title text-align: center; text-info"> No Approval Found </h3>
  </div>
  @endif
</div>
</div>





<div class="modal fade in modal-3d-flip-horizontal modal-info" id="approveLeaveRequestModal" role="dialog" tabindex="-1">
    <div class="modal-dialog ">
      <form class="form-horizontal" id="approveLeaveRequestForm" enctype="multipart/form-data">
        <div class="modal-content">        
        <div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="training_title">Approve Leave Request</h4>
        </div>
        <div class="modal-body">             	
        
        @csrf
       
      <div class="form-group">
        <label for="">Approve / Reject</label>
        <select class="form-control" id="approval" name="approval"  data-allow-clear="true">
         
          <option value="1">Approve</option>
          <option value="2">Reject</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="">Comment</label>
        <textarea class="form-control" id="comment" name="comment" style="height: 100px;resize: none;" placeholder="Comment" ></textarea>
      </div>
      <input type="hidden" name="type" value="save_approval">
      <input type="hidden" name="delegate" id="delegate" value="true">
      <input type="hidden" name="stage_id" id="stage_id" value="{{$controllerName->getDelegateApprovalStageId($delegate_approval->id)}}">
      <input type="hidden" name="leave_approval_id" id="approval_id" >
      
        </div>
        <div class="modal-footer">
          <div class="col-xs-12">
          
              <div class="form-group">
                
                <button type="submit" class="btn btn-info pull-left">Submit</button>
                <button type="button" class="btn btn-cancel" data-dismiss="modal">Cancel</button>
              </div>
              <!-- End Example Textarea -->
            </div>
         </div>
       </div>
      </form>
    </div>
  </div>








@endsection
@section('scripts')

  <script src="{{asset('global/vendor/bootstrap-table/bootstrap-table.min.js')}}"></script>
  <script src="{{asset('global/vendor/bootstrap-table/extensions/mobile/bootstrap-table-mobile.js')}}"></script>
  <script src="{{ asset('global/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{ asset('global/vendor/datatables/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('global/vendor/datatables-fixedheader/dataTables.fixedHeader.js') }}"></script>
  <script src="{{ asset('global/vendor/datatables-bootstrap/dataTables.bootstrap.js') }}"></script>
          
  <script type="text/javascript">


    $(function () 
    {
        $('#approval').on('change', function () 
        {
            type = $(this).val();

            if (type == 1) {

                $('#comment').attr('required', false);

            }
            if (type == 2) {
                $('#comment').attr('required', true);
            }
        });

        $(document).on('submit', '#approveLeaveRequestForm', function (event) 
        {
            event.preventDefault();
            var form = $(this);
            var formdata = false;
            if (window.FormData) 
            {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                url: '{{route('leave.store')}}',
                data: formdata ? formdata : form.serialize(),
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (data, textStatus, jqXHR) {

                    if (data == 'success') 
                    {
                        toastr.success("Changes saved successfully", 'Success');
                        $('#approveLeaveRequestModal').modal('toggle');
                        location.reload();
                    } else 
                    {
                        toastr.error(data);
                    }

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
    });

    function setLeaveRequestId(leave_approval_id) 
    {
        $(document).ready(function () {
            $('#approval_id').val(leave_approval_id);
        });
    }
    function viewRequestApproval(leave_request_id)
  {
     $(document).ready(function() {
        $("#detailLoader").load('{{ url('/leave/getdetails') }}?leave_request_id='+leave_request_id);
      $('#leaveDetailsModal').modal();
    });

  }

  window.viewRequestApproval = viewRequestApproval;  //Export to global windows object.


</script>

  </script>
@endsection