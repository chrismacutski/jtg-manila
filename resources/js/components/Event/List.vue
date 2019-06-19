<template>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>Manage Events</h4>
                </div>
            </div>
            <div class="col-lg-12">
                <toolbar :session-filters="sessionFilters"
                         :disable-publish-button="disable_publish_button"
                         @clicked-publish="publishEvent"
                         @event-deleted="deleteEvent"></toolbar>
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
                            <th class="align-middle">ADDRESS</th>
                            <th class="align-middle">STARTING AT</th>
                            <th class="align-middle">ENDING AT</th>
                            <th class="align-middle">PUBLISHED AT</th>
                            <!--<th class="align-middle">AMOUNT</th>-->
                            <th class="align-middle"></th>
                            </thead>
                            <tbody>
                            <tr v-for="event in events">
                                <td class="align-middle">
                                    <checkbox :event="event" v-model="event.selected"></checkbox>
                                </td>
                                <td class="align-middle">{{ event.id }}</td>
                                <td class="align-middle">{{ event.name }}</td>
                                <td class="align-middle">{{ event.description }}</td>
                                <td class="align-middle">{{ event.address }}</td>
                                <td class="align-middle">{{ event.starting_at | setDateTime}}</td>
                                <td class="align-middle">{{ event.ending_at | setDateTime}}</td>
                                <td class="align-middle">{{ event.published_at | setDateTime}}</td>
                                <!--<td class="align-middle">{{ event.amount }}</td>-->

                                <td class="align-middle">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm mr-1" @click="previewEvent(event)">
                                            Preview
                                        </button>
                                        <button class="btn btn-sm mr-1" @click="showEvent(event)">
                                            <i class="fa fa-eye fa-lg"></i>
                                        </button>
                                        <button class="btn btn-sm" @click="editEvent(event)">
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
                <paginator :data="eventList"
                           @nextPage="setEvents"
                           @prevPage="setEvents"></paginator>
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

        props: ['eventList', 'sessionFilters'],

        data() {
            return {
                events: collect([]),
                selected_all: false,

                disable_publish_button: true
            }
        },
        watch: {
            events: {
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
            _.forEach(this.eventList.data, (event) => {
                event.selected = false;
                this.events.push(event);
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
                this.events.each((event) => {
                    event.selected = this.selected_all;
                });
            },

            setEvents(data) {
                let events = collect([]);
                _.each(data.data, (event) => {
                    event.selected = false;
                    events.push(event);
                });

                this.events = events;
            },

            editEvent(event) {
                window.location.href = '/admin/events/' + event.hash_id + '/edit';
            },

            previewEvent(event) {
                window.open(
                    '/admin/events/' + event.hash_id + '/preview',
                    '_blank'
                );
            },

            showEvent(event) {
                window.location.href = '/admin/events/' + event.hash_id;
            },

            publishEvent() {
                this.events.each((event, index) => {
                    if (event.selected) {
                        axios.post(`/admin/events/${event.hash_id}/publish`, {})
                            .then(({data}) => {
                                data.selected = false;
                                this.$set(this.events.items, index, data);
                                this.$noty.success("Successfully published Event " + data.name, {
                                    theme: 'metroui',
                                    layout: 'bottomRight',
                                })
                            }).catch(error => {
                                event.selected = false;
                                this.$set(this.events.items, index, event);

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

            deleteEvent() {
                this.events.each((event, index) => {
                    if (event.selected) {
                        axios.post(`/admin/events/${event.hash_id}/delete`, {})
                            .then(({data}) => {
                                let event_name = event.name;
                                event.selected = false;
                                this.events.items.splice(index, 1);
                                this.$noty.success("Successfully deleted Event " + event_name, {
                                    theme: 'metroui',
                                    layout: 'bottomRight',
                                })
                            }).catch(error => {
                                event.selected = false;
                                this.$set(this.events.items, index, event);

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