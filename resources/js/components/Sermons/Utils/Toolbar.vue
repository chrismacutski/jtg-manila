<template>
    <div>
        <div class="card border-0 mb-2">
            <div class="d-flex justify-content-between p-2">
                <filters :session-filters="sessionFilters"></filters>

                <div class="btn-group" role="group">
                    <button class="btn btn-primary mr-1" @click="createSeries">
                        Create Event
                    </button>
                    <button class="btn btn-primary mr-1"
                            :disabled="disablePublishButton"
                            @click="publish">
                        Publish
                    </button>
                    <button class="btn btn-primary mr-1"
                            :disabled="disablePublishButton"
                            @click="deleteSeries">
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
            createSeries() {
                window.location.href = '/admin/series/create';
            },

            publish() {
                this.$emit('clicked-publish');
            },

            deleteSeries() {
                this.$emit('series-deleted');
            }
        }
    }
</script>