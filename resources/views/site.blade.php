<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evenza - Gestão de Eventos</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        escuro: '#212529'
                    }
                }
            }
        }
    </script>
    <style>
        .hero-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        
        .hero-overlay {
            background: linear-gradient(135deg, rgba(10, 10, 10, 0.8) 0%, rgba(1, 1, 15, 0.5) 100%);
        }
        
        .scroll-smooth {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="scroll-smooth">
    <nav class="bg-gray-900 bg-opacity-90 backdrop-blur-sm shadow-lg fixed w-full z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <a href="{{ route('site') }}" class="flex items-center text-white text-2xl font-bold">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Evenza
                </a>
                
                <div class="hidden md:flex items-center space-x-6">
                    <a href="#por-que-escolher" class="text-white hover:text-acento transition-colors">
                        Por que escolher
                    </a>
                    <a href="#publico" class="text-white hover:text-acento transition-colors">
                        Para quem é
                    </a>
                    <a href="#contato" class="text-white hover:text-acento transition-colors">
                        Contato
                    </a>
                    <a href="{{ route('painel') }}" class="bg-white text-gray-800 px-6 py-2 rounded-full font-semibold hover:bg-gray-100 transition-all">
                        Entrar
                    </a>
                </div>
                
                <button id="menu-mobile" class="md:hidden text-white">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
            
            <div id="menu-mobile-conteudo" class="hidden md:hidden pb-4">
                <a href="#por-que-escolher" class="block text-white py-2 hover:text-acento">Por que escolher</a>
                <a href="#publico" class="block text-white py-2 hover:text-acento">Para quem é</a>
                <a href="#contato" class="block text-white py-2 hover:text-acento">Contato</a>
                <a href="{{ route('painel') }}" class="block text-white py-2 hover:text-acento">Entrar</a>
            </div>
        </div>
    </nav>

    <section class="hero-section relative h-screen flex items-center justify-center text-center text-white overflow-hidden">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="{{ asset('video/video2.mp4') }}" type="video/mp4">
            Seu navegador não suporta vídeo HTML5.
        </video>
        <div class="hero-overlay absolute inset-0 z-10"></div>
        
        <div class="container mx-auto px-4 z-20 relative">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Evenza - Gestão de Eventos</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-4xl mx-auto">
                A solução completa para facilitar a gestão de eventos corporativos, reuniões estratégicas, webaulas e confraternizações.
            </p>
            <a href="{{ route('painel') }}" class="bg-white text-gray-800 px-8 py-4 rounded-full font-semibold text-lg hover:bg-gray-100 transition-all">
                Começar agora
            </a>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2">
                    <h2 class="text-3xl md:text-4xl font-bold text-primario mb-6">
                        Bem-vindo ao Evenza
                    </h2>
                    <p class="text-xl mb-6 text-gray-600">
                        Nossa plataforma foi criada para otimizar a experiência dos organizadores e garantir o controle completo da sua programação.
                    </p>
                    <p class="text-gray-600">
                        Do convite ao RSVP, passando por confirmações personalizadas e relatórios detalhados, o Evenza oferece tudo que você precisa para gerenciar seus eventos com eficiência.
                    </p>
                </div>
                <div class="lg:w-1/2">
                    <img src="{{ asset('img/img5.jpg') }}" alt="Gestão de Eventos" class="w-full rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <section id="por-que-escolher" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-primario mb-12">
                Por que escolher o Evenza?
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-4xl text-acento mb-4">
                        <i class="fas fa-pager"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Landing Pages Personalizadas</h4>
                    <p class="text-gray-600">Crie páginas profissionais para seus eventos com blocos customizáveis, fotos, agenda e mapas integrados.</p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-4xl text-acento mb-4">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Formulários Personalizados</h4>
                    <p class="text-gray-600">Crie formulários sob medida com diversos tipos de campos para coletar exatamente as informações que você precisa.</p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-4xl text-acento mb-4">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Gestão de Inscrições</h4>
                    <p class="text-gray-600">Controle total sobre confirmações de presença, capacidade de vagas e lista de participantes em tempo real.</p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-4xl text-acento mb-4">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Painel Intuitivo</h4>
                    <p class="text-gray-600">Gestão centralizada com interface amigável, filtros avançados e visualização clara de todas as informações.</p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-4xl text-acento mb-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Relatórios e Exportação</h4>
                    <p class="text-gray-600">Exporte dados de participantes, respostas de formulários e gere relatórios detalhados para análise.</p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-4xl text-acento mb-4">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Múltiplos Organizadores</h4>
                    <p class="text-gray-600">Gerencie equipes de organizadores com funções e contatos específicos para cada evento.</p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-4xl text-acento mb-4">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Controle Financeiro</h4>
                    <p class="text-gray-600">Acompanhe receitas e custos do evento, com cálculo automático de saldo e lucro estimado.</p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-4xl text-acento mb-4">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Compartilhamento Fácil</h4>
                    <p class="text-gray-600">Links públicos personalizados, QR codes e integração direta com suas ferramentas de comunicação.</p>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-sm hover:shadow-md transition-shadow text-center">
                    <div class="text-4xl text-acento mb-4">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Segurança e Confiabilidade</h4>
                    <p class="text-gray-600">Seus dados e de seus convidados sempre protegidos com tecnologia moderna e confiável.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="publico" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-primario mb-12">
                Para quem é o Evenza?
            </h2>
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2 space-y-6">
                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-6">
                            <i class="fas fa-building"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold mb-2">Empresas Privadas</h4>
                            <p class="text-gray-600">Que organizam eventos corporativos, reuniões estratégicas, treinamentos e confraternizações.</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-6">
                            <i class="fas fa-landmark"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold mb-2">Instituições Públicas</h4>
                            <p class="text-gray-600">Órgãos governamentais, prefeituras e secretarias que realizam eventos, palestras e capacitações.</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-6">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold mb-2">Instituições de Ensino</h4>
                            <p class="text-gray-600">Universidades, faculdades, institutos como IFMS, escolas que organizam seminários, palestras e eventos acadêmicos.</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-6">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold mb-2">Departamentos de Marketing</h4>
                            <p class="text-gray-600">E comunicação que realizam webaulas, webinars, lançamentos de produtos e treinamentos.</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-6">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold mb-2">Associações e ONGs</h4>
                            <p class="text-gray-600">Entidades que promovem encontros, assembleias, eventos beneficentes e ações comunitárias.</p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-6">
                            <i class="fas fa-glass-cheers"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold mb-2">Organizadores de Eventos</h4>
                            <p class="text-gray-600">Profissionais que gerenciam festas de fim de ano, confraternizações, eventos internos e externos.</p>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <img src="{{ asset('img/img2.jpg') }}" alt="Para quem é o Evenza" class="w-full rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-primario text-white text-center relative">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="container mx-auto px-4 relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Comece agora!</h2>
            <p class="text-xl mb-4 max-w-3xl mx-auto">
                Facilite a gestão dos seus eventos com uma plataforma que oferece eficiência, controle e praticidade.
            </p>
            <p class="text-lg mb-8">Solicite uma demonstração ou entre em contato para saber mais.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#contato" class="bg-white text-primario px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-all">
                    Fale Conosco
                </a>
                <a href="#" class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-primario transition-all">
                    Agende um teste gratuito
                </a>
            </div>
        </div>
    </section>

    <section id="contato" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-primario mb-12">
                Fale Conosco
            </h2>
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-4">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold mb-1">Email</h5>
                            <p class="text-gray-600">contato@evenza.com.br</p>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-4">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold mb-1">Telefone</h5>
                            <p class="text-gray-600">(67) 3456-7890</p>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-4">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold mb-1">Endereço</h5>
                            <p class="text-gray-600">Av. Brasil Central, 477 - Campo Grande MS</p>
                        </div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-4">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold mb-1">Horário de Atendimento</h5>
                            <p class="text-gray-600">Segunda a Sexta: 9h às 18h</p>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm flex items-center">
                        <div class="w-16 h-16 bg-acento bg-opacity-10 rounded-full flex items-center justify-center text-acento text-2xl mr-4">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <h5 class="font-semibold mb-1">Suporte</h5>
                            <p class="text-gray-600">suporte@evenza.com.br</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mapa-container w-full h-96 bg-gray-100">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.4634892847437!2d-54.638426!3d-20.451234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9486e7a7b7c6f7b7%3A0x7b7c6f7b7c6f7b7b!2sAv.%20Brasil%20Central%2C%20477%20-%20Vila%20Ipiranga%2C%20Campo%20Grande%20-%20MS!5e0!3m2!1spt-BR!2sbr!4v1641234567890!5m2!1spt-BR!2sbr"
            class="w-full h-full border-0"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            title="Localização Evenza - Av. Brasil Central, 477, Campo Grande MS">
        </iframe>
        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d119631.31151286111!2d-54.73645003021432!3d-20.445531602762436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sifms!5e0!3m2!1spt-BR!2sbr!4v1753228740672!5m2!1spt-BR!2sbr" class="w-full h-full border-0" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

    <footer class="bg-gray-900 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    <h3 class="text-xl font-bold">Evenza</h3>
                    <p class="text-gray-400">Transformando a gestão de eventos</p>
                </div>
                <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} Evenza. Todos os direitos reservados.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <button id="voltar-topo" class="fixed bottom-8 right-8 bg-acento text-white w-12 h-12 rounded-full flex items-center justify-center shadow-lg hover:bg-primario transition-all z-50 opacity-0 pointer-events-none">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        document.getElementById('menu-mobile').addEventListener('click', function() {
            document.getElementById('menu-mobile-conteudo').classList.toggle('hidden');
        });

        const botaoTopo = document.getElementById('voltar-topo');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                botaoTopo.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                botaoTopo.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        botaoTopo.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>