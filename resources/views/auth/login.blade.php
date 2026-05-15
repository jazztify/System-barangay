<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Barangay Information System</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            width: 100%;
            max-width: 400px;
            padding: 3rem 2.5rem;
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.5);
        }
        .login-logo {
            color: #fff;
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .login-logo i {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            color: #3b82f6;
        }
        .login-logo h2 {
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .form-label {
            color: #94a3b8;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #3b82f6;
            color: #fff;
            box-shadow: none;
        }
        .btn-login {
            background: #3b82f6;
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 0.75rem;
            margin-top: 1.5rem;
            transition: all 0.2s;
        }
        .btn-login:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }
        .alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border-radius: 0.75rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <i class='bx bxs-institution'></i>
            <h2>BARANGAY BIS</h2>
            <p class="text-slate-400 text-sm">Sign in to your account</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required autofocus>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-login w-100">Sign In</button>
        </form>
    </div>
</body>
</html>
