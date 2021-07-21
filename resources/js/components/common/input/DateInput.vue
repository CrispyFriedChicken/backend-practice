<template>
    <div class="row pl-4">
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
        <!--選擇時間維度-->
        <div style="width: 120px;" v-if="inputAttrs.hasOwnProperty('isShowModeOption') && inputAttrs.isShowModeOption">
            <select-input :inputAttrs="modeOptionInputAttrs" v-model="modeOptionInputAttrs.value" v-on="$listeners"></select-input>
        </div>
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
            modeOptionInputAttrs: {
                title: '時間維度',
                name: 'modeOption',
                value: 'day',
                list: {
                    'day': '時間維度:天',
                },
            },
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
                case 'date':
                case 'month':
                case 'year':
                    this.range = this.dateMode.includes('Range');
                    this.type = this.dateMode.replace('Range', '');
                    this.childValue = new Date();
                    break;
                case 'datetimeRange':
                case 'dateRange':
                case 'monthRange':
                case 'yearRange':
                default:
                    this.range = this.dateMode.includes('Range');
                    this.type = this.dateMode.replace('Range', '');
                    this.childValue = [new Date(), new Date()];
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
            this.sendToParent();
            //維度設定
            if (this.inputAttrs.hasOwnProperty('isShowModeOption') && this.inputAttrs.isShowModeOption) {
                switch (this.dateMode) {
                    case 'date':
                    case 'datetimeRange':
                        this.modeOptionInputAttrs.list = {
                            'day': '時間維度:天',
                            'hour': '時間維度:小時',
                            'minute': '時間維度:分鐘',
                        };
                        break;
                    case 'month':
                    case 'monthRange':
                        this.modeOptionInputAttrs.list = {
                            'day': '時間維度:天',
                            'month': '時間維度:月',
                        };
                        break;
                    case 'year':
                    case 'yearRange':
                        this.modeOptionInputAttrs.list = {
                            'day': '時間維度:天',
                            'month': '時間維度:月',
                            'year': '時間維度:年',
                        };
                        break;
                    case 'dateRange':
                    case '7d':
                    case '14d':
                    case '30d':
                    default:
                        this.modeOptionInputAttrs.list = {
                            'day': '時間維度:天',
                        };
                        break;
                }
                this.modeOptionInputAttrs.value = 'day';
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
