<template>
    <div class="container">
        <div class="row">
        <page-title>
            <h5>Minhas contas bancárias</h5>
        </page-title>
            <div class="card-panel z-depth-5">
            <search @on-submit="filter" :model.sync="search"></search>    
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
                           <div class="valign-wrapper">
                               <div class="col s2">
                                   <img :src="o.banco.data.logo" class="banco-logo">
                               </div>
                               <div class="col s10">
                                   <span class="left">{{o.banco.data.nome}}</span>
                               </div>
                           </div>
                       </td> 
                       <td>
                           <i class="material-icons green-text" v-if="o.default">check</i>
                       </td>
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
                <a class="btn-floating btn-large" v-link="{name: 'conta-bancaria.create'}">
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
    import PageTitleComponent from '../PageTitle.vue';
    import SearchComponent from '../Search.vue';

    export default {
        components: {
            'modal': ModalComponent,
            'pagination': PaginationComponent,
            'page-title': PageTitleComponent,
            'search': SearchComponent
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
                            label: 'Cód.', width: '8%'
                        },
                        nome: {
                            label: 'Nome', width: '30%'
                        },
                        agencia: {
                            label: 'Agência', width: '12%',
                        },
                        conta: {
                            label: 'C/C', width: '12%'
                        },
                        'bancos:banco_id|bancos.nome': {
                            label: 'Banco', width: '18%'
                        },
                        'default': {
                            label: 'Padrão', width: '5%'
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
                    if(this.contasBancarias.length === 0 && this.pagination.current_page > 0) {
                        this.pagination.current_page--;
                    }
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
                    search: this.search,
                    include: 'banco'
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
                this.pagination.current_page = 0;
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