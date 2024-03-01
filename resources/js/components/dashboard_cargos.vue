<template>
    <div> 
        <div class="header">
            <button @click="logout()">Cerrar sesion</button>
            <p class="subtitle">Saldo restante</p>
            <p>$ {{ cargos_total - abonos_total }}</p>
        </div>
        <div class="content">
            <div class="form">
                <div class="field">
                    <label for="">Monto</label>
                    <input type="number" v-model="transaction.amount">
                </div>
                <div class="checkboxs">
                    <button :class="transaction.type == 'abono' ? 'selected ingreso' : ''" @click="transaction.type = 'abono'">Abono</button>
                    <button :class="transaction.type == 'cargo' ? 'selected egreso' : ''" @click="transaction.type = 'cargo'">Cargo</button>
                </div>
                <br>
                <div class="field">
                    <label for="">Fecha</label>
                    <input type="date" v-model="transaction.date">
                </div>
                <div class="field">
                    <label for="">Categoria</label>
                    <select name="" id="" v-model="transaction.category_id">
                        <option value="7">Prestamo</option>
                        <option value="8">Compu</option>
                        <option value="9">Anillo</option>
                        <option value="10">Frasco</option>
                        <option value="11">Coppel</option>
                        <option value="12">Otro</option>
                    </select>
                </div>
                <div class="field">
                    <label for="">Descripción</label>
                    <input type="textarea" v-model="transaction.description">
                </div>
                <button @click="saveTransaction()">Guardar</button>
        </div>
        
        <br> 
            <h1>Movimientos</h1>
            <div v-for="movimiento in movimientos" :class="movimiento.type == 'cargo' ? 'item egreso' : 'item ingreso' ">
                    <p class="amount">${{ movimiento.amount }}</p>
                    <p>{{ movimiento.date }}</p>
                    <p class="description">{{ movimiento.description }}</p>
                    <p>Categoria: {{ movimiento.category.name }}</p>
            </div>
        </div>

        
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        data() {
            return {
                cargos_total: 0,
                abonos_total: 0,
                saldo: 0,
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

                    this.cargos_total = 0;
                    this.abonos_total = 0;

                    this.movimientos.forEach(movimiento => {
                        if(movimiento.type === 'cargo'){
                            this.cargos_total += parseFloat(movimiento.amount);
                        }else{
                            this.abonos_total += parseFloat(movimiento.amount);
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
            },
            logout: function() {
                localStorage.removeItem('token');
                window.location.href = '/';
            }
        }
    }
</script>