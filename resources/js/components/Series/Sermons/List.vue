<template>
    <div>
        <toolbar :series-id="series.hash_id"
                 :sermons-count="sermons.count()"
                 :disable-delete-button="disable_delete_button"
                 @deleted="deleteSermon"></toolbar>

        <div class="card border-0">
            <div class="card-body p-0 table-lg-responsive table-md-responsive table-sm-responsive">
                <table class="table">
                    <thead>
                    <th class="align-middle">
                        <input type="checkbox" :checked="selected_all" @click="selectAll">
                    </th>
                    <th class="align-middle">NAME</th>
                    <th class="align-middle">DESCRIPTION</th>
                    <th class="align-middle">SPEAKER</th>
                    <th class="align-middle">HAPPENED AT</th>
                    <th class="align-middle">PUBLISHED AT</th>
                    <!--<th class="align-middle"></th>-->
                    </thead>
                    <tbody>
                    <tr v-for="sermon in sermons">
                        <td class="align-middle">
                            <checkbox :sermon="sermon" v-model="sermon.selected"></checkbox>
                        </td>
                        <td class="align-middle">{{ sermon.name }}</td>
                        <td class="align-middle">{{ sermon.description }}</td>
                        <td class="align-middle">{{ sermon.speaker.name }}</td>
                        <td class="align-middle">{{ sermon.happened_at | setDateTime}}</td>
                        <td class="align-middle">{{ sermon.published_at | setDateTime}}</td>
                        <!--<td class="align-middle">-->
                            <!--<div class="btn-group" role="group">-->
                                <!--<button class="btn btn-sm mr-1" @click="showEventAttendee(event)">-->
                                    <!--<i class="fa fa-eye fa-lg"></i>-->
                                <!--</button>-->
                                <!--<button class="btn btn-sm" @click="editEventAttendee(event)">-->
                                    <!--<i class="fa fa-edit fa-lg"></i>-->
                                <!--</button>-->
                            <!--</div>-->
                        <!--</td>-->
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!--<div class="col-lg-12">-->
            <!--<paginator :data="eventList"-->
                       <!--@nextPage="setEvents"-->
                       <!--@prevPage="setEvents"></paginator>-->
        <!--</div>-->
    </div>
</template>

<script>
    import Toolbar from './Utils/Toolbar.vue'
    import Checkbox from './Utils/Checkbox.vue'
    import Paginator from '../../../components/Paginator.vue'

    export default {
        components: {Toolbar, Checkbox, Paginator },

        props: ['series'],

        data() {
            return {
                sermons: collect([]),
                selected_all: false,

                disable_delete_button: true
            }
        },
        watch: {
            sermons: {
                handler: function (newValue) {
                    if (newValue) {
                        let selected = newValue.where('selected',true).first();

                        if (!_.isUndefined(selected)) {
                            this.disable_delete_button = false;
                        } else {
                            this.disable_delete_button = true;
                        }

                        let unselected_count = newValue.where('selected',false).count();

                        if (unselected_count >= 1) {
                            this.selected_all = false;
                        }

                        if (unselected_count == 0) {
                            this.selected_all = true;
                        }
                    }

                    if (newValue.count() == 0) {
                        this.selected_all = false;
                    }
                },
                deep: true
            }
        },
        created() {
            if (!_.isNull(this.series.sermons)) {
                _.forEach(this.series.sermons, (sermon) => {
                    sermon.selected = false;
                    this.sermons.push(sermon);
                });
            }
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
                this.sermons.each((sermon) => {
                    sermon.selected = this.selected_all;
                });
            },

            setEvents(data) {
                let sermons = collect([]);
                _.each(data.data, (sermon) => {
                    sermon.selected = false;
                    sermons.push(sermon);
                });

                this.sermons = sermons;
            },

            editEventAttendee(event) {
                window.location.href = '/admin/events/' + event.hash_id + '/edit';
            },

            showEventAttendee(event) {
                window.location.href = '/admin/events/' + event.hash_id;
            },

            deleteSermon() {
                this.sermons.each((sermon, index) => {
                    if (sermon.selected) {
//                        admin/events/{event}/attendees/{sermon}/delete
                        axios.post(`/admin/series/${this.series.hash_id}/sermons/${sermon.id}/delete`, {})
                            .then(({data}) => {
                                data.selected = false;
                                let sermon_name = sermon.name;

                                this.sermons.items.splice(index, 1);
                                this.$noty.success("Successfully removed " + sermon_name + " in " + data.name, {
                                    theme: 'metroui',
                                    layout: 'bottomRight',
                                })
                            }).catch(error => {
                                sermon.selected = false;
                                this.$set(this.sermons.items, index, sermon);

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