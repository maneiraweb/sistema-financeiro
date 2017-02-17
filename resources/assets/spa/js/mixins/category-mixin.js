    import CategoryTreeComponent from '../components/category/CategoryTree.vue';
    import CategorySaveComponent from '../components/category/categorySave.vue';
    import ModalComponent from '../../../_default/components/Modal.vue';
    import { categoryFormat } from '../services/category-nsm';

    export default {
        components: {
            'modal': ModalComponent,
            'category-tree': CategoryTreeComponent,
            'category-save': CategorySaveComponent
        },
        data() {
            return {
                categories: [],
                categoriesFormatadas: [],
                categorySave: {
                    id: 0,
                    nome: '',
                    parent_id: 0
                },
                categoryDelete: null,
                category: null,
                parent: null,
                title: ''
            }
        },
        computed: {
            //Opções para o campo select2 de category pai
            cpOptions() {
                return {
                    data: this.categoriesFormatadas,
                    templateResult(category) {
                        let margin = '&nbsp;'.repeat(category.level * 8);
                        let text = category.hasChildren ? `<strong>${category.text}</strong>` : category.text;
                        return `${margin}${text}`;
                    },
                    escapeMarkup(m) {
                        return m;
                    }
                }
            },
            modalOptionsSave() {
                return {id: `modal-category-save-${this._uid}`};
            },
            modalOptionsDelete() {
                return {id: `modal-category-delete-${this._uid}`};
            },
        },
        created() {
            this.getcategories();
        },
        methods: {
            getcategories() {
                this.resource().query().then(response => {
                    this.categories = response.data.data;
                    this.formatCategories();
                });
            },
            saveCategory() {
                this.resource().save(this.categorySave, this.parent, this.categories, this.category).then(response => {
                    if(this.categorySave.id === 0) {
                        Materialize.toast('Categoria adicionada com sucesso!', 4000);
                    } else {
                        Materialize.toast('Categoria alterada com sucesso!', 4000);
                    }
                    this.resetScope();
                });
            },
            destroy() {
                this.resource().destroy(this.categoryDelete, this.parent, this.categories)
                    .then(response => {
                        Materialize.toast('categoria excluída com sucesso!', 4000);
                        this.resetScope();
                    });
            },
            modalNew(category) {
                this.title = 'Nova Categoria';
                this.categorySave = {
                    id: 0,
                    nome: '',
                    parent_id: category === null ? null : category.id
                };
                this.parent = category;
                $(`#${this.modalOptionsSave.id}`).modal('open');
            },
            modalEdit(category, parent) {
                this.title = 'Editar Categoria';
                this.categorySave = {
                    id: category.id,
                    nome: category.nome,
                    parent_id: category.parent_id
                };
                this.category = category;
                this.parent = parent;
                $(`#${this.modalOptionsSave.id}`).modal('open');
            },
            modalDelete(category, parent) {
                this.title = 'Excluir Categoria';
                this.categoryDelete = category;
                this.parent = parent;
                this.categorySave = {
                    id: category.id,
                    nome: category.nome,
                    parent_id: category.parent_id
                };
                this.category = category;
                this.parent = parent;
                $(`#${this.modalOptionsDelete.id}`).modal('open');
            },
            formatCategories() {
                this.categoriesFormatadas = categoryFormat.getcategoriesFormatadas(this.categories);
            },
            resetScope() {
                this.categorySave = {
                    id: 0,
                    nome: '',
                    parent_id: 0
                };
                this.categoryDelete = null;
                this.category = null;
                this.parent = null;
                this.formatCategories();
            }
        },
        events: {
            'category-new'(category) {
                this.modalNew(category);
            },
            'category-edit'(category, parent) {
                this.modalEdit(category, parent);
            },
            'category-delete'(category, parent) {
                this.modalDelete(category, parent);
            }
        }
    }