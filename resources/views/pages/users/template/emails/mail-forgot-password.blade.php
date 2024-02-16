<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        Reset Password
    </title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        html,
        body {
            clear: both;
            box-sizing: border-box;
            content: '';
            font-family: 'Roboto', sans-serif;
        }

        .body-container {
            padding: 1rem;
        }

        .reset-btn {
            text-decoration: none;
            background-color: rgb(35, 110, 248);
            color: white !important;
            padding: 0.6rem 1rem 0.6rem 1rem;
            margin-top: 10px;
            width: 130px;
            text-align: center;
            border-radius: 3px;
        }

    </style>
</head>

<body>
    <div class="body-container">
        <div>
            <h1>
                Password Reset
            </h1>
            <p>
                We receive a request to reset password in your account.
            </p>
            <p>
                Click the button if you make this request
            </p>
        </div>
        <a class="reset-btn" href="{{ $verification_link }}">
            Reset password
        </a>
    </div>
</body>

</html>
