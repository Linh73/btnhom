<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Login </title>

    <!-- Bootstrap core CSS -->
    <link href="/btnhom/public/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="/btnhom/public/assets/css/signin.css" rel="stylesheet">

  </head>
  <body class="text-center">
    
<main class="form-signin">
  <form method="post">
    <a href="home.php">    <!-- fix xong thi bo .php-->
      <img class="mb-4 rounded-circle shadow" src="/btnhom/public/assets/images/Gold_stupid.jpg" alt="" width="100" height="100" style= "object-fit: cover;">
    </a>
    <h1 class="h3 mb-3 fw-normal">Please login</h1>

    <div class="form-floating">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    
    <div class="my-2">Dont have an account? <a href="signup.php"> Signup here </a></div> <!-- xoa .php tai daykhi fix dc loi kia -->
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
  </form>
</main>


    
  </body>
</html>
