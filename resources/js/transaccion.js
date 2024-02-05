import Vue from 'vue';
import dashboard_ahorros from "./components/dashboard_ahorros.vue";
import dashboard_cargos from "./components/dashboard_cargos.vue";

Vue.component("dashboard_ahorros", dashboard_ahorros);
Vue.component("dashboard_cargos", dashboard_cargos);


const app = new Vue({
	el: '#app',
	data: {

	},
	mounted: function(){

	},
	methods: {

	},
});
