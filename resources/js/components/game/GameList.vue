<template>
    <div>
        <form v-on:submit.prevent="loadData()" class="row">
            <input-search inputType="text" @update-value="getChildValue" class="pl-0" :col-count="3"
                          :inputAttrs="{title:'遊戲名稱',name:'gameName'}"></input-search>
            <input-search inputType="text" @update-value="getChildValue" :col-count="3"
                          :inputAttrs="{title:'遊戲代號',name:'code'}"></input-search>
            <input-search inputType="select" @update-value="getChildValue" :col-count="2"
                          :inputAttrs="{title:'遊戲類型',name:'type',dropDownList:gameTypeList,'placeHolder':'全選'}"></input-search>
            <div class="col-2">
                <br>
                <button type="submit" class="btn btn-primary">查詢</button>
            </div>
        </form>

        <div class="row mt-4">
            <table class='table  table-bordered table-condensed table-hover'>
                <thead>
                <tr>
                    <th>中文名稱</th>
                    <th>英文名稱</th>
                    <th>遊戲代號</th>
                    <th>遊戲類型</th>
                    <th>動作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(game,index) in data.data">
                    <td>{{ game.chineseName }}</td>
                    <td>{{ game.englishName }}</td>
                    <td>{{ game.code }}</td>
                    <td>{{ gameTypeList[game.type] }}</td>
                    <td>
                        <a class="btn btn-primary" :href="`/game/update?uuid=${game.uuid}`">編輯</a>
                        <button class="btn btn-danger" @click="deleteRow(game.uuid,index)">刪除</button>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination :data="this.data" @pagination-change-page="loadData"></pagination>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            data: {},
            fields: {},
        };
    },
    mounted() {
        this.loadData();
    },
    props: ['gameTypeList'],
    methods: {
        getChildValue: function (childObj) {
            this.fields[childObj.key] = childObj.value;
        },
        loadData: function (page = 1) {
            axios.get('/api/games', {params: Object.assign({'page': page}, this.fields)})
                .then(response => {
                    this.data = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        deleteRow(uuid, index) {
            let row = this.data.data[index];
            if (confirm(`確定刪除 ${row.code} - ${row.chineseName} ( ${row.englishName} )?`)) {
                axios.delete(`/api/games/${uuid}`)
                    .then(response => {
                        this.data.data.splice(index, 1);
                        flash(response.data.message, 'success');
                    })
                    .catch(error => {
                        flash(`遊戲刪除失敗，錯誤訊息：${error.response.data.message}`, 'danger');
                    })
            }
        },
    }
}
</script>
