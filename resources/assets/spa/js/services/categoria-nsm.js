import { Categoria } from './resources';

export class CategoriaFormat {
    static getCategoriasFormatadas(categorias) {
        let categoriasFormatadas = this._formataCategorias(categorias);
        categoriasFormatadas.unshift({
            id: 0,
            text: 'Nenhuma categoria',
            level: 0,
            hasChildren: false
        });
        return categoriasFormatadas;
    }

    static _formataCategorias(categorias, categoriaCollection = []) {
        for (let categoria of categorias) {
            let categoriaNew = {
                id: categoria.id,
                text: categoria.nome,
                level: categoria.depth,
                hasChildren: categoria.children.data.length > 0
            };
            categoriaCollection.push(categoriaNew);
            this._formataCategorias(categoria.children.data, categoriaCollection);
        }
        return categoriaCollection;
    }
}

export class CategoriaService {

    static save(categoria, parent, categorias, categoriaOriginal) {
        if (categoria.id === 0) {
            return this.new(categoria, parent, categorias);
        } else {
            return this.edit(categoria, parent, categorias, categoriaOriginal);
        }
    }

    static new(categoria, parent, categorias) {
        let categoriaClone = $.extend(true, {}, categoria);
        if (categoriaClone.parent_id === null) {
            delete categoriaClone.parent_id;
        }
        return Categoria.save(categoriaClone).then(response => {
            let categoriaAdd = response.data.data;
            if (categoriaAdd.parent_id === null) {
                categorias.push(categoriaAdd);
            } else {
                parent.children.data.push(categoriaAdd);
            }
            return response;
        });
    }

    static edit(categoria, parent, categorias, categoriaOriginal) {
        let categoriaClone = $.extend(true, {}, categoria);
        if (categoriaClone.parent_id === null) {
            delete categoriaClone.parent_id;
        }
        let self = this;
        return Categoria.update({ id: categoriaClone.id }, categoriaClone).then(response => {
            let categoriaUpdate = response.data.data;
            if (categoriaUpdate.parent_id === null) {
                /*
                Categoria alterada, está sem pai e antes ela tinha um pai
                */
                if (parent) {
                    parent.children.data.$remove(categoriaOriginal);
                    categorias.push(categoriaUpdate);
                    return response;
                }
            } else {
                /*
                Categoria alterada, tem pai
                */
                if (parent) {
                    /*
                    Trocar categoria de pai
                    */
                    if (parent.id != categoriaUpdate.parent_id) {
                        parent.children.data.$remove(categoriaOriginal);
                        self._addChild(categoriaUpdate, categorias);
                        return response;
                    }
                } else {
                    /*
                    Tornar a categoria pai em um filho
                    */
                    categorias.$remove(categoriaOriginal);
                    self._addChild(categoriaUpdate, categorias);
                    return response;
                }
            }
            /*
            Alteração somente no nome da categoria, atualizar as informações na árvore
            */
            if (parent) {
                let index = parent.children.data.findIndex(element => {
                    return element.id == categoriaUpdate.id;
                });
                parent.children.data.$set(index, categoriaUpdate);
            } else {
                let index = categorias.findIndex(element => {
                    return element.id == categoriaUpdate.id;
                });
                categorias.$set(index, categoriaUpdate);
            }
            return response;
        });
    }

    static destroy(categoria, parent, categorias) {
        return Categoria.delete({ id: categoria.id }).then(response => {
            if (parent) {
                parent.children.data.$remove(categoria);
            } else {
                categorias.$remove(categoria);
            }
            return response;
        });
    }

    static _findParent(id, categorias) {
        let result = null;
        for (let categoria of categorias) {
            if (id == categoria.id) {
                result = categoria;
                break;
            }
            result = this._findParent(id, categoria.children.data);
            if (result) {
                break;
            }
        }
        return result;
    }

    static _addChild(child, categorias) {
        let parent = this._findParent(child.parent_id, categorias);
        parent.children.data.push(child);
    }
}