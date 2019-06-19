<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <search-sermons :session-filters="sessionFilters"
                                    @hide-list="emptySermonData"
                                    @filtered="setSermonData"></search-sermons>
                </div>
            </div>
        </div>

        <div class="jtg-series-section pt-4">
            <div class="container">
                <div class="row">
                    <template v-if="sermons.count() > 0">
                        <div class="col-md-4 jtg-animate" :class="[shouldAnimate ? 'fadeInUp jtg-animated' : 'fadeInUp jtg-animated']" v-for="sermon in sermons">
                            <div class="jtg-series">
                                <a :href="'/sermons/' + sermon.hash_id" class="img popup-vimeo mb-3 d-flex justify-content-center align-items-center" :style="{ 'background-image': 'url(' + sermon.image_src + ')'}">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <span class="icon-play"></span>
                                    </div>
                                </a>
                                <div class="text">
                                    <h3><a :href="'/sermons/' + sermon.hash_id">{{ sermon.name }}</a></h3>
                                    <span class="position">Speaker: {{ sermon.speaker.fullname }}</span>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="showLoader">
                        <div class="col-md-12 mb-4">
                            <div class="card p-0">
                                <div class="card-body text-center">
                                    <i class="fa fa-spinner fa-spin fa-4x fa-fw"></i>
                                </div>
                            </div>
                        </div>
                    </template>
                    <template v-if="showNoData">
                        <div class="col-md-12 mb-4">
                            <div class="card p-0">
                                <div class="card-body text-center">
                                    <h3>No Messages found!</h3>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <show-more-sermons @filtered="setSermonData"></show-more-sermons>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['sermonList', 'sessionFilters'],

        data() {
            return {
                sermons: collect([]),

                shouldAnimate: false,

                showLoader: false,

                showNoData: false
            }
        },

        created() {
            if (this.sermonList.data.length == 0) {
                this.showNoData = true;
            }

            _.forEach(this.sermonList.data, (sermon) => {
                this.sermons.push(sermon);
            });
        },

        methods: {
            getSermonDateFormat(event) {
//                let starting_at = moment(event.starting_at, 'YYYY-MM-DD');
//                let ending_at = moment(event.ending_at, 'YYYY-MM-DD');
//                if (starting_at == ending_at) {
//                    return moment(event.starting_at).format('MMMM DD') + ' @ ' + moment(event.starting_at).format('hh:ssa');
//                } else {
//                    return moment(event.starting_at).format('MMMM DD') + ' - ' + moment(event.ending_at).format('MMMM DD YYYY');
//                }
            },

            emptySermonData() {
                this.showLoader = true;
                this.showNoData = false;

                this.$nextTick(()=>{
                    this.sermons = collect([]);
                })
            },

            setSermonData(data) {
                this.showLoader = false;

                if (data.total == 0) {
                    this.showNoData = true;
                } else {
                    this.showNoData = false;
                }

                this.shouldAnimate = true;
                _.forEach(data.data, (event, index) => {
                    this.$set(this.sermons.items, index, event);
                });
            }
        }
    }
</script>