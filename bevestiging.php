<?Php
include 'connector.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            margin-top: 200px;
            font-family: Arial, sans-serif;
            background-image: url(back.jpeg);
        }
        .container {
            width: 600px;
            margin: 0 auto;
        }
        h1, p {
            text-align: center;
        }
        .message {
            background-color: #f1f1f1;
            opacity: 0.6;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        form {
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }
        input {
            background-color: #555555;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 12px
        }
        input:hover {
            background-color: #008CBA;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="message">
            <h1>Payment confirmed!</h1>
            <p>We have sent a confirmation email to <?php echo $_SESSION['email'] ?></p>
            <p>Have a nice flight!</p>
        </div>
        <form action="index.html">
            <input type="submit" value="Back home">
        </form>
    </div>
</body>
</html>