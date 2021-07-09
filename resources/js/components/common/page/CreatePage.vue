<template>
    <form v-if="formInputs" v-on:submit.prevent="saveForm()">
        <div v-for="(formInput) in formInputs" :class="' col-12 ' + formInput.class">
            <input-row :input-type="formInput.type" :class="formInput.class" :remark="formInput.remark" :errors="errors"
                       @update-value="getChildValue"
                       v-model="fields[formInput.inputAttrs.name]" :input-attrs="formInput.inputAttrs"></input-row>
        </div>
        <submit-row title="新增"></submit-row>
    </form>
</template>
<script>
export default {
    data() {
        return {
            fields: this.getDefaultField(),
            errors: {},
        };
    },
    props: ['formInputs', 'url'],
    methods: {
        getChildValue: function (childObj) {
            this.fields[childObj.key] = childObj.value;
        },
        saveForm: function () {
            axios.post(`/api/${this.url}`, this.fields)
                .then(response => {
                    this.fields = this.getDefaultField();
                    this.errors = {};
                    flash(response.data.data.showTitle + ' 建立成功！', 'success');
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                    flash('建立失敗，錯誤訊息: ' + error.response.data.message, 'danger');
                });
        },
        getDefaultField: function () {
            let fields = {};
            this.formInputs.forEach(function (formInput) {
                fields[formInput.inputAttrs.name] = '';
            });
            return fields;
        },
    },
}
</script>
