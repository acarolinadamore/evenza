<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Evenza - Gestão de Eventos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Yesteryear&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBXnN8KxWvYqWq9hZqPjN5jZqWq9hZqPjN&libraries=places" async defer></script>
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

    <!-- Toast Container -->
    <div x-data="{ show: false, message: '', type: '' }"
         x-init="
            @if(session('sucesso'))
                message = '{{ session('sucesso') }}';
                type = 'success';
                show = true;
                setTimeout(() => show = false, 4000);
            @elseif(session('erro'))
                message = '{{ session('erro') }}';
                type = 'error';
                show = true;
                setTimeout(() => show = false, 4000);
            @endif
         "
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-4 right-4 z-50 max-w-sm w-full"
         style="display: none;">
        <div class="rounded-lg shadow-lg overflow-hidden"
             :class="{
                'bg-green-50 border-l-4 border-green-500': type === 'success',
                'bg-red-50 border-l-4 border-red-500': type === 'error'
             }">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas text-lg"
                           :class="{
                               'fa-check-circle text-green-500': type === 'success',
                               'fa-exclamation-circle text-red-500': type === 'error'
                           }"></i>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium"
                           :class="{
                               'text-green-900': type === 'success',
                               'text-red-900': type === 'error'
                           }"
                           x-text="message"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="inline-flex rounded-md focus:outline-none focus:ring-2"
                                :class="{
                                    'text-green-500 hover:text-green-600': type === 'success',
                                    'text-red-500 hover:text-red-600': type === 'error'
                                }">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8">
        @yield('conteudo')
    </main>

    <script>
        document.getElementById('menu-mobile')?.addEventListener('click', function() {
            const menuConteudo = document.getElementById('menu-mobile-conteudo');
            menuConteudo.classList.toggle('hidden');
        });
    </script>
</body>
</html>