<template>
    <div :class="divClass + 'col-' + this.colCount">
        <span>{{ title }}</span>
        <text-input v-if="this.inputType === 'text'" :inputAttrs="inputAttrs" v-on="$listeners"></text-input>
        <select-input v-else-if="this.inputType === 'select'" :inputAttrs="inputAttrs"
                      v-on="$listeners"></select-input>
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
            default: function () {
                return {}
            }
        },
        colCount: {
            type: Number,
            default: 4
        },
        divClass: {
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
