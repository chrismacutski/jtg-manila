<template>
    <div>
        <!--<div class="d-flex justify-content-between align-items-center mb-1">-->
            <!--<h4>Attendees ({{ event_attendees.count() }})</h4>-->
        <!--</div>-->

        <toolbar :event-id="event.hash_id"
                 :attendees-count="event_attendees.count()"
                 :disable-delete-button="disable_delete_button"
                 @deleted="deleteEventAttendee"></toolbar>

        <div class="card border-0">
            <div class="card-body p-0 table-lg-responsive table-md-responsive table-sm-responsive">
                <table class="table">
                    <thead>
                    <th class="align-middle">
                        <input type="checkbox" :checked="selected_all" @click="selectAll">
                    </th>
                    <th class="align-middle">FIRST NAME</th>
                    <th class="align-middle">LAST NAME</th>
                    <th class="align-middle">PHONE NUMBER</th>
                    <th class="align-middle">EMAIL ADDRESS</th>
                    <!--<th class="align-middle"></th>-->
                    </thead>
                    <tbody>
                    <tr v-for="event_attendee in event_attendees">
                        <td class="align-middle">
                            <checkbox :event="event_attendee" v-model="event_attendee.selected"></checkbox>
                        </td>
                        <td class="align-middle">{{ event_attendee.first_name }}</td>
                        <td class="align-middle">{{ event_attendee.last_name }}</td>
                        <td class="align-middle">{{ event_attendee.phone_number }}</td>
                        <td class="align-middle">{{ event_attendee.email_address}}</td>

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

        props: ['event'],

        data() {
            return {
                event_attendees: collect([]),
                selected_all: false,

                disable_delete_button: true
            }
        },
        watch: {
            event_attendees: {
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
            if (!_.isNull(this.event.attendees)) {
                _.forEach(this.event.attendees, (event_attendee) => {
                    event_attendee.selected = false;
                    this.event_attendees.push(event_attendee);
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
                this.event_attendees.each((event_attendee) => {
                    event_attendee.selected = this.selected_all;
                });
            },

            setEvents(data) {
                let event_attendees = collect([]);
                _.each(data.data, (event_attendee) => {
                    event_attendee.selected = false;
                    event_attendees.push(event_attendee);
                });

                this.event_attendees = event_attendees;
            },

            editEventAttendee(event) {
                window.location.href = '/admin/events/' + event.hash_id + '/edit';
            },

            showEventAttendee(event) {
                window.location.href = '/admin/events/' + event.hash_id;
            },

            deleteEventAttendee() {
                this.event_attendees.each((event_attendee, index) => {
                    if (event_attendee.selected) {
//                        admin/events/{event}/attendees/{event_attendee}/delete
                        axios.post(`/admin/events/${this.event.hash_id}/attendees/${event_attendee.id}/delete`, {})
                            .then(({data}) => {
                                data.selected = false;
                                let attendee_name = event_attendee.first_name + ' ' + event_attendee.last_name;

                                this.event_attendees.items.splice(index, 1);
                                this.$noty.success("Successfully removed " + attendee_name + " in " + data.name, {
                                    theme: 'metroui',
                                    layout: 'bottomRight',
                                })
                            }).catch(error => {
                                event_attendee.selected = false;
                                this.$set(this.event_attendees.items, index, event_attendee);

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