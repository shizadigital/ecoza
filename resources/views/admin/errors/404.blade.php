<!DOCTYPE html>
<html lang="en">
<head>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/backend.css') }}" rel="stylesheet" type="text/css" />
</head>
<body class="page404">
    <div class="container">
      <div class="row text-center">
        <div class="col-lg-6 offset-lg-3 col-sm-6 offset-sm-3 col-12 p-3 error-main">
          <div class="row">
            <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">
              <h1 class="m-0">404</h1>
              <h3>Page not found - Cazher.com</h3>
              <p>Lorem ipsum dolor sit <span class="text-info">amet</span>, consectetur <span class="text-info">adipisicing</span> elit, sed do eiusmod.</p>
              <button class="btn btn-success btn-lg width-xl waves-effect waves-light mt-3" onclick="window.history.go(-1); return false;">Back</button>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>