<template>
    <div>
        <!--查詢form-->
        <form v-if="formInputs" v-on:submit.prevent="loadData()" class="row mb-4">
            <div v-for="(formInput,index) in formInputs"
                 :class="(index === 0 ? 'pl-md-0' : '') + ' col-12 ' + formInput.class">
                <search-input @update-value="getChildValue" :input-type="formInput.type"
                              :value="fields.hasOwnProperty(formInput.inputAttrs.name)?fields[formInput.inputAttrs.name]:''"
                              :input-attrs="formInput.inputAttrs"></search-input>
            </div>
            <div class="col-2">
                <br>
                <button type="submit" class="btn btn-primary">查詢</button>
            </div>
        </form>

        <!--查詢條件-->
        <search-condition :attrs="condition.attrs" :values="condition.values"
                          :meta="this.data.hasOwnProperty('meta') ? this.data.meta : {}">
        </search-condition>

        <!--報表顯示-->
        <div class="row mt-2">
            <input-remark-message :remark="this.remark" div-class="col-12 pl-0 pr-0"></input-remark-message>
        </div>

        <div class="row mt-4">
            <div v-if="Object.keys(data).length === 0" class="pl-0 col-12">
                選擇條件查無資料
            </div>
            <div v-else class="col-12">
                <div v-for="(reportSetting,index) in data">
                    <h2>{{ reportSetting['title'] }}</h2>
                    <bar-chart v-if="reportSetting['type'] === 'Bar'" :chartdata-setting="reportSetting['chartdata']" :option-setting="reportSetting['option']"></bar-chart>
                    <line-chart v-if="reportSetting['type'] === 'Line'" :chartdata-setting="reportSetting['chartdata']" :option-setting="reportSetting['option']"></line-chart>
                    <div v-if="reportSetting['type'] === 'Pie'" class="row">
                        <div  class="col-md-6 col-12">
                            <pie-chart  :chartdata-setting="reportSetting['chartdata']" :option-setting="reportSetting['option']"></pie-chart>
                        </div>
                        <div class="col-md-6 col-12">
                            <chart-table :chartdata="reportSetting['chartdata']"></chart-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        formInputs: {
            type: Array,
            default: function () {
                return []
            }
        },
        url: {
            type: String,
            default: ''
        },
        defaultFields: {
            type: Object,
            default: function () {
                return {}
            }
        },
        remark: {
            type: Object,
            default: function () {
                return {
                    class: 'alert alert-warning',
                    content: '',
                };
            }
        },
    },
    data() {
        return {
            data: {},
            fields: this.defaultFields,
            condition: {
                values: {},
                attrs: [...this.formInputs],
            },
        };
    },
    mounted() {
        this.loadData();
    },
    methods: {
        getChildValue: function (childObj) {
            this.fields[childObj.key] = childObj.value;
        },
        loadData: function () {
            axios.get(`/api/${this.url}`, {params: this.fields})
                .then(response => {
                    this.data = response.data;
                    this.condition.values = {...this.fields};
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
    },
}
</script>
