<template>
    <div>
        <div class="card border-0 mb-2">
            <div class="d-flex justify-content-between p-2">
                <h4>Sermons ({{ sermonsCount }})</h4>

                <div class="btn-group" role="group">
                    <button class="btn btn-primary mr-1" @click="createSermon">
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
        props: ['seriesId', 'sermonsCount','disableDeleteButton'],

        data() {
            return {
            }
        },

        methods: {
            createSermon() {
                window.location.href = '/admin/series/' + this.seriesId + '/sermons/create';
            },

            deleteEvent() {
                this.$emit('deleted');
            }
        }
    }
</script>