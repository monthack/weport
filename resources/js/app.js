require('./bootstrap');
require('popper.js');


import { createApp } from 'vue';
import UsersComponent from './components/UsersComponent';

const app = createApp({
    components:{
       UsersComponent 
    }
})
app.mount('#app');