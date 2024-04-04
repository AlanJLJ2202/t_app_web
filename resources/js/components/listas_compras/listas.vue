<template>

    <div class="content">
        <nav>
            <center>
                <img src="/images/logo_gallos.png" alt="">
            </center>
            <center>
                <div class="nav-center">
                    <label for="" @click="panel = 'listas'">Listas</label>
                    <label for="" @click="panel = 'productos'">Productos</label>
                    <label for="" @click="panel = 'categorias'">Categorias</label>
                </div>
            </center>
            
        </nav>

        <button @click="logout()">Cerrar sesión</button>
        <br>


        <div v-if="panel == 'listas'">
            <div class="row-lists">
            <button>Lista 1</button>
            <button>Lista 2</button>
            <button>Lista 3</button>
            <button>Lista 4</button>
            <button>+</button>
        </div>

        <center>
            <label>Lista 1</label>
        </center>
        
        <div class="body-content">

            <div class="body-block left">
                <div class="products-list">

                        <div class="product-item">
                            <div class="product-top">
                                <div class="product-info">
                                    <center>
                                        <img src="/images/logo_gallos.png" alt="">
                                    </center>
                                    <div class="product-actions">
                                        <center>
                                            <label for="">{{1}}</label>
                                            <br>
                                            <br>
                                            <button style="background-color: green;">+</button>
                                            <br>
                                            <button style="background-color: red;">-</button>
                                        </center>
                                    </div>  
                                </div>
                            </div>
                            
                            <div class="product-bottom">
                                <label for="">Cheesecake</label>
                                <div style="width: 10px;"></div>
                                <label for="">20$</label>
                            </div>
                        </div>


                </div>
            </div>
            <div class="body-block rigth">

            </div>
        </div>
        </div>


        <div v-if="panel == 'productos'">
            <div class="botones">
                <button @click="modo = 'edicion'">Agregar producto</button>
            </div>
            <div class="listado-inventario">
                
                <div v-if="modo == 'visor'">
                    <div class="producto-inventario">
                        <div class="left">
                            <img src="/images/logo_gallos.png">
                        </div>
                        <div class="right">
                            <label><strong>Producto 1</strong></label>
                            <label>$45</label>
                        </div>
                    </div>

                    <div class="producto-inventario">
                        <div class="left">
                            <img src="/images/logo_gallos.png">
                        </div>
                        <div class="right">
                            <label><strong>Producto 1</strong></label>
                            <label>$45</label>
                        </div>
                    </div>

                    <div class="producto-inventario">
                        <div class="left">
                            <img src="/images/logo_gallos.png">
                        </div>
                        <div class="right">
                            <label><strong>Producto 1</strong></label>
                            <label>$45</label>
                        </div>
                    </div>

                    <div class="producto-inventario">
                        <div class="left">
                            <img src="/images/logo_gallos.png">
                        </div>
                        <div class="right">
                            <label><strong>Producto 1</strong></label>
                            <label>$45</label>
                        </div>
                    </div>

                    <div class="producto-inventario">
                        <div class="left">
                            <img src="/images/logo_gallos.png">
                        </div>
                        <div class="right">
                            <label><strong>Producto 1</strong></label>
                            <label>$45</label>
                        </div>
                    </div>

                    <div class="producto-inventario">
                        <div class="left">
                            <img src="/images/logo_gallos.png">
                        </div>
                        <div class="right">
                            <label><strong>Producto 1</strong></label>
                            <label>$45</label>
                        </div>
                    </div>

                    <div class="producto-inventario">
                        <div class="left">
                            <img src="/images/logo_gallos.png">
                        </div>
                        <div class="right">
                            <label><strong>Producto 1</strong></label>
                            <label>$45</label>
                        </div>
                    </div>

                    <div class="producto-inventario">
                        <div class="left">
                            <img src="/images/logo_gallos.png">
                        </div>
                        <div class="right">
                            <label><strong>Producto 1</strong></label>
                            <label>$45</label>
                        </div>
                    </div>
                </div>

                <div v-if="modo == 'edicion'">

                    <div class="field">
                        <label for="">Nombre</label>
                        <input type="text">
                    </div>

                    
                </div>

                
            </div>
        </div>

        


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
                user: null,
                panel: 'productos',
                modo: 'visor'
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