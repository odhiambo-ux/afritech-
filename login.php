<?php
session_start();
include 'config/database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $error = "Please enter your email and password.";
    } else {

        $sql = "SELECT id, full_name, email, password
                FROM users
                WHERE email = ?
                LIMIT 1";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($user = mysqli_fetch_assoc($result)) {

                if (password_verify($password, $user["password"])) {

                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["full_name"] = $user["full_name"];
                    $_SESSION["email"] = $user["email"];

                    header("Location: shop.php");
                    exit();

                } else {
                    $error = "Incorrect password.";
                }

            } else {
                $error = "No account was found with that email address.";
            }

            mysqli_stmt_close($stmt);

        } else {
            $error = "Something went wrong. Please try again.";
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login - AfriTech</title>

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

    font-family:
    system-ui,
    -apple-system,
    Segoe UI,
    Roboto,
    Arial,
    sans-serif;
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

/* =========================
   CONTAINER
========================= */

.container{
    max-width:1200px;
    margin:auto;
    padding:0 20px;
}

/* =========================
   NAVIGATION
========================= */

.topbar{
    background:#fff;
    border-bottom:1px solid var(--line);
}

.nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 0;
    gap:20px;
}

.brand img{
    height:52px;
    width:auto;
}

.menu{
    display:flex;
    gap:25px;
    align-items:center;
}

.menu a{
    font-weight:800;
    font-size:17px;
}

.menu a:hover{
    color:var(--magenta);
}

.actions{
    display:flex;
    align-items:center;
}

/* =========================
   BUTTONS
========================= */

.btn{
    padding:12px 20px;
    border-radius:14px;
    font-weight:900;
    border:none;
    cursor:pointer;

    display:inline-flex;
    align-items:center;
    justify-content:center;
}

.btn.primary{
    background:var(--magenta);
    color:white;
}

.btn.primary:hover{
    opacity:.92;
}

.btn.outline{
    background:white;
    border:1px solid var(--line);
}

.btn.full{
    width:100%;
}

/* =========================
   LOGIN AREA
========================= */

.loginSection{
    min-height:calc(100vh - 82px);

    display:flex;
    justify-content:center;
    align-items:flex-start;

    padding:55px 20px 80px;
}

.loginCard{
    width:100%;
    max-width:520px;

    background:white;

    border:1px solid var(--line);
    border-radius:20px;

    box-shadow:var(--shadow);

    padding:32px;
}

.loginTitle{
    text-align:center;
    margin:0 0 8px;

    font-size:30px;
    font-weight:950;
}

.loginSubtitle{
    text-align:center;

    color:var(--muted);

    margin:0 0 28px;

    font-size:15px;
}

/* =========================
   FORM
========================= */

.field{
    margin-bottom:18px;
}

label{
    display:block;

    font-weight:900;

    margin-bottom:8px;

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

    padding:14px 48px 14px 15px;

    font-size:15px;

    font-weight:650;

    outline:none;

    transition:.15s;
}

input:focus{
    border-color:rgba(230,0,126,.45);

    box-shadow:
    0 0 0 4px rgba(230,0,126,.12);
}

input::placeholder{
    color:#98A2B3;
}

/* =========================
   PASSWORD BUTTON
========================= */

.showPw{
    position:absolute;

    right:10px;
    top:50%;

    transform:translateY(-50%);

    border:1px solid var(--line);

    background:white;

    border-radius:10px;

    width:38px;
    height:36px;

    cursor:pointer;

    font-size:17px;
}

.showPw:hover{
    border-color:#cfd4dc;
}

/* =========================
   ERROR
========================= */

.errorBox{
    margin:12px 0;

    padding:12px 14px;

    border-radius:12px;

    background:#fff1f7;

    border:1px solid rgba(230,0,126,.25);

    color:#a00050;

    font-weight:700;

    font-size:14px;
}

/* =========================
   EXTRA LINKS
========================= */

.metaRow{
    display:flex;

    justify-content:space-between;

    align-items:center;

    gap:10px;

    margin:4px 0 20px;
}

.link{
    color:var(--magenta);

    font-weight:900;

    font-size:14px;
}

.link:hover{
    text-decoration:underline;
}

.divider{
    height:1px;

    background:var(--line);

    margin:22px 0;
}

.registerText{
    text-align:center;

    font-size:15px;

    color:var(--muted);
}

.registerText a{
    color:var(--magenta);

    font-weight:900;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:700px){

    .menu{
        gap:12px;
    }

    .menu a{
        font-size:14px;
    }

    .brand img{
        height:42px;
    }

    .loginSection{
        padding-top:30px;
    }

    .loginCard{
        padding:24px 20px;
    }

    .loginTitle{
        font-size:26px;
    }
}

</style>

</head>

<body>

<!-- =========================
     NAVIGATION
========================= -->

<div class="topbar">

    <div class="container nav">

        <a class="brand" href="index.php">
            <img src="logo.png" alt="AfriTech">
        </a>

        <div class="menu">

            <a href="index.php">
                Home
            </a>

            <a href="shop.php">
                🛒 Shop
            </a>

            <a href="contact.php">
                Contact
            </a>

        </div>

        <div class="actions">

            <a class="btn outline" href="register.php">
                Create Account
            </a>

        </div>

    </div>

</div>


<!-- =========================
     LOGIN
========================= -->

<section class="loginSection">

    <div class="loginCard">

        <h1 class="loginTitle">
            Welcome Back
        </h1>

        <p class="loginSubtitle">
            Sign in to your AfriTech account to continue shopping.
        </p>


        <?php if ($error !== ""): ?>

            <div class="errorBox">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form
            id="loginForm"
            action="login.php"
            method="POST"
        >

            <!-- EMAIL -->

            <div class="field">

                <label for="username">
                    Email Address
                </label>

                <div class="inputWrap">

                    <input
                        type="email"
                        id="username"
                        name="username"
                        autocomplete="email"
                        placeholder="Enter your email address"
                        value="<?php echo htmlspecialchars($_POST["username"] ?? ""); ?>"
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
                        autocomplete="current-password"
                        placeholder="Enter your password"
                        required
                    >

                    <button
                        class="showPw"
                        type="button"
                        id="togglePassword"
                        aria-label="Show password"
                    >
                        👁️
                    </button>

                </div>

            </div>


            <!-- LINKS -->

            <div class="metaRow">

                <a
                    class="link"
                    href="contact.php"
                >
                    Forgot password?
                </a>

                <a
                    class="link"
                    href="register.php"
                >
                    Create account
                </a>

            </div>


            <!-- LOGIN BUTTON -->

            <button
                class="btn primary full"
                type="submit"
            >
                Login
            </button>

        </form>


        <div class="divider"></div>


        <div class="registerText">

            Don't have an account?

            <a href="register.php">
                Create one
            </a>

        </div>

    </div>

</section>


<script>

/* =========================
   SHOW / HIDE PASSWORD
========================= */

const togglePassword =
    document.getElementById("togglePassword");

const password =
    document.getElementById("password");

togglePassword.addEventListener("click", function(){

    if(password.type === "password"){

        password.type = "text";

        togglePassword.textContent = "🙈";

        togglePassword.setAttribute(
            "aria-label",
            "Hide password"
        );

    }else{

        password.type = "password";

        togglePassword.textContent = "👁️";

        togglePassword.setAttribute(
            "aria-label",
            "Show password"
        );

    }

});

</script>

</body>

</html>