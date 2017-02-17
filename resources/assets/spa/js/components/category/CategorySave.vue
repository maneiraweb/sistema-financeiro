<template>
    <div>
        <form name="form" method="POST" @submit.prevent="submit">
            <modal :modal="modalOptions">
                <div slot="content">
                    <h4>
                        <slot name="title"></slot>
                    </h4>
                    <div class="row">
                        <div class="input-field col s12">
                            <label class="active">Nome</label>
                            <input type="text" v-model="category.nome" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select-material :options="cpOptions" :selected.sync="category.parent_id"></select-material>
                            <label class="active">Categoria Pai</label>
                        </div>
                    </div>
                </div>
                <div slot="footer">
                    <slot name="footer"></slot>
                </div>
            </modal>
        </form>
    </div>
</template>

<script type="text/javascript">
    import ModalComponent from '../../../../_default/components/Modal.vue';
    import SelectedMaterialComponent from '../../../../_default/components/SelectMaterial.vue';
    
    export default {
        components: {
            'modal': ModalComponent,
            'select-material': SelectedMaterialComponent
        },
        props: {
            category: {
                type: Object,
                required: true
            },
            modalOptions: {
                title: Object,
                required: true
            },
            cpOptions: {
                type: Object,
                required: true
            }
        },
        methods: {
            submit() {
                this.$emit('save-category');
            }
        }
    }

</script>