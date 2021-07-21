<template>
    <div class="row mb-4">
        <div class="row col-12">
            <span v-if="meta.hasOwnProperty('total')">總共 {{ meta.total }} 筆</span>
            <span v-if="meta.hasOwnProperty('total') && meta.total > 1">，目前顯示第 {{ meta.from }} 筆到第 {{ meta.to }} 筆  </span>
            <span v-if="isValuesExist(values)">查詢條件如下</span>
        </div>
        <!--條件顯示-->
        <div class="row col-12 mt-2" v-if="isValuesExist(values)">
            <div v-for="(value,key,index) in values">
                <div v-if="value && getAttr(key,attrs)" :set="attr = getAttr(key,attrs).inputAttrs">
                    <span style="font-weight: bolder">{{ attr.title }}：</span>
                    <span>{{ getShowValue(value, attr.list) }}</span>
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
            default: function () {
                return []
            }
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
                if (attrs && attr.hasOwnProperty('inputAttrs') && values.hasOwnProperty(attr.inputAttrs.name) && values[attr.inputAttrs.name]) {
                    isShow = true;
                }
            });
            return isShow;
        },
        getAttr: function (nameKey, myArray) {
            let result = false;
            for (var i = 0; i < myArray.length; i++) {
                if (myArray[i].hasOwnProperty('inputAttrs') && myArray[i].inputAttrs.name === nameKey) {
                    result = myArray[i];
                }
            }
            return result;
        },
        getShowValue: function (value, list) {
            let showString = '';
            if (Array.isArray(value)) {
                value.forEach(function (val, index, array) {
                    let separator = isNaN(Date.parse(val)) ? ' , ' : ' ~ ';//時間的話 呈現 2021-2022 ,其他則呈現 1,2,3
                    showString += (list ? list[val] : val) + (index !== Object.keys(array).length - 1 ? separator : '');
                });
            } else {
                showString += (list ? list[value] : value);
            }
            return showString;
        }
    },
}
</script>

<style scoped>

</style>
