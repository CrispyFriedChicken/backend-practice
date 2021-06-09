<template>
    <input :id="name" :type="type" class="form-control" :name="name" v-model="childValue" :required="isRequired"
           :autocomplete="isAutocomplete ? name : false" @input="sendToParent">
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
            childValue: this.inputAttrs.hasOwnProperty('value') ? this.inputAttrs.value : '',
            title: this.inputAttrs.hasOwnProperty('title') ? this.inputAttrs.title : '',
            name: this.inputAttrs.hasOwnProperty('name') ? this.inputAttrs.name : '',
            type: this.inputAttrs.hasOwnProperty('name') ? this.inputAttrs.type : '',
            isAutocomplete: this.inputAttrs.hasOwnProperty('isAutocomplete') ? this.inputAttrs.isAutocomplete : '',
            isRequired: this.inputAttrs.hasOwnProperty('isRequired') ? this.inputAttrs.isRequired : false,
        };
    },
    watch: {
        value: function () {
            this.childValue = this.value;
            console.log('TextInput Watch Event!');
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
