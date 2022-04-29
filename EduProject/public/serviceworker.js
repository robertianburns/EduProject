/* Cache name. */
const cacheName = 'eduproject-cache-v1';

/* List the files to precache. */
const precacheResources = ['/', './'];

/* When the service worker is installing, open the cache and add the precache resources to it. */
self.addEventListener('install', (event) => {
    console.log('Service worker is installing!');
    event.waitUntil(caches.open(cacheName).then((cache) => cache.addAll(precacheResources)));
});

self.addEventListener('activate', (event) => {
    console.log('Service worker is activate!');
});

/* When there's an incoming fetch request, try and respond with a precached resource, otherwise fall back to the network. */
self.addEventListener('fetch', (event) => {
    console.log('Fetch request intercepted for:', event.request.url);
    event.respondWith(
        caches.match(event.request).then((cachedResponse) => {
            if (cachedResponse) {
                return cachedResponse;
            }
            return fetch(event.request);
        }),
    );
});