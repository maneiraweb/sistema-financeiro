<template>
    <div>
        <category-tree :categories="categories"></category-tree>

        <category-save :modal-options="modalOptionsSave" :category.sync="categorySave" :cp-options="cpOptions" @save-category="saveCategory">
            <span slot="title">{{title}}</span>
            <div slot="footer">
                <button type="submit" class="btn btn-flat waves-effect green lighten-2 modal-close modal-action">
                        Salvar
                    </button>
                <button type="button" class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
            </div>
        </category-save>

        <modal :modal="modalOptionsDelete">
            <div slot="content" v-if="categoryDelete">
                <h4>Deseja excluir esta categoria?</h4>
                <div class="divider"></div>
                <p>Nome: <strong>{{categoryDelete.nome}}</strong></p>
                <div class="divider"></div>
            </div>
            <div slot="footer">
                <button class="btn btn-flat waves-effect green lighten-2 modal-close modal-action" @click="destroy()">EXCLUIR
                    </button>
                <button class="btn btn-flat waves-effect waves-red modal-close modal-action">Cancelar</button>
            </div>
        </modal>
    </div>
</template>

<script type="text/javascript">
    import categoryMixin from '../../mixins/category-mixin';

    export default {
        mixins: [categoryMixin],
        methods: {
            namespace() {
                return 'categoryExpense';
            }
        },
    }

</script>