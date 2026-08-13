const CACHE_NAME = "desgranadora-v1";

const ARCHIVOS_CACHE = [
    "/",
    "/dashboard",
    "/manifest.json",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css",
    "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css",
    "https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js",
];

self.addEventListener("install", (event) => {
    event.waitUntil(
        caches
            .open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(ARCHIVOS_CACHE);
            })
            .then(() => self.skipWaiting()),
    );
});

self.addEventListener("activate", (event) => {
    event.waitUntil(
        caches
            .keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames
                        .filter((name) => name !== CACHE_NAME)
                        .map((name) => caches.delete(name)),
                );
            })
            .then(() => self.clients.claim()),
    );
});

self.addEventListener("fetch", (event) => {
    if (event.request.url.includes("/api/")) {
        event.respondWith(
            fetch(event.request).catch(() => {
                return caches.match(event.request);
            }),
        );
        return;
    }

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                if (response.ok && event.request.method === "GET") {
                    const cloned = response.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, cloned);
                    });
                }
                return response;
            })
            .catch(() => caches.match(event.request)),
    );
});
