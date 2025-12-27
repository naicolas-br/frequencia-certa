const CACHE_NAME = 'frequencia-certa-v2';
const ASSETS_TO_CACHE = [
    '/offline', // Apenas a página offline precisa ser fixa
    '/img/icons/icon-192x192.png',
    '/img/icons/icon-512x512.png',
    // O CSS e JS do Vite serão cacheados dinamicamente abaixo
];

// 1. INSTALAÇÃO
self.addEventListener('install', (event) => {
    self.skipWaiting(); // Força o SW a ativar imediatamente
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
});

// 2. ATIVAÇÃO (Limpeza de caches antigos)
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
    return self.clients.claim(); // Controla a página imediatamente
});

// 3. INTERCEPTAÇÃO (FETCH)
self.addEventListener('fetch', (event) => {
    // Ignora requisições que não sejam GET ou que sejam para API/Backend (exceto navegação)
    if (event.request.method !== 'GET') return;

    event.respondWith(
        fetch(event.request)
            .then((networkResponse) => {
                // Se a resposta for válida, clonamos e salvamos no cache
                // Isso vai salvar automaticamente o CSS, JS e Imagens do Vite
                if (networkResponse && networkResponse.status === 200 && networkResponse.type === 'basic') {
                    const responseToCache = networkResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseToCache);
                    });
                }
                return networkResponse;
            })
            .catch(() => {
                // Se der erro (offline), tenta pegar do cache
                return caches.match(event.request).then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    
                    // Se for navegação (usuário tentando abrir uma página) e não tiver cache -> Tela Offline
                    if (event.request.mode === 'navigate') {
                        return caches.match('/offline');
                    }
                });
            })
    );
});