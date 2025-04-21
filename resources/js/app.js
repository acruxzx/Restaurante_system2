import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// Registrar el Service Worker para PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
      navigator.serviceWorker
        .register('/service-worker.js') // Este es el archivo que crearemos
        .then(function (registration) {
          console.log('Service Worker registrado con éxito:', registration);
        })
        .catch(function (error) {
          console.log('Error al registrar el Service Worker:', error);
        });
    });
  }
