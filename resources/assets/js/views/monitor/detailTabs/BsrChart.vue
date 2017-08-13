<script>
    import { Line } from 'vue-chartjs'

    export default Line.extend({
        props: {
            data: {
                type: Object,
                required: true
            },
        },
        
        mounted () {
            this.renderChart({
                labels: this.data.labels,
                datasets: this.data.datasets
            }, {
                responsive: true,
                maintainAspectRatio: false,
            })
        }
    })
</script>
