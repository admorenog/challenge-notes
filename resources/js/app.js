require('./bootstrap');
import * as Vue from 'vue';
import mitt from 'mitt';

import TaskProxy from "@/Proxies/TaskProxy";
import Dashboard from '@/Pages/Dashboard';

const taskProxy = new TaskProxy('http://localhost:1080');

const app = Vue.createApp({});

app.component("dashboard", Dashboard);

app.config.globalProperties.taskProxy = taskProxy;
app.config.globalProperties.emitter = mitt();

app.mount('#app');
