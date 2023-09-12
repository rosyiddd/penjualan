    @extends('header')

    @section('content')
        <form id="regForm" style="width:30%;padding:50px" action="" method="POST">
            @csrf
            <h1>Login</h1>
            @isset($error)
                <p style="text-align:center;color:red">{{$error}}</p>
            @endisset
            <div class="tab" style="display:block">
                <p><input placeholder="Username .." name="username"></p>
                <p><input placeholder="Password..." name="password"></p>
            </div>
            <div style="display: flex;justify-content: center;">
                <button type="submit" style="border-radius:25%">Login</button>
            </div>
        </form>
    @endsection
  </body>
</html>
