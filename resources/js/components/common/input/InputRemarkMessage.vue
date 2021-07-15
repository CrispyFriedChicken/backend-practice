<template>
    <div v-if="this.remark.hasOwnProperty('content') && this.remark.content" :class="this.divClass">
        <div :class="'mb-0 ' + this.remark.class">
            {{ this.remark.content }}
        </div>
    </div>
</template>

<script>
export default {
    name: "InputRemarkMessage",
    props: {
        remark: {
            type: Object,
            default: function () {
                return {
                    class: 'alert alert-warning',
                    content: '',
                };
            }
        },
        divClass: {
            type: String,
            default: ''
        }
    },
}
</script>

<style scoped>

</style>
