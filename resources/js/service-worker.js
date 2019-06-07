importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.2.0/workbox-sw.js');

if(workbox) {
    console.log(workbox.routing);

    workbox.routing.registerRoute(/\.css$/, new workbox.strategies.CacheFirst());
    workbox.routing.registerRoute(/\.js$/, new workbox.strategies.CacheFirst());
}
