<template>
    <!--    <form v-on:submit.prevent="saveForm()">-->
    <!--        <input-row inputType="text" :errors="errors" @update-value="getChildValue" v-model="this.fields.chineseName"-->
    <!--                   :inputAttrs="{title:'中文名稱',name:'chineseName',isRequired:true}"></input-row>-->
    <!--        <input-row inputType="text" :errors="errors" @update-value="getChildValue" v-model="this.fields.englishName"-->
    <!--                   :inputAttrs="{title:'英文名稱',name:'englishName',isRequired:true}"></input-row>-->
    <!--        <input-row inputType="text" :errors="errors" @update-value="getChildValue" v-model="this.fields.code"-->
    <!--                   :inputAttrs="{title:'遊戲代號',name:'code'}"></input-row>-->
    <!--        <input-row inputType="select" :errors="errors" @update-value="getChildValue" v-model="this.fields.type"-->
    <!--                   :inputAttrs="{title:'遊戲類型',name:'type',isRequired:true,list:gameTypeList}"></input-row>-->
    <!--        <submit-row title="更新"></submit-row>-->
    <!--    </form>-->

    <form v-if="formInputs" v-on:submit.prevent="saveForm()">
        <div v-for="(formInput) in formInputs" :class="' col-12 ' + formInput.class">
            <input-row :input-type="formInput.type" :class="formInput.class" :remark="formInput.remark" :errors="errors"
                       @update-value="getChildValue"
                       v-model="fields[formInput.inputAttrs.name]" :input-attrs="formInput.inputAttrs"></input-row>
        </div>
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
            fields: this.getDefaultField(),
            errors: {},
        };
    },
    props: ['formInputs', 'url', 'uuid'],
    methods: {
        getChildValue: function (childObj) {
            this.fields[childObj.key] = childObj.value;
        },
        loadData: function () {
            axios.get(`/api/${this.url}`, {params: {uuid: this.uuid}})
                .then(response => {
                    this.fields = response.data.data[0];
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        saveForm: function () {
            axios.post(`/api/${this.url}/${this.uuid}`, this.fields)
                .then(response => {
                    this.errors = {};
                    flash(response.data.data.showTitle + ' 更新成功！', 'success');

                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    flash('更新失敗，錯誤訊息: ' + error.response.data.message, 'danger');
                });
        },
        getDefaultField: function () {
            let fields = {};
            this.formInputs.forEach(function (formInput) {
                fields[formInput.inputAttrs.name] = '';
            });
            return fields;
        },
    }
}
</script>
