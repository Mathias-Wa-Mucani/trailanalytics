@if (count($clocking_details) > 0)
<div class="">
    <a target="_blank" href="{{route('export-user-report-pdf', $clocking_details[0]->user_id)}}" class="btn btn-primary btn-sm float-end fa fa-file-pdf ">Export to PDF</a>
</div><br><br>
<div class="table-responsive">
    <input type="hidden" value="{{$clocking_details[0]->user_id}}">
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr class="bg-secondary">
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