<script>
import { Pie } from 'vue-chartjs'

export default Pie.extend({
  data() {
      return {
        dataPie: []
      }
  },
  methods: {
    getDataInfo() {
      axios.post('/monitor/reviewpie', { listing_id: this.$route.params.productId })
        .then(reponse => {
          var data = []
          if (!_.isEmpty(reponse.data.rate[1])) {
            data[0] = reponse.data.rate[1].count
          } else {
            data[0] = 0

          }
          if (!_.isEmpty(reponse.data.rate[2])) {
            data[1] = reponse.data.rate[2].count

          } else {
            data[1] = 0

          }
          if (!_.isEmpty(reponse.data.rate[3])) {
            data[2] = reponse.data.rate[3].count

          } else {
            data[2] = 0

          }
          if (!_.isEmpty(reponse.data.rate[4])) {
            data[3] = reponse.data.rate[5].count

          } else {
            data[3] = 0

          }
          if (!_.isEmpty(reponse.data.rate[4])) {
            data[4] = reponse.data.rate[5].count

          } else {
            data[4] = 0

          }
          if (!_.isEmpty(reponse.data.is_vp[1])) {
            data[4] = reponse.data.is_vp[1].count

          } else {
            data[4] = 0

          }
          // if (!_.isEmpty(reponse.data.is_vp[0])) {
          //   data[5] = reponse.data.is_vp[0].count
          // } else {
          //   data[5] = 0

          // }

          this.dataPie = data

          this.renderChart({
            labels: ['一星', '二星', '三星', '四星', '五星'],
            datasets: [
              {
                backgroundColor: [
                  '#84C8BC',
                  '#E46651',
                  '#00D8FF',
                  '#43BAB5',
                  '#EA7675',
                ],
                data: this.dataPie
              }
            ]
          }, { responsive: true, maintainAspectRatio: false })

        })
    }
  },
  mounted() {
    this.getDataInfo()

  }
})
</script>