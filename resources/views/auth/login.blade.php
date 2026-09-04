<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión — Sistema Desgranadora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        html {
            overflow-x: hidden;
        }

        body {
            background: #f5edd3;
            color: #293322;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        body::before,
        body::after {
            content: '';
            position: absolute;
            width: 42vw;
            height: 42vw;
            min-width: 320px;
            min-height: 320px;
            border-radius: 50%;
            filter: blur(70px);
            opacity: .72;
            pointer-events: none;
        }

        body::before {
            background: #e8b923;
            top: -18vw;
            left: -10vw;
        }

        body::after {
            background: #6d9b55;
            right: -14vw;
            bottom: -20vw;
        }

        .login-card {
            position: relative;
            box-sizing: border-box;
            z-index: 1;
            background: rgba(255, 252, 241, .88);
            border-radius: 24px;
            padding: 2.75rem 2.4rem 2.2rem;
            width: 100%;
            max-width: 440px;
            border: 1px solid rgba(255, 255, 255, .82);
            box-shadow: 0 24px 70px rgba(63, 58, 25, .22),
                0 3px 12px rgba(83, 76, 31, .08);
            backdrop-filter: blur(18px);
            animation: cardIn .55s ease-out both;
        }

        .login-card::before {
            content: '';
            position: absolute;
            inset: 10px;
            border: 1px solid rgba(188, 146, 26, .16);
            border-radius: 17px;
            pointer-events: none;
        }

        .brand-icon {
            position: relative;
            width: 68px;
            height: 68px;
            border-radius: 20px 20px 20px 7px;
            background: #d9a817;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 10px 20px rgba(166, 119, 10, .24);
            transform: rotate(-3deg);
        }

        .brand-icon i {
            color: #fff9df;
            font-size: 31px;
            transform: rotate(3deg);
        }

        .login-card h5 {
            color: #35452c;
            letter-spacing: .01em;
        }

        .login-card .text-muted {
            color: #71735c !important;
        }

        .form-label {
            color: #4c553d;
        }

        .input-group-text {
            background: rgba(248, 243, 222, .9) !important;
            border-color: #ddd5b8;
        }

        .input-group .form-control,
        .input-group .btn {
            border-color: #ddd5b8;
        }

        .form-control {
            background: rgba(255, 255, 250, .82);
        }

        .form-control:focus {
            border-color: #c69a18;
            box-shadow: 0 0 0 3px rgba(213, 169, 25, .18);
        }

        .form-check-input:checked {
            background-color: #6d914d;
            border-color: #6d914d;
        }

        .btn-login {
            background: #4e713e;
            color: white;
            border: none;
            padding: .78rem 1rem;
            border-radius: 11px;
            font-weight: 600;
            letter-spacing: .01em;
            width: 100%;
            box-shadow: 0 9px 18px rgba(61, 94, 46, .2);
            transition: background .2s ease, transform .2s ease, box-shadow .2s ease;
        }

        .btn-login:hover {
            background: #3d5d31;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(61, 94, 46, .28);
        }

        .btn-outline-secondary {
            color: #647055;
        }

        .alert-danger {
            color: #7b3e2e;
            background: #fbe9dc;
            border-color: #edc8b4;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(14px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 480px) {
            .login-card {
                margin: 1rem;
                width: calc(100% - 2rem);
                padding: 2.25rem 1.45rem 1.8rem;
            }
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
            Instituto Técnico — Proyecto Desgranadora 2026
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