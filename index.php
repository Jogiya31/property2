<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>AdminLTE 2 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"
        name="viewport" />
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" />
    <!-- Ionicons -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css" />
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css" />
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Welcome</b> user</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form id="loginForm" novalidate>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="email" placeholder="username" />
                    <span
                        class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        placeholder="Password" />
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <!-- <div class="checkbox icheck">
                            <label> <input type="checkbox" /> Remember Me </label>
                        </div> -->
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">
                            Sign In
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 2.2.3 -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
        document.getElementById("loginForm").addEventListener("submit", async (e) => {
            e.preventDefault();
            let form = new FormData(e.target);
            let data = Object.fromEntries(form);
            console.log('form', form)
            let res = await fetch("api/login.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(data)
            });
            let json = await res.json();

            if (json.success) {
                sessionStorage.setItem("uid", json.uid);
                sessionStorage.setItem("username", json.username);
                sessionStorage.setItem("email", json.email);
                sessionStorage.setItem("designation", json.designation);
                sessionStorage.setItem("state", json.state);
                sessionStorage.setItem("address", json.address);
                sessionStorage.setItem("empCode", json.empcode);
                sessionStorage.setItem("service", json.service);
                sessionStorage.setItem("payscale", json.payscale);
                setTimeout(() => {
                    if (json.designation === 'SO') {
                        location.href = "pages/submitted_form_list.php";
                    } else if (json.designation === 'DDG') {
                        location.href = "pages/submitted_form_list.php";
                    } else if (json.designation === 'JD') {
                        location.href = "pages/submitted_form_list.php";
                    } else {
                        location.href = "pages/dashboard.php";
                    }
                }, 800);
            } else {
                document.getElementById("msg").innerHTML =
                    `<div class='alert alert-danger'>${json.message}</div>`;
            }
        });
        (async function init() {
            sessionStorage.clear();
        })();
    </script>
</body>

</html>