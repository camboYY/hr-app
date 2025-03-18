<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leave Confirmation</title>
</head>

<body>
    <h1>{{ $leaveDto->subjectName }}</h1>
    <p>
        Your requested leave has been {{ $leaveDto->leaveStatus }}.
    </p>
</body>

</html>
