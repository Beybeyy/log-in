<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | DepEd Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            font-family: "Times New Roman", serif;
            background-color: #ffffff;
        }

        /* NAVBAR */
        .top-nav {
            background-color: #0b3c78;
            padding: 18px 0;
            text-align: center;
        }

        .top-nav a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 25px;
            font-size: 16px;
        }

        /* MAIN CONTAINER */
        .main-container {
            display: flex;
            justify-content: center;
            padding: 60px 0;
        }

        /* REGISTER CARD */
        .register-card {
            width: 520px;
            background-color: #0b3c78;
            border-radius: 8px;
            padding: 15px;
        }

        .register-header {
            color: #ffffff;
            text-align: center;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .register-body {
            background-color: #e0e0e0;
            border-radius: 5px;
            padding: 25px 30px 35px;
        }

        /* FORM GRID */
        .form-row {
            display: flex;
            gap: 30px;
            margin-bottom: 18px;
        }

        .form-group {
            flex: 1;
        }

        .form-group.full {
            flex: 100%;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 15px;
        }

        input {
            width: 100%;
            height: 34px;
            border-radius: 5px;
            border: none;
            padding: 5px 10px;
            font-size: 14px;
        }

        /* BUTTON */
        .btn-container {
            text-align: center;
            margin-top: 25px;
        }

        .btn-submit {
            background-color: #0f63b6;
            color: #ffffff;
            border: none;
            padding: 8px 70px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #0d56a0;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <div class="top-nav">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </div>

    <!-- MAIN -->
    <div class="main-container">
        <div class="register-card">

            <div class="register-header">
                Register your DepEd Account
            </div>

            <div class="register-body">
                <form method="POST" action="#">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name">
                        </div>
                        <div class="form-group">
                            <label>Middle Name</label>
                            <input type="text" name="middle_name">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name">
                        </div>
                        <div class="form-group">
                            <label>Suffix</label>
                            <input type="text" name="suffix">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group full">
                            <label>Name of School and Address</label>
                            <input type="text" name="school">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group full">
                            <label>DepEd Email</label>
                            <input type="email" name="email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation">
                        </div>
                    </div>

                    <div class="btn-container">
                        <button type="submit" class="btn-submit">Login</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

</body>
</html>
