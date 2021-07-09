<template>
    <table class='table  table-bordered table-condensed table-hover table-responsive' style="width:auto;">
        <!--表頭-->
        <thead>
        <tr>
            <th class="text-center click" v-for="column in tableOptions.columns"
                @click="sortColumn(column)" :class="column.headerClass" :style="column.headerStyle">
                {{ column.title }}
                <i class="text-success fa" :class="sort.isDesc ? 'fa-angle-down' : 'fa-angle-up'"
                   v-if="sort.column === column.name && column.type !== 'action'"></i>
            </th>
        </tr>
        </thead>
        <!--表身-->
        <tbody>
        <tr v-for="(row,index) in sortData">
            <td v-for="column in tableOptions.columns"
                :class="column.rowClass + (column.type === 'money' ? 'text-right' : '')"
                :style="column.rowStyle" class="hiddenLongString">
                <!--值-->
                <span v-if="column.type === 'text'">{{
                        column.list ? column.list[row[column.name]] : row[column.name]
                    }}</span>
                <span v-else-if="column.type === 'money'">{{ row[column.name] |money }}</span>
                <!--連結-->
                <a v-else-if="column.type === 'link'" :class="column.class" target="_blank" :href="row[column.name]">{{ column.text }}</a>
                <!--按鈕-->
                <div v-for="button in column.buttons" style="display:inline">
                    <a v-if="button === '編輯'" class="btn btn-sm btn-primary"
                       :href="`/${url}/update?uuid=${row.uuid}`">編輯</a>
                    <button v-if="button === '刪除'" class="btn btn-sm btn-danger"
                            @click="deleteRow(row.uuid , index)">
                        刪除
                    </button>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "Table",
    props: ['tableOptions', 'rows', 'url'],
    data() {
        return {
            sort: {
                column: this.tableOptions.columns[0].name,
                isDesc: false,
            },
        };
    },
    methods: {
        sortColumn: function (sortColumn) {
            if (sortColumn.type !== 'action') {
                let vm = this;
                if (vm.sort.column === sortColumn.name) {
                    vm.sort.isDesc = !vm.sort.isDesc;
                } else {
                    vm.sort.isDesc = false;
                }
                vm.sort.column = sortColumn.name;
            }
        },
        deleteRow(uuid, index) {
            this.$parent.deleteRow(uuid, index);
        },
    },
    computed: {
        sortData() {
            let vm = this;
            let sortColumn = vm.sort.column;
            let isDesc = vm.sort.isDesc;
            let result = [];
            if (this.rows) {
                console.log('this.rows', this.rows);
                result = this.rows.sort(function (a, b) {
                    if (isDesc) {
                        return a[sortColumn] > b[sortColumn] ? -1 : 1;
                    } else {
                        return a[sortColumn] > b[sortColumn] ? 1 : -1;
                    }
                });
            }
            return result;
        }
    },
    filters: {
        money(value) {
            return '$ ' + new Intl.NumberFormat().format(value);
        }
    }
}
</script>

<style scoped>

</style>
