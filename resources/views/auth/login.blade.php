<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — Sistema Desgranadora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f4f8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 420px;
            border: 0.5px solid #dee2e6;
        }

        .brand-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .brand-icon i {
            color: white;
            font-size: 28px;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .15);
        }

        .btn-login {
            background: #0d6efd;
            color: white;
            border: none;
            padding: .65rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            width: 100%;
            transition: background .15s;
        }

        .btn-login:hover {
            background: #0b5ed7;
            color: white;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="brand-icon">
            <i class="bi bi-gear-wide-connected"></i>
        </div>
        <h5 class="text-center fw-semibold mb-1">Sistema Desgranadora</h5>
        <p class="text-center text-muted small mb-4">Ingresa tus credenciales para continuar</p>

        @if($errors->any())
        <div class="alert alert-danger py-2 small">
            <i class="bi bi-exclamation-circle me-1"></i>
            {{ $errors->first() }}
        </div>
        @endif

        @if(session('status'))
        <div class="alert alert-success py-2 small">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label small fw-medium">Correo electrónico</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-envelope text-muted"></i>
                    </span>
                    <input type="email"
                        name="email"
                        autocomplete="off"
                        class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="usuario@ejemplo.com"
                        required autofocus>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-medium">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-lock text-muted"></i>
                    </span>
                    <input type="password"
                        name="password"
                        autocomplete="off"
                        class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required>
                    <button class="btn btn-outline-secondary" type="button"
                        onclick="togglePass(this)" tabindex="-1">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small" for="remember">Recordarme</label>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar al sistema
            </button>
        </form>

        <p class="text-center text-muted small mt-4 mb-0">
            Instituto Técnico — Proyecto Desgranadora 2024
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePass(btn) {
            const input = btn.closest('.input-group').querySelector('input[type=password], input[type=text]');
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>
</body>

</html>