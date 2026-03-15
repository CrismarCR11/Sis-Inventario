import { createApp } from 'vue';
import { createPinia } from 'pinia';
import router from './router/index.js';
import App from './App.vue';
import vuetify from './plugins/vuetify'
import axios from './plugins/axios'
import { MotionPlugin } from '@vueuse/motion';

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(vuetify)
app.use(MotionPlugin);
// Hacer axios global (opcional pero útil)
app.config.globalProperties.$axios = axios

app.mount('#app')