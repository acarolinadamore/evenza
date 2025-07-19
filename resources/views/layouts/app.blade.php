<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Evenza - Gestão de Eventos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Yesteryear&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primario: '#1a1a1a',
                        primario_escuro: '#000000',
                        secundario: '#333333',
                        acento: '#ad8741',
                        claro: '#f8f9fa',
                        escuro: '#212529',
                        cinza: '#6c757d'
                    },
                    fontFamily: {
                        'titulo': ['Yesteryear', 'cursive'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <x-menu />

    <main class="container mx-auto px-4 py-8">
        @if(session('sucesso'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span>{{ session('sucesso') }}</span>
                </div>
            </div>
        @endif

        @if(session('erro'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span>{{ session('erro') }}</span>
                </div>
            </div>
        @endif

        @yield('conteudo')
    </main>

    <script>
        docu