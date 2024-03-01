<template>
    <div class="content">
        <button @click="logout()">Cerrar sesion</button>
        <div class="card">

            <div class="row">
                <p>${{ ahorro - gastos }}</p>
                <img src="https://1000marcas.net/wp-content/uploads/2019/12/logo-Mastercard-500x281.png"/>
            </div>

            <div class="balances">
                <div>
                    <label for="">Total ahorrado</label>
                    <p style="color: white;">$ {{ ahorro }}</p>
                </div>
                <div>
                    <label for="">Total retirado</label>
                    <p style="color: white;">$ {{ gastos }}</p>
                </div>               
            </div>

            <div class="footer">
                <p>123***************789</p>
                <p>Ruth y Alan</p>
            </div>
        
        </div>
        <div class="form">
                <div class="field">
                    <label for="">Monto</label>
                    <input type="number" v-model="transaction.amount">
                </div>
                <br>
                <div class="checkboxs">
                    <button :class="transaction.type == 'ingreso' ? 'selected ingreso' : ''" @click="transaction.type = 'ingreso'">Ingreso</button>
                    <button :class="transaction.type == 'egreso' ? 'selected egreso' : ''" @click="transaction.type = 'egreso'">Egreso</button>
                </div>
                <br>
                <div class="field">
                    <label for="">Fecha</label>
                    <input type="date" v-model="transaction.date">
                </div>
                <br>
                <div class="field">
                    <label for="">Categoria</label>
                    <select name="" id="" v-model="transaction.category_id">
                        <option value="1">Sueldo</option>
                        <option value="2">Comida</option>
                        <option value="3">Negocio</option>
                        <option value="4">Recreacion</option>
                        <option value="5">Cita</option>
                        <option value="6">Otro</option>
                    </select>
                </div>
                <br>
                <div class="field">
                    <label for="">Descripcion</label>
                    <input type="text" v-model="transaction.description">
                </div>
                <br>
                <button @click="saveTransaction()">Guardar</button>
        </div>
        <div>
            <h1>Movimientos</h1>
            <div v-for="movimiento in movimientos" :class="movimiento.type == 'ingreso' ? 'item ingreso' : 'item egreso' ">
                    <p class="amount">${{ movimiento.amount }}</p>
                    <!-- <p>-</p> -->
                    <p>{{ movimiento.date }}</p>
                    <!-- <p>-</p> -->
                    <p class="description">{{ movimiento.description }}</p>
                    <!-- <p>-</p> -->
                    <p>Categoria: {{ movimiento.category.name }}</p>
            </div>
        </div>
        <br>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        props: ['vuser'],
        data() {
            return {
                gastos: 0,
                ahorro: 0,
                movimientos: [],
                transaction: {
                    amount: null,
                    date: '',
                    type: '',
                    category_id: 'Sueldo',
                    description: ''
                },
                user: null
            }
        },
        mounted() {
            this.user = this.vuser;
            this.fetchMovimientos();
        },
        methods: {
            fetchMovimientos: async function() {

                //send crsf token
                
                //axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await axios.get('/api/transactions');

                if(response.data.status === 'success'){
                    this.movimientos = response.data.transactions;

                    this.ahorro = 0;
                    this.gastos = 0;

                    this.movimientos.forEach(movimiento => {
                        if(movimiento.type === 'ingreso'){
                            this.ahorro += parseFloat(movimiento.amount);
                        }else{
                            this.gastos += parseFloat(movimiento.amount);
                        }
                    });

                }else{
                    alert('Error al cargar los movimientos');
                }
            },
            saveTransaction: async function() {
                try {

                    if(this.transaction.amount === null || this.transaction.amount === ''){
                        alert('Ingresa un monto');
                        return;
                    }
                    if(this.transaction.type === ''){
                        alert('Selecciona un tipo de movimiento');
                        return;
                    }
                    if(this.transaction.date === null || this.transaction.date === ''){
                        alert('Ingresa una fecha');
                        return;
                    }
                    if(this.transaction.category_id === null || this.transaction.category_id === ''){
                        alert('Selecciona una categoria');
                        return;
                    }
                    if(this.transaction.description === null || this.transaction.description === ''){
                        alert('Ingresa una descripcion');
                        return;
                    }

                    const response = await axios.post('/api/transactions', this.transaction);

                    if(response.data.status === 'success'){
                        this.transaction = {
                                amount: null,
                                date: '',
                                type: '',
                                category_id: '',
                                description: ''
                            }
                        this.fetchMovimientos();
                    }else{
                        alert('Error al guardar el movimiento');
                    }
                    
                } catch (e) {

                    alert('Error al guardar el movimiento');

                    
                }
            },
            logout: function() {
                localStorage.removeItem('token');
                window.location.href = '/';
            }
        }
    }
</script>