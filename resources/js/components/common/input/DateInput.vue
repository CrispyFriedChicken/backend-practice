<template>
    <div>
        <!--選擇時間類型-->
        <select class="form-control" :name="'dateMode[' + name + ']'" v-model="dateMode" @change="changeDateMode"
                style="width: 120px;display: inline;">
            <option v-for="(key,val) in dateModeList" :value="val">
                {{ key }}
            </option>
        </select>
        <!--時間輸入框-->
        <date-picker value-type="format" :range="range" :type="type"
                     :style="{'width' : getWidth() + 'px'}" :input-attr="{name:name,id:id}" v-model="childValue" :default-value="this.value"
                     @change="sendToParent"></date-picker>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import moment from 'moment'

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
            type: [String, Array],
            default: ''
        },
    },
    data() {
        let list = {
            'datetime': '時間',
            'date': '日期',
            'month': '月',
            'year': '年',
            'datetimeRange': '時間(範圍)',
            'dateRange': '日期(範圍)',
            'monthRange': '月(範圍)',
            'yearRange': '年(範圍)',
            '7d': '7天',
            '14d': '14天',
            '30d': '30天'
        };
        return {
            dateMode: this.inputAttrs.hasOwnProperty('dateMode') ? this.inputAttrs.dateMode : 'date',
            dateModeList: this.inputAttrs.hasOwnProperty('dateModeList') ? this.inputAttrs.dateModeList : list,
            childValue: this.value,
            id: this.inputAttrs.hasOwnProperty('id') ? this.inputAttrs.id : '',
            name: this.inputAttrs.hasOwnProperty('name') ? this.inputAttrs.name : '',
            range: false,
            type: 'date',
        };
    },
    mounted() {
        this.range = this.dateMode.includes('Range');
        this.type = this.dateMode.replace('Range', '');
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
                case '7d':
                case '14d':
                case '30d':
                    return 210;
                case 'monthRange':
                    return 180;
                case 'yearRange':
                    return 140;

            }
        },
        changeDateMode: function () {
            switch (this.dateMode) {
                case 'datetime':
                case 'date':
                case 'month':
                case 'year':
                case 'datetimeRange':
                case 'dateRange':
                case 'monthRange':
                case 'yearRange':
                default:
                    this.range = this.dateMode.includes('Range');
                    this.type = this.dateMode.replace('Range', '');
                    this.childValue = '';
                    break;
                case '7d':
                case '14d':
                case '30d':
                    this.range = true;
                    this.type = 'date';
                    let betweenDays = parseInt(this.dateMode.replace('d', '')) - 1;
                    let dates = [];
                    let endDate = new Date();
                    let startDate = new Date().setDate(endDate.getDate() - betweenDays);
                    dates.push(moment(startDate).format("YYYY-MM-DD"));
                    dates.push(moment(endDate).format("YYYY-MM-DD"));
                    this.childValue = dates;
                    break;
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
