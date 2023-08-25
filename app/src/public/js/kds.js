import KitchenOrder from './kitchenOrder.js'

export default {
    components: {
        KitchenOrder
    },
    data() {
      return {
        orders: []
      }
    },

    created: function(){

        fetch("kds/getOrders").then(
            async (response) => { this.orders = await response.json() }
        );
    },

    computed: {
        ordersOrdered() {
            return orders.sort((a, b) => a.waitingSeconds - b.waitingSeconds)
        }
    },

    template: `
        <div class="kdsItems">
            <KitchenOrder :data='order' v-for="order in orders"/>
        </div>`
  }