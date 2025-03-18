<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leave Request</title>
</head>

<body>
    <h1>{{ $leaveDto->subjectName }}</h1>
    <p>
        I am writing to request leave from {{ $leaveDto->fromDate }} to {{ $leaveDto->fromDate }}
        @if (!empty($leaveDto->leaveOption))
            {
            for {{ $leaveDto->leaveOption == 'FULL' ? 'Full Day' : $leaveDto->leaveOption }}.
            }
        @endif
    </p>
</body>

</html>
