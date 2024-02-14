@if (count($clocking_details) > 0)
<div class="">
    @if($clocking_details[0]->user_id != null)
    <a href="" class="btn btn-primary btn-sm float-end fa fa-file-pdf ">Export to PDF</a>
    @endif
</div><br><br>
<div class="table-responsive">
    <input type="text" value="{{$clocking_details[0]->user_id}}">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time In</th>
                <th>Time Out</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clocking_details as $details)
            <tr>
                <td>{{ date('D, d/M/y ', strtotime($details->created_at)) }}</td>
                <td>{{ date('H:i:s', strtotime($details->time_in)) }} Hrs</td>
                <td>{{ $details->time_out != '' ? date('H:i:s', strtotime($details->time_out)) . 'Hrs' : '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<span class="text-center text-warning">No Clocking Logs found!!</span>
@endif