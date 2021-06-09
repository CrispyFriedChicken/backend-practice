<template>
    <form v-on:submit.prevent="saveForm()">
        <input-row inputType="text" :errors="errors" @update-value="getChildValue" v-model="fields.chineseName"
                   :inputAttrs="{title:'中文名稱',name:'chineseName',isRequired:true}"></input-row>
        <input-row inputType="text" :errors="errors" @update-value="getChildValue" v-model="fields.englishName"
                   :inputAttrs="{title:'英文名稱',name:'englishName',isRequired:true}"></input-row>
        <input-row inputType="text" :errors="errors" @update-value="getChildValue" v-model="fields.code"
                   :inputAttrs="{title:'遊戲代號',name:'code'}"></input-row>
        <input-row inputType="select" :errors="errors" @update-value="getChildValue" v-model="fields.type"
                   :inputAttrs="{title:'遊戲類型',name:'type',isRequired:true,dropDownList:gameTypeList}"></input-row>
        <submit-row title="建立"></submit-row>
    </form>
</template>
<script>
export default {
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
    props: ['gameTypeList'],
    methods: {
        getChildValue: function (childObj) {
            this.fields[childObj.key] = childObj.value;
        },
        saveForm: function () {
            axios.post('/api/games', this.fields)
                .then(response => {
                    this.fields = {
                        chineseName: '',
                        englishName: '',
                        code: '',
                        type: '',
                    };
                    this.errors = {};
                    let createdData = response.data.data;
                    flash(`遊戲 ${createdData.code} - ${createdData.chineseName} ( ${createdData.englishName} ) 建立成功！`, 'success');
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    flash(`遊戲建立失敗，錯誤訊息：${error.response.data.message}`, 'danger');
                });
        }
    }
}
</script>
