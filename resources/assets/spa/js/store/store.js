import Vuex from 'vuex';
import auth from './auth';
import contaBancaria from './conta-bancaria';
import banco from './banco';
import categoryModule from './category';
import billModule from './bill';

import {CategoryRevenue, CategoryExpense} from '../services/resources';
import {BillPay} from '../services/resources';

let categoryRevenue = categoryModule(), categoryExpense = categoryModule();
categoryRevenue.state.resource = CategoryRevenue;
categoryExpense.state.resource = CategoryExpense;

let billPay = billModule();
billPay.state.resource = BillPay;

export default new Vuex.Store({
    modules: {
        auth,
        contaBancaria,
        banco,
        categoryRevenue,
        categoryExpense,
        billPay
    }
});