<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .welcome-box {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .welcome-heading {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .welcome-message {
            font-size: 18px;
        }

        .button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="welcome-box">
        <h1 class="welcome-heading">Chào mừng bạn đã đăng nhập vào BoLeTo!</h1>
        <p class="welcome-message">Xin chào, {{$name}}! Chúc bạn một ngày tốt lành.</p>
        <button class="button">Vào Trang web..!</button>
    </div>
</body>
</html>