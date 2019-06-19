<template>
    <div>
        <div class="card mb-2" v-if="paginated_data">
            <div class="card-body py-2 d-flex justify-content-between">
                <div>
                    Total: {{paginated_data.total}}.
                    Page {{paginated_data.current_page}}
                    of {{paginated_data.last_page}}
                </div>

                <div class="btn-group" role="group">
                    <button type="button"
                            :disabled="paginated_data.prev_page_url === null"
                            @click="prevPage"
                            class="btn btn-sm btn-default">
                        Previous
                    </button>
                    <button type="button"
                            :disabled="paginated_data.next_page_url === null"
                            @click="nextPage"
                            class="btn btn-sm btn-default">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data', 'type'],

        data() {
            return {
                paginated_data: null
            }
        },

        mounted() {
            this.paginated_data = this.data;
        },

        methods: {
            nextPage() {
                axios.get(this.paginated_data.next_page_url)
                    .then(({data}) => {
                        this.paginated_data = data[this.type];
                        this.$emit('nextPage', data[this.type]);
                    });
            },

            prevPage() {
                axios.get(this.paginated_data.prev_page_url)
                    .then(({data}) => {
                        this.paginated_data = data[this.type];
                        this.$emit('prevPage', data[this.type]);
                    });
            }
        }
    }
</script>