<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users pdf</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <style>

    </style>
</head>

<body>
    <div class=" text-center">
        <h2><u>{{$clocking_details[0]->name}} Clocking Report</u></h2>
    </div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr class="bg-primary">
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
</body>

</html>