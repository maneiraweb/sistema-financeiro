
const USER = 'user';

const findParent = (id, categories) => {
    let result = null;
    for (let category of categories) {
        if (id == category.id) {
            result = category;
            break;
        }
        result = findParent(id, category.children.data);
        if (result) {
            break;
        }
    }
    return result;
};

export default () => {

    const addChild = (child, categories) => {
        let parent = findParent(child.parent_id, categories);
        parent.children.data.push(child);
    };

    const formatCategories = (categories, categoryCollection = []) => {
        for (let category of categories) {
            let categoryNew = {
                id: category.id,
                text: category.nome,
                level: category.depth,
                hasChildren: category.children.data.length > 0
            };
            categoryCollection.push(categoryNew);
            formatCategories(category.children.data, categoryCollection);
        }
        return categoryCollection;
    }

    const state = {
        categories: [],
        category: null,
        parent: null,
        resource: null
    };

    const mutations = {
        set(state, categories) {
            state.categories = categories;
        },
        add(state) {
            if (state.category.parent_id === null) {
                state.categories.push(state.category);
            } else {
                state.parent.children.data.push(state.category);
            }
        },
        edit(state, categoryUpdated) {
            if (categoryUpdated.parent_id === null) {
                /*
                category alterada, está sem pai e antes ela tinha um pai
                */
                if (state.parent) {
                    state.parent.children.data.$remove(state.category);
                    state.categories.push(categoryUpdated);
                    return;
                }
            } else {
                /*
                category alterada, tem pai
                */
                if (state.parent) {
                    /*
                    Trocar category de pai
                    */
                    if (state.parent.id != categoryUpdated.parent_id) {
                        state.parent.children.data.$remove(state.category);
                        addChild(categoryUpdated, state.categories);
                        return;
                    }
                } else {
                    /*
                    Tornar a Categoria Pai em um filho
                    */
                    state.categories.$remove(state.category);
                    addChild(categoryUpdated, state.categories);
                    return;
                }
            }
            /*
            Alteração somente no nome da category, atualizar as informações na árvore
            */
            if (parent) {
                let index = state.parent.children.data.findIndex(element => {
                    return element.id == categoryUpdated.id;
                });
                state.parent.children.data.$set(index, categoryUpdated);
            } else {
                let index = state.categories.findIndex(element => {
                    return element.id == categoryUpdated.id;
                });
                state.categories.$set(index, categoryUpdated);
            }
        },
        'delete'(state) {
            if (state.parent) {
                state.parent.children.data.$remove(state.category);
            } else {
                state.categories.$remove(state.category);
            }
        },
        setCategory(state, category) {
            state.category = category;
        },
        setParent(state, parent) {
            state.parent = parent;
        }
    };

    const actions = {
        query(context) {
            return context.state.resource.query().then((response) => {
                context.commit('set', response.data.data);
                return response;
            });
        },
        'delete'(context) {
            let id = context.state.category.id;
            return context.state.resource.delete({ id: id }).then((response) => {
                context.commit('delete');
                context.commit('setCategory', null);
                return response;
            });
        },
        save(context, category) {
            let categoryClone = $.extend(true, {}, category);
            if (categoryClone.parent_id === null) {
                delete categoryClone.parent_id;
            }
            if (category.id === 0) {
                return context.dispatch('new', categoryClone);
            } else {
                return context.dispatch('edit', categoryClone);
            }
        },
        'new'(context, category) {
            return context.state.resource.save(category).then(response => {
                context.commit('setCategory', response.data.data);
                context.commit('add');
                return response;
            });
        },
        edit(context, category) {
            return context.state.resource.update({ id: category.id }, category).then(response => {
                context.commit('edit', response.data.data);
                return response;
            });
        }
    };

    const getters = {
        categoriesFormatted(state) {
            let categoriesFormatted = formatCategories(state.categories);
            categoriesFormatted.unshift({
                id: 0,
                text: 'Nenhuma categoria',
                level: 0,
                hasChildren: false
            });
            return categoriesFormatted;
        }
    }

    const module = {
        namespaced: true,
        state,
        mutations,
        actions,
        getters
    };

    return module;
};