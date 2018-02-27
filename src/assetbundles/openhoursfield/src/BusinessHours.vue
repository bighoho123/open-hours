<template>
    <div class="business-hours-wrapper">
        <div class='heading'>Existing</div>
        <table>
            <thead>
            <tr>
                <th>Weekday</th>
                <th>From</th>
                <th>To</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(existing,index) in already_added_sorted">
                <td>{{weekday_from_index_to_label(existing.weekday)}}</td>
                <td>{{existing.from.label}}</td>
                <td>{{existing.is_to_late?"Late":existing.to.label}}</td>
                <td><button class="button btn warning" type='button' @click="delete_this(index)">Delete</button></td>
            </tr>
            </tbody>
        </table>

        <!-- Hidden form field -->
        <div class='hidden-form-data'>
            <input type="hidden" :name="name_prefix" :value="JSON.stringify(already_added_sorted)">
        </div>


        <div class='heading'>Add new open hours</div>
        <div class='add-new-form'>

            <div class="add-new__row">
                <div class="input">
                    <label>Weekday</label>
                    <select data-disablechosen v-model="to_be_added.weekday">
                        <option value=''>Select...</option>
                        <option value='0'>Monday</option>
                        <option value='1'>Tuesday</option>
                        <option value='2'>Wednesday</option>
                        <option value='3'>Thursday</option>
                        <option value='4'>Friday</option>
                        <option value='5'>Saturday</option>
                        <option value='6'>Sunday</option>
                    </select>
                </div>
                <div class="input">
                    <label>From</label>
                    <select data-disablechosen v-model="to_be_added.from">
                        <option v-for="option in possible_times" :value="option">{{option.label}}</option>
                    </select>
                </div>

                <div class="input">
                    <label>To</label>
                    <select data-disablechosen v-model="to_be_added.to" :disabled="to_be_added.is_to_late">
                        <option v-for="option in possible_times" :value="option">{{option.label}}</option>
                    </select>
                </div>

                <div class="checkbox-list input">
                    <label>
                        Till Late?
                    </label>
                    <input type="checkbox" v-model="to_be_added.is_to_late">
                </div>

                <div>
                    <button class='button add-row btn submit' type='button' @click="add_this_one()">Add</button>
                </div>
            </div>
            <div>
                <ul class="error-list" v-show="false">
                    <li v-for='error in validator'>{{error}}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'business-hours',
        data () {
            // Generating Possible Times
            let possible_times = [];
            for (let i=0; i<24; i++) {
                for (let j=0; j<60; j+=15) {
                    let possible = {
                        label: (i<10?('0'+i):i)+":"+(j<10?('0'+j):j),
                        value: i+(j/60)
                    }
                    possible_times.push(possible);
                }
            }

            return {
                to_be_added: {
                    'weekday':'',
                    'from':{
                        label:"00:00",
                        value:0
                    },
                    'to':{
                        label:"00:00",
                        value:0
                    },
                    'is_to_late':false
                },
                possible_times:possible_times,
                _:require('lodash'),
                already_added: Array.isArray(this.already_added_previous)?JSON.parse(JSON.stringify(this.already_added_previous)):[]
            }
        },
        props: {
            name_prefix:String,
            already_added_previous: {
                default:() => {return []}
            }
        },
        methods: {
            add_this_one:function() {
                if (this.validator.length>0) {
                    Craft.cp.displayNotification('error',"Error(s) found:\n"+this.validator.join("\n"));
                    return;
                }
                this.already_added.push(JSON.parse(JSON.stringify(this.to_be_added)));
            },
            delete_this:function(i) {
                this.already_added.splice(i, 1);
            },
            weekday_from_index_to_label:function(i) {
                if (i == 0) {
                    return "Monday";
                }
                if (i == 1) {
                    return "Tuesday";
                }
                if (i == 2) {
                    return "Wednesday";
                }
                if (i == 3) {
                    return "Thursday";
                }
                if (i == 4) {
                    return "Friday";
                }
                if (i == 5) {
                    return "Saturday";
                }
                if (i == 6) {
                    return "Sunday";
                }

            }
        },
        computed: {
            validator: function() {
                let error_bag = [];
                if (this.to_be_added.weekday=="") {
                    error_bag.push("Please specify a weekday");
                }
                if (!this.to_be_added.is_to_late && this.to_be_added.from.value >= this.to_be_added.to.value) {
                    error_bag.push("Please specify a valid time range");
                }
                return error_bag;
            },
            unique_index_per_day: function() {
                let count = {
                    0:0,
                    1:0,
                    2:0,
                    3:0,
                    4:0,
                    5:0,
                    6:0,
                }
                let result = {};
                for (let i=0; i<this.already_added_sorted.length; i++) {
                    result[i] = count[this.already_added_sorted[i].weekday];
                    count[this.already_added_sorted[i].weekday]++;
                }
                return result;
            },
            already_added_sorted:function() {
                return _.orderBy(this.already_added,['weekday','from.value']);
            }
        }
    }


</script>

<style lang='scss' scoped>
    .business-hours-wrapper {
        width:100%;

        table {
            width:100%;
            th {
                text-align:left;
                padding-top:0.25rem;
                padding-bottom:0.25rem;
            }
            th:last-of-type {
                text-align:right;
            }
            td {
                text-align:left;
                padding-top:0.5rem;
                padding-bottom:0.5rem;
            }
            td:last-of-type {
                text-align:right;
            }
        }

        .error-list {
            color:red;
            text-align:right;
            > li {
                display:block;
            }
        }

        .heading {
            color:#576575;
            font-weight:bold;
                padding-top: 0.5rem;
                border-bottom: 1px solid #576575;
                margin-bottom: 0.5rem;
        }
        .add-new-form {
            padding:.5rem 0;
            label:not(:first-of-type) {
                margin-left:20px;
            }
            .add-new__row {
                .input {
                    margin-bottom:5px;
                    label {
                        min-width:100px;
                        display:inline-block;
                    }
                }
            }
        }
    }
</style>
