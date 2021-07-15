<template>
    <select :id="name" class="form-control select2 " :name="name" v-model="childValue" @change="sendToParent" :multiple="multiple"
            :style="style"
            :required="isRequired">
        <option v-for="(key,val) in dropDownList" :value="val">
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
            type: [String, Array],
            default: ''
        },
    },
    data() {
        return {
            childValue: this.value,
            title: this.inputAttrs.hasOwnProperty('title') ? this.inputAttrs.title : '',
            name: this.inputAttrs.hasOwnProperty('name') ? this.inputAttrs.name : '',
            placeholder: this.inputAttrs.hasOwnProperty('placeholder') && this.inputAttrs.placeholder ? this.inputAttrs.placeholder : '請選擇',
            isRequired: this.inputAttrs.hasOwnProperty('isRequired') ? this.inputAttrs.isRequired : false,
            list: this.inputAttrs.hasOwnProperty('list') ? this.inputAttrs.list : {},
            style: this.inputAttrs.hasOwnProperty('style') ? this.inputAttrs.style : '',
            multiple: this.inputAttrs.hasOwnProperty('multiple') ? this.inputAttrs.multiple : false,
            dropDownList: {},
        };
    },
    watch: {
        value: function () {
            this.childValue = this.value;
        }
    },
    mounted() {
        this.dropDownList = Object.assign({'': this.placeholder}, this.list);
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
