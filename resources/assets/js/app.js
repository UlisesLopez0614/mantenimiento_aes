/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Componentes de los modulos de mantenimiento
Vue.component('mantenimiento-lubricante', require('./components/ModuloLubricantes.vue').default);
Vue.component('mantenimiento-baterias', require('./components/ModuloBaterias.vue').default);
Vue.component('mantenimiento-llantas', require('./components/ModuloLlantas.vue').default);
Vue.component('principal-pantalla', require('./components/PrincipalPantalla.vue').default);
//

Vue.component('escritorio-pantalla', require('./components/EscritorioPantalla.vue').default);
Vue.component('supervisor-pantalla', require('./components/SupervisorPantalla.vue').default);
Vue.component('unidmedida-pantalla', require('./components/UnidmedidaPantalla.vue').default);
Vue.component('taller-pantalla', require('./components/TallerPantalla.vue').default);
Vue.component('item-pantalla', require('./components/ItemPantalla.vue').default);
Vue.component('tipomanto-pantalla', require('./components/TipomantoPantalla.vue').default);
Vue.component('usuarios-taller', require('./components/UsuariosTaller.vue').default);
Vue.component('empresa-catalogo-pantalla', require('./components/EmpresaCatalogoPantalla.vue').default);
Vue.component('empresa-asignacion-pantalla', require('./components/EmpresaAsignacionPantalla.vue').default);
Vue.component('acceso-users', require('./components/AccesoUsers.vue').default);
Vue.component('reporte-mantenimientos', require('./components/ReporteMantenimientos.vue').default);

//Componentes de Taller
Vue.component('listado-manto-general', require('./components/Talleres/MantosGeneralesPendientes.vue').default);
Vue.component('listado-taler', require('./components/Talleres/LubPendientes').default);
Vue.component('historial-taller', require('./components/Talleres/HistorialMantenimientos.vue').default);
Vue.component('historial-lub', require('./components/Talleres/HistorialLubricantes.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
        menu : 0
    }
});
