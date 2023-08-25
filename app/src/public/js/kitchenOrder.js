export default {
    props: {
      data: Object,
    },

    data() {
      return this.data
    },

    computed: {
      waitingTime() {
        const time = {
          minute: Math.floor(this.waitingSeconds / 60),
          second: Math.floor(this.waitingSeconds) % 60,
        }
        return time.minute.toString().padStart(2, 0) + ':' + time.second.toString().padStart(2, 0)
      }
    },

    template: `
        <div class="kdsItem">
            <div class="table">
              <span> {{table}} </h1>
            </div>
            <div class="waitingTime">
              <span> {{waitingTime}} </span>
            </div>

            <table>
              <thead>
                <tr> <td> Qty </td> <td> Description </td> </tr>
              </thead>
              <tbody>
                <tr v-for="item in items"> <td> {{ item.quantity }} </td> <td> {{ item.description }}</td></tr>
              </tbody>
            </table>
        </div>`
  }