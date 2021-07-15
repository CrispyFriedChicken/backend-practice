<template>
    <div v-if="this.errors.hasOwnProperty(name)">
        <div class="text-danger" v-for="(error,key,index) of errors[name]">
            {{ error }}
            <br v-if="index !== Object.keys(errors[name]).length - 1">
        </div>
    </div>
</template>

<script>
export default {
    name: "InputErrorMessage",
    props: {
        name: {
            type: String,
            default: {}
        },
        errors: {
            type: Object,
            default: function () {
                return {}
            }
        },
    },
}
</script>

<style scoped>

</style>
