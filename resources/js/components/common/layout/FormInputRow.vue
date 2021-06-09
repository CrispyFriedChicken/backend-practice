<template>
    <div class="form-group row">
        <label :for="name" class="col-md-4 col-form-label text-md-right"
               :class="this.errors.hasOwnProperty(name)?'text-danger':''">
            {{ title }}
        </label>
        <div class="col-md-6">
            <text-input v-if="this.inputType === 'text'" :inputAttrs="inputAttrs" v-model="value"
                        v-on="$listeners"></text-input>
            <select-input v-else-if="this.inputType === 'select'" :inputAttrs="inputAttrs" v-model="value"
                          v-on="$listeners"></select-input>
            <input-error-message :errors="this.errors" :name="name"></input-error-message>
        </div>
    </div>
</template>

<script>
export default {
    name: "FormInputRow",
    props: {
        inputAttrs: {
            type: Object,
            default: function () {
                return {}
            }
        },
        inputType: {
            type: String,
            default: ''
        },
        errors: {
            type: Object,
            default: function () {
                return {}
            }
        },
        value: {
            type: String,
            default: ''
        },
    },
    data() {
        return {
            title: this.inputAttrs.hasOwnProperty('title') ? this.inputAttrs.title : '',
            name: this.inputAttrs.hasOwnProperty('name') ? this.inputAttrs.name : '',
        };
    },
}
</script>

<style scoped>

</style>
