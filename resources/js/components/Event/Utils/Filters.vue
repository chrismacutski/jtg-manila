<template>
    <div>
        <button class="btn btn-light" v-popover:foo.bottom>
            <i class="fa fa-filter fa-lg"></i>
        </button>

        <popover name="foo">
            <button type="button" class="btn btn-sm btn-light btn-block text-center" @click="clearFilters"><span class="small">x</span> CLEAR FILTERS</button>
            <div class="card border-0">
                <div class="card-body">
                    <form @submit.prevent="filter">
                        <div class="form-group">
                            <label>EVENT NAME</label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   v-model="filters.name"
                                   :class="[errors.name ? 'form-control is-invalid' : 'form-control']" />

                            <div :class="[errors.name ? 'invalid-feedback text-left' : '']">
                                <template v-for="error in errors.name">{{ error }}</template>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <label class="d-flex justify-content-start">STARTING AT FROM</label>
                                    <flat-pickr v-model="filters.starting_at_from"
                                                :config="dateConfig"
                                                :class="[errors.starting_at_from ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                                    <div :class="[errors.starting_at_from ? 'invalid-feedback text-left' : '']">
                                        <template v-for="error in errors.starting_at_from">{{ error }}</template>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="d-flex justify-content-start">STARTING AT FROM</label>
                                    <flat-pickr v-model="filters.starting_at_to"
                                                :config="dateConfig"
                                                :class="[errors.starting_at_to ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                                    <div :class="[errors.starting_at_to ? 'invalid-feedback text-left' : '']">
                                        <template v-for="error in errors.starting_at_to">{{ error }}</template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <label class="d-flex justify-content-start">ENDING AT FROM</label>
                                    <flat-pickr v-model="filters.ending_at_from"
                                                :config="dateConfig"
                                                :class="[errors.ending_at_from ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                                    <div :class="[errors.ending_at_from ? 'invalid-feedback text-left' : '']">
                                        <template v-for="error in errors.ending_at_from">{{ error }}</template>
                                    </div>
                                </div>
                                <div class="col">
                                    <label class="d-flex justify-content-start">ENDING AT FROM</label>
                                    <flat-pickr v-model="filters.ending_at_to"
                                                :config="dateConfig"
                                                :class="[errors.ending_at_to ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                                    <div :class="[errors.ending_at_to ? 'invalid-feedback text-left' : '']">
                                        <template v-for="error in errors.ending_at_to">{{ error }}</template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div :class="[errors.ending_at ? 'invalid-feedback text-left' : '']">
                            <template v-for="error in errors.ending_at">{{ error }}</template>
                        </div>

                        <div class="form-group">
                            <div class="d-flex justify-content-end">
                                <button :disabled="disableFilterButton" type="submit" class="btn btn-primary" v-html="filterButtonText"></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </popover>
    </div>
</template>

<style>
    div[data-popover="foo"] {
        width: 380px !important;
        left: 0px !important;
        top: 50px !important;
    }
</style>

<script>
    export default {
        props: ['sessionFilters'],

        data() {
            return {
                filters: {
                    name: '',
                    starting_at_from: '',
                    starting_at_to: '',
                    ending_at_from: '',
                    ending_at_to: '',
                    ending_at: ''
                },
                errors: [],

                filterButtonText: 'Filter',

                dateConfig: {
                    wrap: true, // set wrap to true only when using 'input-group'
                    altFormat: 'M j, Y',
                    altInput: true,
                    dateFormat: 'Y-m-d',
                    enableTime: false
                }
            }
        },
        watch: {
            sessionFilters: {
                handler(newValue) {
                    this.setFilters(newValue)
                },
                deep: true
            }
        },
        computed: {
            disableFilterButton() {
                if (this.filterButtonText == 'Filter') {
                    return false;
                }

                return true;
            },
        },
        created() {
            if (!_.isEmpty(this.sessionFilters)) {
                this.setFilters(this.sessionFilters);
            }
        },
        methods: {
            filter() {
                this.filterButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                axios.post('/admin/events/filter', this.filters)
                    .then(({data}) => {
                        window.location.reload();
                    }).catch(error => {
                        this.filterButtonText = 'Filter';
                    });
                },

            setFilters(data) {
                let this_filters = this.filters;
                _.forEach(data, (value, key) => {
                    if (value != '' && !_.isNull(value)) {
                        this_filters[key] = value
                    }
                });

                this.filters = this_filters;
            },

            clearFilters() {
                this.filters.name = '';
                this.filters.starting_at_from = '';
                this.filters.starting_at_to = '';
                this.filters.ending_at_from = '';
                this.filters.ending_at_to = '';
            }
        }
    }
</script>