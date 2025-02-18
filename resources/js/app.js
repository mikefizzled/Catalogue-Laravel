import './bootstrap';
import 'flowbite';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue';
import App from './components/SearchComponent.vue';


const app = createApp(App);
app.mount('#app');
