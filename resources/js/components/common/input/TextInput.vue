<template>
    <input :id="name" :type="type" class="form-control" :name="name" v-model="childValue" :required="isRequired" :placeholder="placeholder"
           :disabled="isDisabled" :readonly="isReadOnly"
           :autocomplete="isAutocomplete ? 'on' : 'off'" @input="sendToParent">
</template>

<script>
export default {
    name: "TextInput",
    props: {
        inputAttrs: {
            type: Object,
            default: function () {
                return {}
            }
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
            childValue: this.value,
            title: this.inputAttrs.hasOwnProperty('title') ? this.inputAttrs.title : '',
            name: this.inputAttrs.hasOwnProperty('name') ? this.inputAttrs.name : '',
            type: this.inputAttrs.hasOwnProperty('type') ? this.inputAttrs.type : '',
            placeholder: this.inputAttrs.hasOwnProperty('placeholder') ? this.inputAttrs.placeholder : false,
            isAutocomplete: this.inputAttrs.hasOwnProperty('isAutocomplete') ? this.inputAttrs.isAutocomplete : false,
            isReadOnly: this.inputAttrs.hasOwnProperty('isReadOnly') ? this.inputAttrs.isReadOnly : false,
            isDisabled: this.inputAttrs.hasOwnProperty('isDisabled') ? this.inputAttrs.isDisabled : false,
            isRequired: this.inputAttrs.hasOwnProperty('isRequired') ? this.inputAttrs.isRequired : false,
        };
    },
    watch: {
        value: function () {
            this.childValue = this.value;
        }
    },
    methods: {
        sendToParent: function () {
            this.$emit('update-value', {
                key: this.name,
                value: this.childValue
            });
        }
    },
}
</script>

<style scoped>

</style>
