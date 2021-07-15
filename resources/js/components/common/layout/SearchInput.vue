<template>
    <div>
        <span>{{ title }}</span>
        <text-input v-if="this.inputType === 'text'" :inputAttrs="inputAttrs" v-model="value" v-on="$listeners"></text-input>
        <select-input v-else-if="this.inputType === 'select'" :inputAttrs="inputAttrs" v-model="value" v-on="$listeners"></select-input>
        <select2-input v-else-if="this.inputType === 'select2'" :inputAttrs="inputAttrs" v-model="value==='' && inputAttrs.hasOwnProperty('multiple') && inputAttrs.multiple ? [] : value" v-on="$listeners"></select2-input>
        <date-input v-else-if="this.inputType === 'date'" :inputAttrs="inputAttrs" v-model="value" v-on="$listeners"></date-input>
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
        value: {
            type: [String, Array],
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
