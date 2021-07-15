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

        <!--總和結果-->
        <div v-for="(summaryText,index) in this.summaryTexts" class="row mb-3">
            <span class="font-weight-bolder col-12 pl-0">{{ summaryText.title }}</span>
            <span v-for="(text) in summaryText.texts" class="col-12 pl-0">{{ text }}</span>
        </div>

        <!--查詢結果-->
        <div class="row">
            <vue-table :tableOptions="tableOptions" :rows="this.data.hasOwnProperty('data') ? this.data.data : []" :url="this.url"></vue-table>
        </div>

        <!--分頁-->
        <div class="row">
            <pagination :data="this.data" @pagination-change-page="loadData" :limit="10"></pagination>
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
        tableOptions: {
            type: Object,
            default: function () {
                return {}
            }
        },
        url: {
            type: String,
            default: ''
        },
        isShowSummary: {
            type: Boolean,
            default: false
        },
        defaultFields: {
            type: Object,
            default: function () {
                return {}
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
            sort: {
                column: this.tableOptions.columns[0].name,
                isDesc: false,
            },
            summaryTexts: {},
        };
    },
    mounted() {
        this.loadData();
    },
    methods: {
        getChildValue: function (childObj) {
            this.fields[childObj.key] = childObj.value;
        },
        loadData: function (page = 1) {
            axios.get(`/api/${this.url}`, {params: Object.assign({'page': page}, this.fields)})
                .then(response => {
                    let rows = response.data.data;
                    //設定序
                    let serial = response.data.meta.from;
                    rows.forEach(function (value, index, array) {
                        rows[index].serial = serial;
                        serial++;
                    });
                    response.data.data = rows;
                    this.data = response.data;
                    this.condition.values = {...this.fields};
                })
                .catch(function (error) {
                    console.log(error);
                });
            if (this.isShowSummary) {
                axios.get(`/api/${this.url}/summary`, {params: Object.assign({'page': page}, this.fields)})
                    .then(response => {
                        this.summaryTexts = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        deleteRow(uuid, index) {
            if (confirm(`確定刪除「${this.data.data[index].showTitle}」?`)) {
                axios.delete(`/api/${this.url}/${uuid}`)
                    .then(response => {
                        this.data.data.splice(index, 1);
                        flash(response.data.message, 'success');
                    })
                    .catch(error => {
                        flash(error.response.data.message, 'danger');
                    })
            }
        },
    },
}
</script>

<style>
.table th.click {
    cursor: pointer;
}

.table th.click {
    cursor: pointer;
}
</style>
