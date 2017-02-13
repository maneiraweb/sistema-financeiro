<template>
    <div class="container">
        <div class="row">
            <page-title>
                <h5>Administração de categorias</h5>
            </page-title>
            <div class="card-panel z-depth-5">
                <categoria-tree :categorias="categorias"></categoria-tree>
            </div>

            <categoria-save :modal-options="modalOptionsSave" :categoria.sync="categoriaSave" :cp-options="cpOptions" @save-categoria="saveCategoria">
                <span slot="title">{{title}}</span>
                <div slot="footer">
                    <button type="submit" class="btn btn-flat waves-effect green lighten-2 modal-close modal-action">
                        Salvar
                    </button>
                    <button type="button" class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
                </div>
            </categoria-save>

            <modal :modal="modalOptionsDelete">
                <div slot="content" v-if="categoriaDelete">
                    <h4>Deseja excluir esta categoria?</h4>
                    <div class="divider"></div>
                    <p>Nome: <strong>{{categoriaDelete.nome}}</strong></p>
                    <div class="divider"></div>
                </div>
                <div slot="footer">
                    <button class="btn btn-flat waves-effect green lighten-2 modal-close modal-action"
                        @click="destroy()">EXCLUIR
                    </button>
                    <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
                </div>
            </modal>

            <div class="fixed-action-btn">
                <button class="btn-floating btn-large" @click="modalNew(null)">
                    <i class="large material-icons">add</i>
                </button>
            </div>
        </div>
</template>

<script type="text/javascript">
    import PageTitleComponent from '../PageTitle.vue';
    import CategoriaTreeComponent from './CategoriaTree.vue';
    import CategoriaSaveComponent from './CategoriaSave.vue';
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import { Categoria } from '../../services/resources';
    import { CategoriaFormat, CategoriaService } from '../../services/categoria-nsm';

    export default {
        components: {
            'modal': ModalComponent,
            'page-title': PageTitleComponent,
            'categoria-tree': CategoriaTreeComponent,
            'categoria-save': CategoriaSaveComponent
        },
        data() {
            return {
                categorias: [],
                categoriasFormatadas: [],
                categoriaSave: {
                    id: 0,
                    nome: '',
                    parent_id: 0
                },
                categoriaDelete: null,
                categoria: null,
                parent: null,
                title: '',
                modalOptionsSave: {
                    id: 'modal-categoria-save'
                },
                modalOptionsDelete: {
                    id: 'modal-categoria-delete'
                }
            }
        },
        computed: {
            //Opções para o campo select2 de categoria pai
            cpOptions() {
                return {
                    data: this.categoriasFormatadas,
                    templateResult(categoria) {
                        let margin = '&nbsp;'.repeat(categoria.level * 8);
                        let text = categoria.hasChildren ? `<strong>${categoria.text}</strong>` : categoria.text;
                        return `${margin}${text}`;
                    },
                    escapeMarkup(m) {
                        return m;
                    }
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
                    this.formataCategorias();
                });
            },
            saveCategoria() {
                CategoriaService.save(this.categoriaSave, this.parent, this.categorias, this.categoria).then(response => {
                    if(this.categoriaSave.id === 0) {
                        Materialize.toast('Categoria adicionada com sucesso!', 4000);
                    } else {
                        Materialize.toast('Categoria alterada com sucesso!', 4000);
                    }
                    this.resetScope();
                });
            },
            destroy() {
                CategoriaService.destroy(this.categoriaDelete, this.parent, this.categorias)
                    .then(response => {
                        Materialize.toast('Categoria excluída com sucesso!', 4000);
                        this.resetScope();
                    });
            },
            modalNew(categoria) {
                this.title = 'Nova categoria';
                this.categoriaSave = {
                    id: 0,
                    nome: '',
                    parent_id: categoria === null ? null : categoria.id
                };
                this.parent = categoria;
                $(`#${this.modalOptionsSave.id}`).modal('open');
            },
            modalEdit(categoria, parent) {
                this.title = 'Editar categoria';
                this.categoriaSave = {
                    id: categoria.id,
                    nome: categoria.nome,
                    parent_id: categoria.parent_id
                };
                this.categoria = categoria;
                this.parent = parent;
                $(`#${this.modalOptionsSave.id}`).modal('open');
            },
            modalDelete(categoria, parent) {
                this.title = 'Editar categoria';
                this.categoriaDelete = categoria;
                this.parent = parent;
                this.categoriaSave = {
                    id: categoria.id,
                    nome: categoria.nome,
                    parent_id: categoria.parent_id
                };
                this.categoria = categoria;
                this.parent = parent;
                $(`#${this.modalOptionsDelete.id}`).modal('open');
            },
            formataCategorias() {
                this.categoriasFormatadas = CategoriaFormat.getCategoriasFormatadas(this.categorias);
            },
            resetScope() {
                this.categoriaSave = {
                    id: 0,
                    nome: '',
                    parent_id: 0
                };
                this.categoriaDelete = null;
                this.categoria = null;
                this.parent = null;
                this.formataCategorias();
            }
        },
        events: {
            'categoria-new'(categoria) {
                this.modalNew(categoria);
            },
            'categoria-edit'(categoria, parent) {
                this.modalEdit(categoria, parent);
            },
            'categoria-delete'(categoria, parent) {
                this.modalDelete(categoria, parent);
            }
        }
    }

</script>