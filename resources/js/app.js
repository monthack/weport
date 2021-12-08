require('./bootstrap');


import { createApp } from 'vue';

const app = createApp({
    components:{
       ExampleComponent: () => import('./components/ExampleComponent.vue') 
    }
});