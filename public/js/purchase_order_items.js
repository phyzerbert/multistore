
var app = new Vue({
    el: '#app',

    data: {
        order_items: [],
        products: [],
        selected_product: '',
        total: {
            quantity: 0,
            cost: 0
        }
    },


    methods:{
        init() {
            axios.get('/get_products')
                .then(response => {
                    this.products = response.data;
                    // console.log(response.data)
                })
                .catch(error => {
                    console.log(error);
                });
        },
        get_product(i) {
            const data = new FormData();
            data.append('id', this.order_items[i].product_id);

            axios.post('/get_product', data)
                .then(response => {
                    this.order_items[i].cost = response.data.cost
                    this.order_items[i].tax_name = response.data.tax.name
                    this.order_items[i].tax_rate = response.data.tax.rate
                    this.order_items[i].quantity = 1
                    this.order_items[i].sub_total = response.data.cost + (response.data.cost*response.data.tax.rate)/100
                })
                .catch(error => {
                    console.log(error);
                });
        },
        add_item() {
            this.order_items.push({
                product_id: "",
                cost: 0,
                tax_name: "",
                tax_rate: 0,
                quantity: 0,
                expiry_date: "",
                sub_total: 0,
            })
        },
        calc_subtotal() {
            data = this.order_items
            let total_quantity = 0;
            let total_cost = 0;
            for(let i = 0; i < data.length; i++) {
                this.order_items[i].sub_total = (parseInt(data[i].cost) + (data[i].cost*data[i].tax_rate)/100) * data[i].quantity
                total_quantity += parseInt(data[i].quantity)
                total_cost += data[i].sub_total
            }

            this.total.quantity = total_quantity
            this.total.cost = total_cost
        },
        remove(i) {
            this.order_items.splice(i, 1)
        }
    },

    mounted:function() {
        this.init();
    },
    updated: function() {
        this.calc_subtotal()
        // $(".expiry_date").datepicker({
        //     dateFormat: 'yy-mm-dd',
        // });
        // $(".product").select2();
    }
});
