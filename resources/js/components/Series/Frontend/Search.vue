<template>
    <div class="card mt-4 rounded-0 jtg-animate">
        <div class="card-body">
            <form @submit.prevent="load">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md col-lg">
                            <label class="font-weight-bold">NAME</label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   v-model="filters.name"
                                   :class="[errors.name ? 'form-control is-invalid' : 'form-control']" />

                            <div :class="[errors.name ? 'invalid-feedback text-left' : '']">
                                <template v-for="error in errors.name">{{ error }}</template>
                            </div>
                        </div>
                        <div class="col-md col-lg">
                            <label class="d-flex justify-content-start font-weight-bold">FROM</label>
                            <flat-pickr v-model="filters.starting_at_from"
                                        :config="dateConfig"
                                        :class="[errors.starting_at_from ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                            <div :class="[errors.starting_at_from ? 'invalid-feedback text-left' : '']">
                                <template v-for="error in errors.starting_at_from">{{ error }}</template>
                            </div>
                        </div>
                        <div class="col-md col-lg">
                            <label class="d-flex justify-content-start font-weight-bold">TO</label>
                            <flat-pickr v-model="filters.starting_at_to"
                                        :config="dateConfig"
                                        :class="[errors.starting_at_to ? 'form-control is-invalid' : 'form-control']"></flat-pickr>

                            <div :class="[errors.starting_at_to ? 'invalid-feedback text-left' : '']">
                                <template v-for="error in errors.starting_at_to">{{ error }}</template>
                            </div>
                        </div>
                        <div class="col-md col-lg align-self-end">
                            <button :disabled="disableFindSeriesButton" type="submit" class="btn btn-primary form-control" v-html="findSeriesButtonText"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['sessionFilters'],

        data() {
            return {
                filters: {
                    name: '',
                    starting_at_from: '',
                    starting_at_to: '',
                    take: 3
                },
                errors: [],

                findSeriesButtonText: 'FIND SERIES',

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
            disableFindSeriesButton() {
                if (this.findSeriesButtonText == 'FIND SERIES') {
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
            load() {
                this.filters.take = 9;
                this.$emit('hide-list');
                this.findSeriesButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                this.filter();
            },

            filter: _.debounce(function() {
                axios.post('/series/filter', this.filters)
                    .then(({data}) => {
                        this.$emit('filtered', data);
                        this.findSeriesButtonText = 'FIND SERIES';
//                        window.location.reload();
                    }).catch(error => {
                    this.findSeriesButtonText = 'FIND SERIES';
                });
            }, 2000),

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
            }
        }
    }
</script>