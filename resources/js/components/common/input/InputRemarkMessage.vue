<template>
    <div v-if="this.remark.hasOwnProperty('content') && this.remark.content">
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
            type: Array,
            default: function () {
                let remarkArray = [];
                remarkArray['class'] = 'alert alert-warning';
                remarkArray['content'] = '';
                return remarkArray;
            }
        },
    },
}
</script>

<style scoped>

</style>
