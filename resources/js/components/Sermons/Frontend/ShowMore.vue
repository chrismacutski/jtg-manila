<template>
    <div class="row mt-0">
        <div class="col text-center jtg-animate">
            <form @submit.prevent="load">
                <p><button :disabled="disableShowMoreButton" type="submit" class="btn btn-primary btn-outline-primary p-3" v-html="showMoreButtonText"></button></p>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                filters: {
                    take: 9
                },
                errors: [],

                showMoreButtonText: 'SHOW MORE',

                dateConfig: {
                    wrap: true, // set wrap to true only when using 'input-group'
                    altFormat: 'M j, Y',
                    altInput: true,
                    dateFormat: 'Y-m-d',
                    enableTime: true
                }
            }
        },
        computed: {
            disableShowMoreButton() {
                if (this.showMoreButtonText == 'SHOW MORE') {
                    return false;
                }

                return true;
            },
        },
        methods: {
            load() {
                this.filters.take += 9;
                this.showMoreButtonText = '<i class="fa fa-spinner fa-spin fa-lg fa-fw"></i>';

                this.filter();
            },

            filter: _.debounce(function() {
                axios.post('/sermons/filter', this.filters)
                    .then(({data}) => {
                        this.$emit('filtered', data);
                        this.showMoreButtonText = 'SHOW MORE';
//                        window.location.reload();
                    }).catch(error => {
                    this.showMoreButtonText = 'SHOW MORE';
                });
            }, 2000)
        }
    }
</script>