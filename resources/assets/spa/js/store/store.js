import Vuex from 'vuex';
import auth from './auth';
import contaBancaria from './conta-bancaria';
import banco from './banco';

export default new Vuex.Store({
    modules: {
        auth,
        contaBancaria,
        banco
    }
});