<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        p {
            font-size: 12px;
        }

        .signature {
            font-style: italic;
        }
    </style>
</head>
<body>
<div>
    <p>Hey!</p>
    <p>You have been invited to join the project team {{ $team->team_name }}! Click the link below to activate your team membership;</p>
    <p><a href="{{ $uri }}">Join team {{ $team->team_name }}</a></p>
    <p class="signature">Mailtrap</p>
</div>
</body>
</html>
