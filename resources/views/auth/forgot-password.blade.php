<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci minha senha - Evenza</title>
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
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="{{ route('site') }}" class="inline-flex items-center text-gray-900 text-4xl font-bold">
                <i class="fas fa-calendar-check mr-3"></i>
                Evenza
            </a>
            <p class="text-gray-600 mt-2">Gestão de Eventos</p>
        </div>

        <!-- Forgot Password Card -->
        <div class="bg-white rounded-lg shadow-xl p-8">
            <div class="text-center mb-6">
                <i class="fas fa-key text-4xl text-gray-400 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Esqueceu sua senha?</h2>
                <p class="text-sm text-gray-600">
                    Sem problemas! Informe seu email e enviaremos um link para redefinir sua senha.
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <div class="flex items-start">
                    <i class="fas fa-check-circle text-green-500 mr-3 mt-0.5"></i>
                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all">
                    @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-3 rounded-lg transition-colors flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Enviar link de recuperação
                </button>

                <!-- Back to Login -->
                <div class="text-center">
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-600 hover:text-gray-900 transition-colors inline-flex items-center">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Voltar para o login
                    </a>
                </div>
            </form>
        </div>

        <!-- Back to Site -->
        <div class="text-center mt-6">
            <a href="{{ route('site') }}" class="text-sm text-gray-600 hover:text-gray-900 transition-colors">
                <i class="fas fa-home mr-1"></i>
                Voltar para o site
            </a>
        </div>
    </div>
</body>
</html>
