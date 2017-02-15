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
                                <i class="material-icons right" v-if="searchOptions.order.key == key">
                                    {{ searchOptions.order.sort == 'asc' ? 'arrow_drop_up' : 'arrow_drop_down' }}
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
                :current-page.sync="searchOptions.pagination.current_page"
                :per-page="searchOptions.pagination.per_page" 
                :total-records="searchOptions.pagination.total"></pagination>
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
    import store from '../../store/store';

    export default {
        components: {
            'modal': ModalComponent,
            'pagination': PaginationComponent,
            'page-title': PageTitleComponent,
            'search': SearchComponent
        },
        data() {
            return {
                contaBancariaDelete: null,
                modal: {
                    id: 'modal-delete'
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
        computed:{
            contasBancarias(){
                return store.state.contaBancaria.contasBancarias;
            },
            searchOptions(){
                return store.state.contaBancaria.searchOptions;
            },
            search: {
                get() {
                    return store.state.contaBancaria.searchOptions.search;
                },
                set(value) {
                    store.commit('setFilter', value);
                }
            }
        },
        created() {
            store.dispatch('query');
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
            sortBy(key) {
                store.dispatch('queryWithSortBy', key);
            },
            filter() {
                store.dispatch('queryWithFilter');
            }
        },
        events: {
            'pagination::changed'(page){
                store.dispatch('queryWithPagination', page);
            }
        }
    };
</script>