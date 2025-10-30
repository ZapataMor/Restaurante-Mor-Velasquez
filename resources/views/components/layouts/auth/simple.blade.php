<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')

    <style>
        .scale-up-center {
            animation: scale-up-center 1s ease-out both;
        }

        @keyframes scale-up-center {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .scale-up-center-delayed {
            animation: scale-up-center 1s ease-out 0.3s both;
        }

        /* Estilos para el botón de login */
        .btn-login {
            padding: 1rem 2rem;
            font-size: 1.2rem;
            font-weight: 600;
            text-transform: uppercase;
            background: transparent !important;
            color: #999 !important;
            border: 2px solid #ffffffff !important;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.5s;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: #ffffffff;
            z-index: -1;
            transition: 0.5s;
        }

        .btn-login:hover::before {
            width: 100%;
        }

        .btn-login:hover {
            color: #081b29 !important;
        }
    </style>
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">

    <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">

        <img src="{{ asset('images/entrada.jpg') }}" alt="Restaurante Mor Velasquez"
            class="absolute inset-0 w-full h-full object-cover -z-10 blur-sm opacity-800" />

        <div
            class="mb-20 mt-20 py-15 px-20 rounded-xl border-white/20 bg-white/30 dark:bg-zinc-900/30 backdrop-blur-md scale-up-center">
            <h1 class="text-5xl font-serif">Bienvenidos al restaurante Mor Velasquez</h1>
        </div>

        <div
            class="flex w-120 flex-col gap-2 rounded-xl border-white/20 bg-white/30 dark:bg-zinc-900/30 backdrop-blur-md scale-up-center-delayed">
            <div class="flex flex-col gap-6">
                {{ $slot }}
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>