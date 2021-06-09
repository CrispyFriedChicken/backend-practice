<template>
    <div class="form-group row mb-0">
        <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ title }}
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "FormSubmitRow",
    props: {
        title: {
            type: String,
            default: '送出'
        },
    },
}
</script>

<style scoped>

</style>
