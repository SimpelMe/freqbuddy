const staticFreqBuddy = "freq-buddy-site-v1"
const assets = [
    "/index.php",
    "/script.min.js",
    "/app.min.js",
    "/style.min.css",
    "/Simpel_256px_eco.webp",
    "/github.svg",
]

self.addEventListener("install", installEvent => {
    installEvent.waitUntil(
        caches.open(staticFreqBuddy).then(cache => {
            cache.addAll(assets)
        })
    )
})

self.addEventListener("fetch", fetchEvent => {
    fetchEvent.respondWith(
        caches.match(fetchEvent.request).then(res => {
            return res || fetch(fetchEvent.request)
        })
    )
})
