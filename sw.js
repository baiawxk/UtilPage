let cacheName = 'v1';
let cacheFiles = [
    //html file
    './',
    './index.html',
    './manifest.json',
    './pages/tab_page.html',
    './pages/tab_index.html',
    './pages/tab_coding.html',
    './pages/tab_working.html',
    './pages/tab_living.html',
    //js file
    './js/framework7.js',
    './js/jquery.min.js',
    './js/lodash.min.js',
    './js/accounting.min.js',
    './js/qrcode.min.js',
    './js/common.js',
    './js/api.js',
    './js/routes.js',
    './js/menu.js',
    './js/app.js',
    //css files
    './css/framework7.min.css',
    './css/my-app.css',
    //img file
];



self.addEventListener('install', function(event) {
    console.log('install');
    // event.waitUntil(self.skipWaiting());
    event.waitUntil(cacheFinished());
})

self.addEventListener('activate', function(event) {
    console.log('activate');
})

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request).then(function(response) {
            // 来来来，代理可以搞一些代理的事情

            // 如果 Service Worker 有自己的返回，就直接返回，减少一次 http 请求
            if (response) {
                return response;
            }

            // 如果 service worker 没有返回，那就得直接请求真实远程服务
            var request = event.request.clone(); // 把原始请求拷过来
            return fetch(request).then(function(httpRes) {

                // http请求的返回已被抓到，可以处置了。

                // 请求失败了，直接返回失败的结果就好了。。
                if (!httpRes || httpRes.status !== 200) {
                    return httpRes;
                }

                return httpRes;
            });
        })
    );
});


function cacheFinished() {
    return caches.open(cacheName).then(function(cache) {
        return cache.addAll(cacheFiles);
    })
}