<template>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>Manage Series</h4>
                </div>
            </div>
            <div class="col-lg-12">
                <toolbar :session-filters="sessionFilters"
                         :disable-publish-button="disable_publish_button"
                         @clicked-publish="publishSeries"
                         @series-deleted="deleteSeries"></toolbar>
            </div>

            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body p-0 table-lg-responsive table-md-response table-sm-responsive">
                        <table class="table">
                            <thead>
                            <th class="align-middle">
                                <input type="checkbox" :checked="selected_all" @click="selectAll">
                            </th>
                            <th class="align-middle">ID</th>
                            <th class="align-middle">NAME</th>
                            <th class="align-middle">DESCRIPTION</th>
                            <th class="align-middle">HAPPENED AT</th>
                            <th class="align-middle">PUBLISHED AT</th>
                            <th class="align-middle"></th>
                            </thead>
                            <tbody>
                            <tr v-for="row in series">
                                <td class="align-middle">
                                    <checkbox :series="row" v-model="row.selected"></checkbox>
                                </td>
                                <td class="align-middle">{{ row.id }}</td>
                                <td class="align-middle">{{ row.name }}</td>
                                <td class="align-middle">{{ row.description }}</td>
                                <td class="align-middle">{{ row.happened_at | setDateTime}}</td>
                                <td class="align-middle">{{ row.published_at | setDateTime}}</td>
                                <!--<td class="align-middle">{{ row.amount }}</td>-->

                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm mr-1" @click="previewSeries(row)">
                                            Preview
                                        </button>
                                        <button class="btn btn-sm mr-1" @click="showSeries(row)">
                                            <i class="fa fa-eye fa-lg"></i>
                                        </button>
                                        <button class="btn btn-sm" @click="editSeries(row)">
                                            <i class="fa fa-edit fa-lg"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <paginator :data="seriesList"
                           @nextPage="setSeries"
                           @prevPage="setSeries"></paginator>
            </div>
        </div>
    </div>
</template>

<script>
    import Toolbar from './Utils/Toolbar.vue'
    import Checkbox from './Utils/Checkbox.vue'
    import Filters from './Utils/Filters.vue'
    import Paginator from '../../components/Paginator.vue'

    export default {
        components: { Toolbar, Checkbox, Filters, Paginator },

        props: ['seriesList', 'sessionFilters'],

        data() {
            return {
                series: collect([]),
                selected_all: false,

                disable_publish_button: true
            }
        },
        watch: {
            series: {
                handler: function (newValue) {
                    if (newValue) {
                        let selected = newValue.where('selected',true).first();

                        if (!_.isUndefined(selected)) {
                            this.disable_publish_button = false;
                        } else {
                            this.disable_publish_button = true;
                        }

                        let unselected_count = newValue.where('selected',false).count();

                        if (unselected_count >= 1) {
                            this.selected_all = false;
                        }

                        if (unselected_count == 0) {
                            this.selected_all = true;
                        }
                    }
                },
                deep: true
            }
        },
        created() {
            _.forEach(this.seriesList.data, (series) => {
                series.selected = false;
                this.series.push(series);
            });
        },

        filters: {
            setDateTime(value) {
                if (!_.isUndefined(value) && !_.isNull(value)) {
                    return moment(value).format('LLL');
                }
            }
        },

        methods: {
            selectAll() {
                this.selected_all = !this.selected_all;
                this.series.each((series) => {
                    series.selected = this.selected_all;
                });
            },

            setSeries(data) {
                let series = collect([]);
                _.each(data.data, (item) => {
                    item.selected = false;
                    series.push(item);
                });

                this.series = series;
            },

            editSeries(series) {
                window.location.href = '/admin/series/' + series.hash_id + '/edit';
            },

            previewSeries(series) {
                window.open(
                    '/admin/series/' + series.hash_id + '/preview',
                    '_blank'
                );
            },

            showSeries(series) {
                window.location.href = '/admin/series/' + series.hash_id;
            },

            publishSeries() {
                this.series.each((item, index) => {
                    if (item.selected) {
                        axios.post(`/admin/series/${item.hash_id}/publish`, {})
                            .then(({data}) => {
                                data.selected = false;
                                this.$set(this.series.items, index, data);
                                this.$noty.success("Successfully published Series " + data.name, {
                                    theme: 'metroui',
                                    layout: 'bottomRight',
                                })
                            }).catch(error => {
                                item.selected = false;
                                this.$set(this.seris.items, index, item);

                                if (error.response.data.message) {
                                    this.$noty.error(error.response.data.message, {
                                        theme: 'metroui',
                                        layout: 'bottomRight',
                                    })
                                }
                            });
                    }
                })
            },

            deleteSeries() {
                this.series.each((item, index) => {
                    if (item.selected) {
                        axios.post(`/admin/series/${item.hash_id}/delete`, {})
                            .then(({data}) => {
                                let series_name = item.name;
                                item.selected = false;
                                this.series.items.splice(index, 1);
                                this.$noty.success("Successfully deleted Series " + series_name, {
                                    theme: 'metroui',
                                    layout: 'bottomRight',
                                })
                            }).catch(error => {
                                item.selected = false;
                                this.$set(this.series.items, index, item);

                                if (error.response.data.message) {
                                    this.$noty.error(error.response.data.message, {
                                        theme: 'metroui',
                                        layout: 'bottomRight',
                                    })
                                }
                            });
                    }
                })
            }
        }
    }
</script>