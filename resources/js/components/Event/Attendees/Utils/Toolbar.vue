<template>
    <div>
        <div class="card border-0 mb-2">
            <div class="d-flex justify-content-between p-2">
                <h4>Attendees ({{ attendeesCount }})</h4>

                <div class="btn-group" role="group">
                    <button class="btn btn-primary mr-1" @click="createEventAttendee">
                        Create Event
                    </button>
                    <button class="btn btn-primary mr-1"
                            :disabled="disableDeleteButton"
                            @click="deleteEvent">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['eventId', 'attendeesCount','disableDeleteButton'],

        data() {
            return {
            }
        },

        methods: {
            createEventAttendee() {
                window.location.href = '/admin/events/' + this.eventId + '/attendees/create';
            },

            deleteEvent() {
                this.$emit('deleted');
            }
        }
    }
</script>