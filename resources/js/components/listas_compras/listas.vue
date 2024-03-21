<template>

    <div class="content">
        <nav>
            <center>
                <img src="/images/logo_gallos.png" alt="">
            </center>
            <center>
                <div class="nav-center">
                    <label for="">Listas</label>
                    <label for="">Productos</label>
                    <label for="">Categorias</label>
                </div>
            </center>
            
        </nav>

        <div class="row-lists">
            <button>Lista 1</button>
            <button>Lista 2</button>
            <button>Lista 3</button>
            <button>Lista 4</button>
            <button>+</button>
        </div>

        <center>
            <h2>Lista 1</h2>
        </center>

        <div class="body-content">
            <div class="body-block left">

            </div>
            <div class="body-block rigth">

            </div>
        </div>


        <!-- <div class="products-list">
            <div class="product">
                <div class="product-info">
                    <p>Producto 1</p>
                    <p>Descripcion</p>
                    <p>Costo</p>
                </div>
                <div class="product-actions">
                    <button>Editar</button>
                    <button>Eliminar</button>
                </div>
            </div>
            <div class="product">
                <div class="product-info">
                    <p>Producto 2</p>
                    <p>Descripcion</p>
                    <p>Costo</p>
                </div>
                <div class="product-actions">
                    <button>Editar</button>
                    <button>Eliminar</button>
                </div>
            </div>
            <div class="product">
                <div class="product-info">
                    <p>Producto 3</p>
                    <p>Descripcion</p>
                    <p>Costo</p>
                </div>
                <div class="product-actions">
                    <button>Editar</button>
                    <button>Eliminar</button>
                </div>
            </div>
            <div class="product">
                <div class="product-info">
                    <p>Producto 4</p>
                    <p>Descripcion</p>
                    <p>Costo</p>
                </div>
                <div class="product-actions">
                    <button>Editar</button>
                    <button>Eliminar</button>
                </div>
            </div>
            <div class="product">
                <div class="product-info">
                    <p>Producto 5</p>
                    <p>Descripcion</p>
                    <p>Costo</p>
                </div>
                <div class="product-actions">
                    <button>Editar</button>
                    <button>Eliminar</button>
                </div>
            </div>
        </div> -->

        <button @click="logout()">Cerrar sesioooon</button>
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