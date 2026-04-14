<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Arafah App</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        body {
            background: linear-gradient(145deg, #f0f4f8 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            margin: 0;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-card {
            background: #ffffff;
            border: none;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
            padding: 40px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-header .icon-box {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            color: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 15px;
            box-shadow: 0 10px 20px rgba(25, 118, 210, 0.3);
        }

        .login-header h4 {
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: -0.5px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 8px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: color 0.3s;
        }

        .form-control-custom {
            width: 100%;
            padding: 14px 15px 14px 45px;
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            background: #fff;
            border-color: #1976d2;
            outline: none;
            box-shadow: 0 0 0 4px rgba(25, 118, 210, 0.1);
        }

        .form-control-custom:focus + i {
            color: #1976d2;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 10px;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.2);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(25, 118, 210, 0.3);
            filter: brightness(1.1);
        }

        .error-msg {
            background: #fff1f0;
            border: 1px solid #ffa39e;
            color: #cf1322;
            padding: 12px;
            border-radius: 10px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="login-container animate__animated animate__fadeIn">
    <div class="login-card">
        <div class="login-header">
            <div class="icon-box">
                <i class="fas fa-clinic-medical"></i>
            </div>
            <h4>Arafah App</h4>
            <p class="text-muted small">Rumah Sakit Management System</p>
        </div>

        @if(session('error'))
            <div class="error-msg">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group-custom">
                    <input type="email" name="email" class="form-control-custom" placeholder="nama@email.com" required autofocus>
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group-custom">
                    <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <button type="submit" class="btn-login">
                MASUK SEKARANG <i class="fas fa-arrow-right ms-2"></i>
            </button>
        </form>

        <div class="mt-5 text-center">
            <p class="text-muted" style="font-size: 0.75rem;">
                &copy; 2026 Rumah Sakit Arafah. <br> 
                Professional Health Care Management.
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>