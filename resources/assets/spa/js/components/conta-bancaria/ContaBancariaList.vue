<template>
    <div class="container">
        <div class="row">
            <div class="card-panel green lighten-3">
                <span class="green-text text-darken-2">
                    <h5>Minhas contas bancárias</h5>
                </span>
            </div>
            <div class="card-panel z-depth-5">
                <form name="form" method="GET" @submit="filter()">
                    <div class="filter-group">
                        <button class="btn waves-effect" type="submit">
                            <i class="material-icons">search</i>
                        </button>
                        <div class="filter-wrapper">
                            <input type="text" v-model="search" placeholder="Pesquise..."/>
                        </div>
                    </div>
                </form>
            <table class="bordered striped highlight responsive-table">
                <thead>
                    <tr>
                        <th v-for="(key, o) in table.headers" :width="o.width">
                            <a href="#" @click.prevent="sortBy(key)">
                                {{o.label}}
                                <i class="material-icons right" v-if="order.key == key">
                                    {{ order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
                                </i>
                            </a>
                        </th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(index, o) in contasBancarias">
                       <td>&nbsp;{{ o.id }}</td>
                       <td>{{ o.nome }}</td> 
                       <td>{{ o.agencia }}</td> 
                       <td>{{ o.conta }}</td> 
                       <td>
                           <a v-link="{ name: 'conta-bancaria.update', params: {id: o.id}}">Editar</a> |
                           <a href="#" @click.prevent="openModalDelete(o)">Excluir</a>
                       </td>  
                    </tr>
                </tbody>
            </table>
            <pagination 
                :current-page.sync="pagination.current_page"
                :per-page="pagination.per_page" 
                :total-records="pagination.total"></pagination>
            </div>
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large" href="www.liasoft.com.br">
                    <i class="large material-icons">add</i>
                </a>
            </div>    
        </div>
    </div>
    <modal :modal="modal">
        <div slot="content" v-if="contaBancariaToDelete">
            <h4>Exclusão!</h4>
            <p><strong>Deseja excluir esta conta bancária?</strong></p>
            <div class="divider"></div>
            <p>Nome: <strong>{{contaBancariaToDelete.nome}}</strong></p>
            <p>Agência: <strong>{{contaBancariaToDelete.agencia}}</strong></p>
            <p>Conta: <strong>{{contaBancariaToDelete.conta}}</strong></p>
            <div class="divider"></div>
        </div>
        <div slot="footer">
            <button class="btn btn-flat waves-effect green lighten-2 modal-close modal-action"
                @click="destroy()">EXCLUIR
            </button>
            <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
        </div>
    </modal>
</template>

<script type="text/javascript">
    import {ContaBancaria} from '../../services/resources';
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import PaginationComponent from '../Pagination.vue';

    export default {
        components: {
            'modal': ModalComponent,
            'pagination': PaginationComponent,
        },
        data() {
            return {
                contasBancarias: [],
                contaBancariaToDelete: null,
                modal: {
                    id: 'modal-delete'
                },
                pagination: {
                    current_page: 0,
                    per_page: 0,
                    total: 0
                },
                search: "",
                order: {
                    key: 'id',
                    sort: 'asc'
                },
                table: {
                    headers: {
                        id: {
                            label: 'Cód.',
                            width: '10%'
                        },
                        nome: {
                            label: 'Nome',
                            'width': '45%'
                        },
                        agencia: {
                            label: 'Agência',
                            width: '15%',
                        },
                        conta: {
                            label: 'C/C',
                            width: '15%'
                        }
                    }
                }
            };
        },
        created() {
            this.getContasBancarias();
        },
        methods: {
            destroy() {
                ContaBancaria.delete({id: this.contaBancariaToDelete.id}).then((response) => {
                    this.contasBancarias.$remove(this.contaBancariaToDelete);
                    this.contaBancariaToDelete = null;
                    Materialize.toast('Conta bancária excluída com sucesso!', 4000);
                });
            }, openModalDelete(contaBancaria) {
                this.contaBancariaToDelete = contaBancaria;
                $('#modal-delete').modal('open');
            },
            getContasBancarias() {
                ContaBancaria.query({
                    page: this.pagination.current_page + 1,
                    orderBy: this.order.key,
                    sortedBy: this.order.sort,
                    search: this.search
                }).then((response) => {
                    this.contasBancarias = response.data.data;
                    let pagination = response.data.meta.pagination;
                    pagination.current_page--;
                    this.pagination = pagination;
                });
            },
            sortBy(key) {
                this.order.key = key;
                this.order.sort = this.order.sort == 'desc' ? 'asc' : 'desc';
                this.getContasBancarias();
            },
            filter() {
                this.getContasBancarias();
            }
        },
        events: {
            'pagination::changed'(page){
                this.getContasBancarias();
            }
        }
    };
</script>