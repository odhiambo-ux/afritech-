<?php
session_start();
include 'config/database.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check empty fields
    if ($full_name == "" || $email == "" || $password == "" || $confirm_password == "") {
        $error = "Please fill in all fields.";
    }

    // Check email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    }

    // Check password length
    elseif (strlen($password) < 6) {
        $error = "Password must contain at least 6 characters.";
    }

    // Check passwords match
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    }

    else {

        // Check if email already exists
        $check_sql = "SELECT id FROM users WHERE email = ?";

        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "s", $email);
        mysqli_stmt_execute($check_stmt);

        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {

            $error = "An account with this email already exists.";

        } else {

            // Securely hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $sql = "INSERT INTO users (full_name, email, password)
                    VALUES (?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $full_name,
                $email,
                $hashed_password
            );

            if (mysqli_stmt_execute($stmt)) {

                $success = "Account created successfully!";

                // Redirect to login after 1 second
                header("refresh:1;url=login.php");

            } else {

                $error = "Something went wrong. Please try again.";
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_stmt_close($check_stmt);
    }
}
?>

<!doctype html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Create Account - AfriTech</title>

<style>

:root{
  --magenta:#E6007E;
  --cyan:#55B7E3;
  --yellow:#F2D200;
  --ink:#1A1A1A;
  --bg:#F6F8FB;
  --white:#fff;
  --line:#E4E7EC;
  --muted:#667085;
  --shadow:0 10px 30px rgba(0,0,0,.08);
  --radius:16px;

  font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
}

*{
  box-sizing:border-box;
}

body{
  margin:0;
  background:var(--bg);
  color:var(--ink);
}

a{
  text-decoration:none;
  color:inherit;
}

.container{
  max-width:1200px;
  margin:auto;
  padding:0 20px;
}

/* NAV */

.topbar{
  background:#fff;
  border-bottom:1px solid var(--line);
  position:sticky;
  top:0;
  z-index:100;
}

.nav{
  display:flex;
  justify-content:space-between;
  align-items:center;
  padding:14px 0;
  gap:18px;
}

.brand img{
  height:40px;
}

.menu{
  display:flex;
  gap:18px;
  align-items:center;
  flex-wrap:wrap;
}

.menu a{
  font-weight:650;
}

.menu a:hover{
  color:var(--magenta);
}

.actions{
  display:flex;
  gap:10px;
  align-items:center;
}

/* BUTTONS */

.btn{
  padding:12px 16px;
  border-radius:14px;
  font-weight:900;
  border:none;
  cursor:pointer;

  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:10px;
}

.btn.primary{
  background:var(--magenta);
  color:#fff;
}

.btn.primary:hover{
  opacity:.92;
}

.btn.outline{
  background:#fff;
  border:1px solid var(--line);
}

.btn.outline:hover{
  border-color:#cfd4dc;
}

.btn.full{
  width:100%;
}

/* PAGE */

.page{
  min-height:calc(100vh - 70px);
  padding:26px 0 50px;
}

.card{
  background:#fff;
  border:1px solid var(--line);
  border-radius:var(--radius);
  box-shadow:var(--shadow);
}

.registerCard{
  width:100%;
  max-width:600px;
  margin:auto;
}

.pad{
  padding:30px;
}

.field{
  margin-bottom:20px;
}

label{
  display:block;
  font-weight:900;
  margin-bottom:9px;
  font-size:15px;
}

.inputWrap{
  position:relative;
}

input{
  width:100%;
  border:1px solid var(--line);
  border-radius:14px;
  background:#fff;
  padding:14px 16px;
  font-size:16px;
  font-weight:700;
  outline:none;

  transition:border-color .15s, box-shadow .15s;
}

input:focus{
  border-color:rgba(230,0,126,.45);

  box-shadow:
    0 0 0 4px rgba(230,0,126,.12);
}

input[type="password"]{
  padding-right:55px;
}

/* PASSWORD BUTTON */

.showPw{
  position:absolute;
  right:10px;
  top:50%;
  transform:translateY(-50%);

  border:1px solid var(--line);
  background:#fff;

  border-radius:12px;
  padding:8px 10px;

  cursor:pointer;
  font-weight:900;
}

.showPw:hover{
  border-color:#cfd4dc;
}

/* HELPER */

.helper{
  margin-top:7px;
  color:var(--muted);
  font-size:13px;
  line-height:1.45;
}

/* ALERTS */

.errorBox{
  margin-bottom:18px;
  padding:13px 15px;

  border-radius:14px;

  border:1px solid rgba(230,0,126,.28);
  background:rgba(230,0,126,.06);

  color:#3b0a22;
  font-weight:800;
}

.successBox{
  margin-bottom:18px;
  padding:13px 15px;

  border-radius:14px;

  border:1px solid #b7e4c7;
  background:#ecfdf3;

  color:#166534;
  font-weight:800;
}

.hr{
  height:1px;
  background:var(--line);
  margin:20px 0;
}

.loginText{
  text-align:center;
  margin-top:20px;
  font-size:16px;
}

.loginText a{
  color:var(--magenta);
  font-weight:900;
}

.loginText a:hover{
  text-decoration:underline;
}

h1{
  margin:0 0 8px;
  font-size:30px;
}

.subtitle{
  color:var(--muted);
  margin:0 0 25px;
  line-height:1.5;
}

/* MOBILE */

@media(max-width:700px){

  .menu{
    display:none;
  }

  .registerCard{
    max-width:100%;
  }

  .pad{
    padding:22px;
  }

}

</style>

</head>

<body>

<!-- NAV -->

<div class="topbar">

  <div class="container nav">

    <a class="brand" href="index.php">
      <img src="logo.png" alt="AfriTech">
    </a>

    <div class="menu">

      <a href="index.php">Home</a>

      <a href="shop.php">🛒 Shop</a>

      <a href="contact.php">Contact</a>

    </div>

    <div class="actions">

      <a class="btn outline" href="login.php">
        Login
      </a>

    </div>

  </div>

</div>


<!-- PAGE -->

<section class="page">

  <div class="container">

    <div class="registerCard card">

      <div class="pad">

        <h1>Create Account</h1>

        <p class="subtitle">
          Create your AfriTech account to make ordering easier
          and access B2B pricing and checkout.
        </p>


        <?php if ($error != ""): ?>

          <div class="errorBox">
            <?php echo htmlspecialchars($error); ?>
          </div>

        <?php endif; ?>


        <?php if ($success != ""): ?>

          <div class="successBox">
            <?php echo htmlspecialchars($success); ?>
          </div>

        <?php endif; ?>


        <form method="POST" action="register.php">

          <!-- FULL NAME -->

          <div class="field">

            <label for="full_name">
              Full Name
            </label>

            <div class="inputWrap">

              <input
                type="text"
                id="full_name"
                name="full_name"
                placeholder="Enter your full name"
                value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>"
                required
              >

            </div>

          </div>


          <!-- EMAIL -->

          <div class="field">

            <label for="email">
              Email Address
            </label>

            <div class="inputWrap">

              <input
                type="email"
                id="email"
                name="email"
                placeholder="Enter your email address"
                value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                required
              >

            </div>

          </div>


          <!-- PASSWORD -->

          <div class="field">

            <label for="password">
              Password
            </label>

            <div class="inputWrap">

              <input
                type="password"
                id="password"
                name="password"
                placeholder="Enter your password"
                required
              >

              <button
                class="showPw"
                type="button"
                id="togglePassword"
              >
                👁️
              </button>

            </div>

            <div class="helper">
              Password must contain at least 6 characters.
            </div>

          </div>


          <!-- CONFIRM PASSWORD -->

          <div class="field">

            <label for="confirm_password">
              Confirm Password
            </label>

            <div class="inputWrap">

              <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Confirm your password"
                required
              >

            </div>

          </div>


          <div class="hr"></div>


          <button
            class="btn primary full"
            type="submit"
          >
            Create Account
          </button>


        </form>


        <div class="loginText">

          Already have an account?

          <a href="login.php">
            Login
          </a>

        </div>

      </div>

    </div>

  </div>

</section>


<script>

const password =
  document.getElementById("password");

const toggle =
  document.getElementById("togglePassword");

toggle.addEventListener("click", function(){

  if(password.type === "password"){

    password.type = "text";

    toggle.textContent = "🙈";

  }else{

    password.type = "password";

    toggle.textContent = "👁️";

  }

});

</script>

</body>

</html>