<template>
<div class="container">
        <div class="row">
        <page-title>
            <h5>Administração de categorias</h5>
        </page-title>
            <div class="card-panel z-depth-5">
                <categoria-tree :categorias="categorias"></categoria-tree>
            </div>

            <categoria-save :modal-options="modalOptionsSave" :categoria.sync="categoriaSave" @save-categoria="saveCategoria">
                <span slot="title">{{title}}</span>
                <div slot="footer">
                    <button type="submit" class="btn btn-flat waves-effect green lighten-2 modal-close modal-action">
                        Salvar
                    </button>
                    <button type="button" class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
                </div>
            </categoria-save>    
        </div>
</template>

<script type="text/javascript">
    import PageTitleComponent from '../PageTitle.vue';
    import CategoriaTreeComponent from './CategoriaTree.vue';
    import {Categoria} from '../../services/resources';
    import CategoriaSaveComponent from './CategoriaSave.vue';

    export default {
        components: {
            'page-title': PageTitleComponent,
            'categoria-tree': CategoriaTreeComponent,
            'categoria-save': CategoriaSaveComponent
        },
        data() {
            return {
                categorias: [],
                categoriaSave: {
                    id: 0,
                    nome: '',
                    parent_id: 0
                },
                title: 'Adicionar categoria',
                modalOptionsSave: {
                    id: 'modal-categoria-save'
                }
            }
        },
        created() {
            this.getCategorias();
        },
        methods: {
            getCategorias() {
                Categoria.query().then(response => {
                    this.categorias = response.data.data;
                });
            },
            saveCategoria() {
                console.log('teste');
            },
            modalNew(categoria) {
                this.categoriaSave = categoria;
                $( `#${this.modalOptionsSave.id}`).modal('open');
            },
            modalEdit(categoria) {

            }
        },
        events: {
            'categoria-new'(categoria) {
                this.modalNew(categoria);
            },
            'categoria-edit'(categoria) {

            }
        }
    }
</script>