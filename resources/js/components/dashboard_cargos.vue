<template>
    <div> 
        <div class="header">
            <button @click="logout()">Cerrar sesion</button>
            <div v-if="cargos_total >= abonos_total">
                <p class="subtitle">Saldo restante</p>
                <center>
                    <p>$ {{ cargos_total - abonos_total }}</p>
                </center>
            </div>
            <div v-else>
                <p class="subtitle">
                    Saldo a favor
                </p>
                <center>
                    <p>$ {{ abonos_total - cargos_total }}</p>
                </center>
            </div>
            <div class="subtitles">
                <div>
                    <label for="">Total gastado</label>
                    <p>$ {{ cargos_total }}</p>
                </div>
                <div style="width: 30px;">

                </div>
                <div>
                    <label for="">Total abonado</label>
                    <p>$ {{ abonos_total }}</p>
                </div>
            </div>
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
                    category_id: '',
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