<script>
import {Line} from 'vue-chartjs'

export default {
    name: "LineChart",
    extends: Line,
    data: () => ({
        options: {
            responsive: true,
            maintainAspectRatio: false
        },
        chartdata: {},
    }),
    props: {
        chartdataSetting: {
            type: Object,
            default: function () {
                return {}
            }
        },
        optionsSetting: {
            type: Object,
            default: function () {
                return {
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        },
    },
    watch: {
        chartdataSetting: function () {
            this.renderChart(this.chartdataSetting, this.optionsSetting)
        }
    },
    mounted() {
        this.chartdata = this.chartdataSetting;
        this.options = this.optionsSetting;
        this.renderChart(this.chartdata, this.options)
    }
}
</script>
