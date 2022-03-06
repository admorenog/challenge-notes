import TaskProxy from "@/Proxies/TaskProxy";

require('./bootstrap');

import * as Vue from 'vue';
import Dashboard from './Pages/Dashboard';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

const taskProxy = new TaskProxy('http://localhost:1080');

const app = Vue.createApp({});

app.component("dashboard", Dashboard);

app.config.globalProperties.taskProxy = taskProxy;

app.mount('#app');
