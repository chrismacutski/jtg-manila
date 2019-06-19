<template>
    <div>
        <div class="card border-0 mb-2">
            <div class="d-flex justify-content-between p-2">
                <filters :session-filters="sessionFilters"></filters>

                <div class="btn-group" role="group">
                    <button class="btn btn-primary mr-1" @click="createEvent">
                        Create Event
                    </button>
                    <button class="btn btn-primary mr-1"
                            :disabled="disablePublishButton"
                            @click="publish">
                        Publish
                    </button>
                    <button class="btn btn-primary mr-1"
                            :disabled="disablePublishButton"
                            @click="deleteEvent">
                        Delete Event
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Filters from './Filters.vue'
    export default {
        components: {Filters},

        props: ['sessionFilters', 'disablePublishButton'],

        data() {
            return {
            }
        },

        methods: {
            createEvent() {
                window.location.href = '/admin/events/create';
            },

            publish() {
                this.$emit('clicked-publish');
            },

            deleteEvent() {
                this.$emit('event-deleted');
            }
        }
    }
</script>