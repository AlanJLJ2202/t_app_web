<template>
    <div>
        <h1>Dashboard</h1>
        <div class="resumen">
            <h1>Resumen</h1>
            <h2>Ahorro: ${{ ahorro - gastos }}</h2>
            <h3>Gastos: ${{ gastos }}</h3>
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
        data() {
            return {
                gastos: 1000,
                ahorro: 2000,
                movimientos: [],
                transaction: {
                    amount: null,
                    date: '',
                    type: '',
                    category_id: 'Sueldo',
                    description: ''
                }
            }
        },
        mounted() {
            this.fetchMovimientos();
        },
        methods: {
            fetchMovimientos: async function() {
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
                const response = await axios.post('/api/transactions', this.transaction);

                //console.log('Transaction');
                //console.log(this.transaction);

                if(response.data.status === 'success'){
                    this.fetchMovimientos();
                }else{
                    alert('Error al guardar el movimiento');
                }
            }
        }
    }
</script>