<template>
    <table class='table  table-bordered table-condensed table-hover ' style="width:auto;">
        <!--表頭-->
        <thead>
        <tr>
            <td class="text-center">序</td>
            <td class="text-center">名稱</td>
            <td class="text-center">{{ chartdata.datasets[0].label }}</td>
            <td class="text-center"  v-if="chartdata.isShowPercentage">比例</td>
        </tr>
        </thead>
        <!--表身-->
        <tbody>
        <tr v-for="(label,index) in chartdata.labels" :set="value = chartdata.datasets[0].data[index]">
            <!--序-->
            <td class="text-center">
                {{ index + 1 }}
            </td>
            <!--名稱-->
            <td>
                <div v-if="chartdata.datasets[0].backgroundColor.hasOwnProperty(index)" class="box" :style="'background-color:'+chartdata.datasets[0].backgroundColor[index] "></div>
                {{ label }}
            </td>
            <!--值-->
            <td class="text-right">
                {{ format(value, chartdata.datasets[0].format) }}
            </td>
            <!--比例-->
            <td class="text-right" v-if="chartdata.isShowPercentage">{{ getPercentage(value) }}</td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">總和</td>
            <!--值-->
            <td class="text-right">
                {{ format(this.valueTotal, chartdata.datasets[0].format) }}
            </td>
            <!--比例-->
            <td class="text-right"  v-if="chartdata.isShowPercentage">
                {{ getPercentage(this.valueTotal) }}
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "ChartTable",
    props: ['chartdata'],
    data() {
        return {
            valueTotal: 0
        };
    },
    mounted() {
        let total = 0;
        this.chartdata.datasets[0].data.forEach(function (dataValue) {
            total += dataValue;
        });
        this.valueTotal = total;
    },
    methods: {
        getPercentage: function (value) {
            return this.valueTotal ? ((value / this.valueTotal) * 100).toFixed(2) + '%' : 0;
        },
        format(value, filter) {
            return filter ? Vue.filter(filter)(value) : value;
        },
    },

}
</script>

<style>
.box {
    float: left;
    height: 20px;
    width: 20px;
    margin-bottom: 15px;
    border: 1px solid black;
    clear: both;
    margin-right: 5px;

    background-color: #DC3912

}

</style>
