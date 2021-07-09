<template>
    <div>
        <!--選擇時間類型-->
        <select class="form-control" :name="'dateMode[' + name + ']'" v-model="dateMode"
                style="width: 120px;display: inline;">
            <option v-for="(key,val) in dateModeList" :value="val">
                {{ key }}
            </option>
        </select>
        <!--時間輸入框-->
        <date-picker value-type="format" :range="dateMode.includes('Range')" :type="dateMode.replace('Range','')"
                     :style="{'width' : getWidth() + 'px'}" :input-attr="{name:name,id:id}" v-model="childValue" :default-value="this.value"
                     @change="sendToParent"></date-picker>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
    components: {DatePicker},
    name: "DateInput",
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
        let list = {
            datetime: '時間',
            date: '日期',
            month: '月',
            year: '年',
            datetimeRange: '時間(範圍)',
            dateRange: '日期(範圍)',
            monthRange: '月(範圍)',
            yearRange: '年(範圍)'
        };
        return {
            dateMode: this.inputAttrs.hasOwnProperty('dateMode') ? this.inputAttrs.dateMode : 'date',
            dateModeList: this.inputAttrs.hasOwnProperty('dateModeList') ? this.inputAttrs.dateModeList : list,
            childValue: this.value,
            id: this.inputAttrs.hasOwnProperty('id') ? this.inputAttrs.id : '',
            name: this.inputAttrs.hasOwnProperty('name') ? this.inputAttrs.name : '',
            type: this.inputAttrs.hasOwnProperty('type') ? this.inputAttrs.type : 'date',
            range: this.inputAttrs.hasOwnProperty('range') ? this.inputAttrs.range : false,
        };
    },
    watch: {
        value: function () {
            this.childValue = this.value;
        }
    },
    methods: {
        sendToParent: function () {
            this.$emit('update-value', {
                key: this.name,
                value: this.childValue
            });
        },
        getWidth: function () {
            switch (this.dateMode) {
                case 'datetime':
                    return 180;
                case 'date':
                default:
                    return 130;
                case 'month':
                    return 100;
                case 'year':
                    return 80;
                case 'datetimeRange':
                    return 320;
                case 'dateRange':
                    return 210;
                case 'monthRange':
                    return 180;
                case 'yearRange':
                    return 140;

            }
        }
    },
}
</script>

<style scoped>

.input-short {
    width: 130px;
}

.input-long {
    width: 230px;
}
</style>
