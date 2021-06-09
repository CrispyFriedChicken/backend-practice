<template>
    <select :id="name" class="form-control" :name="name" v-model="childValue" @change="sendToParent"
            :required="isRequired">
        <option v-for="(key,val) in list" :value="val">
            {{ key }}
        </option>
    </select>
</template>

<script>
export default {
    name: "SelectInput",
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
            placeHolder: this.inputAttrs.hasOwnProperty('placeHolder') ? this.inputAttrs.placeHolder : '請選擇',
            isRequired: this.inputAttrs.hasOwnProperty('isRequired') ? this.inputAttrs.isRequired : false,
            list: this.inputAttrs.hasOwnProperty('dropDownList') ? this.inputAttrs.dropDownList : {},
        };
    },
    watch: {
        value: function () {
            this.childValue = this.value;
        }
    },
    mounted() {
        this.list = Object.assign({'': this.placeHolder}, this.list)
    },
    methods: {
        sendToParent: function () {
            this.$emit('update-value', {
                key: this.name,
                value: this.childValue
            });
        },
    },
}
</script>

<style scoped>

</style>
