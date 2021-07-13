<template>
    <div class="row mb-4">
        <div class="row col-12">
            <span v-if="meta.hasOwnProperty('total')">總共 {{ meta.total }} 筆</span>
            <span v-if="meta.hasOwnProperty('total') && meta.total > 1">，目前顯示第 {{ meta.from }} 筆到第 {{ meta.to }} 筆</span>
            <span v-if="isValuesExist(values)">，查詢條件如下</span>
        </div>
        <!--條件顯示-->
        <div class="row col-12 mt-2" v-if="isValuesExist(values)">
            <div v-for="(value,key,index) in values">
                <div v-if="value" :set="attr = getAttr(key,attrs).inputAttrs">
                    <span style="font-weight: bolder">{{ attr.title }}：</span>
                    <span>{{ Array.isArray(value) ? value.join(' - ') : (attr.list ? attr.list[value] : value)}}</span>
                    <span v-if="index !== Object.keys(values).length-1">　/　</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "SearchCondition",
    props: {
        values: {
            type: Object,
            default: function () {
                return {};
            }
        },
        attrs: {
            type: Array,
            default: [],
        },
        meta: {
            type: Object,
            default: function () {
                return {};
            }
        },
    },
    methods: {
        isValuesExist: function () {
            let isShow = false;
            let attrs = this.attrs;
            let values = this.values;
            $.each(attrs, function (index, attr) {
                if (attrs && values.hasOwnProperty(attr.inputAttrs.name) && values[attr.inputAttrs.name]) {
                    isShow = true;
                }
            });
            return isShow;
        },
        getAttr: function (nameKey, myArray) {
            for (var i = 0; i < myArray.length; i++) {
                if (myArray[i].inputAttrs.name === nameKey) {
                    return myArray[i];
                }
            }
        }
    },
}
</script>

<style scoped>

</style>
