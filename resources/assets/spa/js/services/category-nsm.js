import { CategoryRevenue, CategoryExpense } from './resources';

export class categoryFormat {
    static getcategoriesFormatadas(categories) {
        let categoriesFormatadas = this._formatCategories(categories);
        categoriesFormatadas.unshift({
            id: 0,
            text: 'Nenhuma categoria',
            level: 0,
            hasChildren: false
        });
        return categoriesFormatadas;
    }

    static _formatCategories(categories, categoryCollection = []) {
        for (let category of categories) {
            let categoryNew = {
                id: category.id,
                text: category.nome,
                level: category.depth,
                hasChildren: category.children.data.length > 0
            };
            categoryCollection.push(categoryNew);
            this._formatCategories(category.children.data, categoryCollection);
        }
        return categoryCollection;
    }
}

export class CategoryService {

    constructor(type) {
        this.resource = type == 'revenue' ? CategoryRevenue : CategoryExpense;
    }

    save(category, parent, categories, categoryOriginal) {
        if (category.id === 0) {
            return this.new(category, parent, categories);
        } else {
            return this.edit(category, parent, categories, categoryOriginal);
        }
    }

    new(category, parent, categories) {
        let categoryClone = $.extend(true, {}, category);
        if (categoryClone.parent_id === null) {
            delete categoryClone.parent_id;
        }
        return this.resource.save(categoryClone).then(response => {
            let categoryAdd = response.data.data;
            if (categoryAdd.parent_id === null) {
                categories.push(categoryAdd);
            } else {
                parent.children.data.push(categoryAdd);
            }
            return response;
        });
    }

    edit(category, parent, categories, categoryOriginal) {
        let categoryClone = $.extend(true, {}, category);
        if (categoryClone.parent_id === null) {
            delete categoryClone.parent_id;
        }
        let self = this;
        return this.resource.update({ id: categoryClone.id }, categoryClone).then(response => {
            let categoryUpdate = response.data.data;
            if (categoryUpdate.parent_id === null) {
                /*
                category alterada, está sem pai e antes ela tinha um pai
                */
                if (parent) {
                    parent.children.data.$remove(categoryOriginal);
                    categories.push(categoryUpdate);
                    return response;
                }
            } else {
                /*
                category alterada, tem pai
                */
                if (parent) {
                    /*
                    Trocar category de pai
                    */
                    if (parent.id != categoryUpdate.parent_id) {
                        parent.children.data.$remove(categoryOriginal);
                        CategoryService._addChild(categoryUpdate, categories);
                        return response;
                    }
                } else {
                    /*
                    Tornar a Categoria Pai em um filho
                    */
                    categories.$remove(categoryOriginal);
                    CategoryService._addChild(categoryUpdate, categories);
                    return response;
                }
            }
            /*
            Alteração somente no nome da category, atualizar as informações na árvore
            */
            if (parent) {
                let index = parent.children.data.findIndex(element => {
                    return element.id == categoryUpdate.id;
                });
                parent.children.data.$set(index, categoryUpdate);
            } else {
                let index = categories.findIndex(element => {
                    return element.id == categoryUpdate.id;
                });
                categories.$set(index, categoryUpdate);
            }
            return response;
        });
    }

    destroy(category, parent, categories) {
        return this.resource.delete({ id: category.id }).then(response => {
            if (parent) {
                parent.children.data.$remove(category);
            } else {
                categories.$remove(category);
            }
            return response;
        });
    }

    query() {
        return this.resource.query();
    }

    static _addChild(child, categories) {
        let parent = this._findParent(child.parent_id, categories);
        parent.children.data.push(child);
    }

    static _findParent(id, categories) {
        let result = null;
        for (let category of categories) {
            if (id == category.id) {
                result = category;
                break;
            }
            result = this._findParent(id, category.children.data);
            if (result) {
                break;
            }
        }
        return result;
    }
}