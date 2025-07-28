<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 200px;
        }

        .password-notify {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #4682b4;
            margin-bottom: 15px;
        }

        .body-content {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }

        .password-box {
            background-color: #f2f2f2;
            padding: 15px;
            font-size: 18px;
            color: #333;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
            border-radius: 6px;
        }

        .cta-button {
            display: block;
            width: 100%;
            background-color: #1a73e8;
            color: #ffffff;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 16px;
        }

        .footer {
            font-size: 12px;
            color: #999;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('assets/img/cloud-crm-logo.png'.Config::get('app.assets_version')) }}" alt="Company Logo">
        </div>

        <!-- Password generation notification -->
        <div class="password-notify">
            New Password Generated
        </div>

        <!-- Body content -->
        <div class="body-content">
            <p>Hi {{$username}}</p>
            <p>Below is your temporary password:</p>

            <div class="password-box">
                {{$password}}
            </div>

            <p>Please log in using this password, and be sure to change it to something more secure after your first login.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 CloudCrm. All Rights Reserved.</p>
        </div>
    </div>
</body>


</html>