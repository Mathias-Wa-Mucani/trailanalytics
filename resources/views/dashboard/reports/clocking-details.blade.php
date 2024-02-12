@if (count($clocking_details) > 0)
    <div class="table-responsive">
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
