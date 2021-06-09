<template>
    <form v-on:submit.prevent="saveForm()">
        <input-row inputType="text" :errors="errors" @update-value="getChildValue" v-model="this.fields.chineseName"
                   :inputAttrs="{title:'中文名稱',name:'chineseName',isRequired:true}"></input-row>
        <input-row inputType="text" :errors="errors" @update-value="getChildValue" v-model="this.fields.englishName"
                   :inputAttrs="{title:'英文名稱',name:'englishName',isRequired:true}"></input-row>
        <input-row inputType="text" :errors="errors" @update-value="getChildValue" v-model="this.fields.code"
                   :inputAttrs="{title:'遊戲代號',name:'code'}"></input-row>
        <input-row inputType="select" :errors="errors" @update-value="getChildValue" v-model="this.fields.type"
                   :inputAttrs="{title:'遊戲類型',name:'type',isRequired:true,dropDownList:gameTypeList}"></input-row>
        <submit-row title="更新"></submit-row>
    </form>
</template>
<script>
export default {
    mounted() {
        this.loadData();
    },
    data() {
        return {
            fields: {
                chineseName: '',
                englishName: '',
                code: '',
                type: '',
            },
            errors: {},
        };
    },
    props: ['gameTypeList', 'uuid'],
    methods: {
        getChildValue: function (childObj) {
            this.fields[childObj.key] = childObj.value;
        },
        loadData: function () {
            axios.get(`/api/games`, {params: {uuid: this.uuid}})
                .then(response => {
                    this.fields = response.data.data[0];
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        saveForm: function () {
            axios.post(`/api/games/${this.uuid}`, this.fields)
                .then(response => {
                    let updatedData = response.data.data;
                    this.errors = {};
                    flash(`遊戲 ${updatedData.code} - ${updatedData.chineseName} ( ${updatedData.englishName} ) 更新成功！`, 'success');
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    flash(`遊戲更新失敗，錯誤訊息：${error.response.data.message}`, 'danger');
                });
        }
    }
}
</script>
