<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Maintenance</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .maintenance-container {
            text-align: center;
            background: white;
            padding: 60px 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 90%;
        }

        .maintenance-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            font-size: 36px;
            margin-bottom: 15px;
        }

        p {
            color: #666;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .status {
            display: inline-block;
            padding: 10px 20px;
            background: #f0f0f0;
            border-radius: 5px;
            color: #667eea;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            margin-top: 40px;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">🔧</div>
        <h1>Site Under Maintenance</h1>
        <p>We're currently performing scheduled maintenance to improve your experience. We'll be back online shortly.</p>
        <p>Thank you for your patience!</p>
        <div class="status">Expected Back: Soon</div>
        <div class="footer">
            <p>If you have urgent questions, please contact us at support@example.com</p>
        </div>
    </div>
</body>
</html>
